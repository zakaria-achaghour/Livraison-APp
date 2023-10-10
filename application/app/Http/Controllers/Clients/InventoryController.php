<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use DataTables;
use App\Models\Product;
use App\Models\Parcel;
use App\Models\ParcelContent;
use App\Models\Inventory;
use Illuminate\Validation\Rule;


class InventoryController extends Controller
{
    //
    public function index() {
        return view('clients.inventory.index');
    }

    public function add() {
        return view('clients.inventory.add');
    }

    public function save(Request $request) {
        $user = $request->user();
        $variants = $request->products_variants == "on" ? true : false;

        if(!$variants) {
            $validator = Validator::make($request->all(), [
                'product_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'],
                'product_name' => ['required', 'string', 'min:5', 'max:255'],
                'product_ref' => ['required', 'string', 'min:5', 'max:255', 'unique:inventory,inventory_ref'],
                'product_qty' => ['required', 'integer', 'min:0', 'max:1000'],
                'product_notes' => ['nullable', 'string', 'max:1000'],
            ]);    
        }
        else {
            $validator = Validator::make($request->all(), [
                'product_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'],
                'product_name' => ['required', 'string', 'min:5', 'max:100'],
                'product_notes' => ['nullable', 'string', 'max:1000'],
                'variations' => ['required', 'array'],
                'variations.*.product_var_qty' => ['required', 'integer', 'min:0', 'max:1000'],
                'variations.*.product_var_name' => ['required', 'min:2', 'string', 'max:255'],
                'variations.*.product_var_ref' => ['required', 'min:5', 'string', 'max:255', 'unique:inventory,inventory_ref',
                    function ($attribute, $value, $fail) use ($request) {
                        $refs = array_column($request->variations, 'product_var_ref');
                        $counts = array_count_values($refs);

                        if (isset($counts[$value]) && $counts[$value] > 1) {
                            $fail(trans('validation.custom_var_ref.unique_array'));
                        }
                    }
                ]
            ]); 
        }

        $attributeNames = [
            'product_name' => __('Nom du produit'),
            'product_ref' => __('Réf. du produit'),
            'product_qty' => __('Quantité'),
            'product_notes' => __('Note du produit'),
            'variations' => __('Variantes')
        ];
    
        foreach ($request->variations as $index => $variante) {
            $attributeNames["variations.{$index}.product_var_qty"] = __('Quantité de la variante').' '.($index + 1);
            $attributeNames["variations.{$index}.product_var_name"] = __('Nom de la variante').' '.($index + 1);
            $attributeNames["variations.{$index}.product_var_ref"] = __('Réf. de la variante').' '.($index + 1);
        }

        $validator->setAttributeNames($attributeNames);

        if ($validator->fails()) {
            $message = '<div class="d-flex flex-column" style="text-align: left;">';
            $message .= '<li class="d-flex align-items-center py-2"><span class="bullet bg-danger me-5"></span> ';
            $message .= implode('</li><li class="d-flex align-items-center py-2"><span class="bullet bg-danger me-5"></span> ', $validator->messages()->all());
            $message .= '</li></ul>';

            return Response::json([
                'success' => false, 
                'message' => $message
            ], 200);
        }

        // UPLOAD IMAGE
        $imageName = '';
        if ($request->hasFile('product_picture')) {
            $image = $request->file('product_picture');
            $imageName = time().'_'.rand(100,999).'_'.$image->getClientOriginalName();
            $image->move(public_path('images/inventory'), $imageName);
        }

        $product = new Product();
        $product->product_customer = $user->id;
        $product->product_name = $request->product_name;
        $product->product_desc = $request->product_notes;
        $product->product_pic = $imageName;
        $product->product_variant = $variants ? 1 : 0;
        $product->product_added_time = time();
        $product->save();
        $product->addProductHistory("NEW_PRODUCT_ADDED",$product->product_id, 0,0);

        if($variants) {
            foreach($request->variations as $variant) {
                $inventory = new Inventory();
                $inventory->inventory_product = $product->product_id;
                $inventory->inventory_customer = $user->id;
                $inventory->inventory_ref = $variant['product_var_ref'];
                $inventory->inventory_var_name = $variant['product_var_name'];
                $inventory->inventory_qty = 0;
                $inventory->inventory_qty_not_received = $variant['product_var_qty'];
                $inventory->inventory_variant = $product->product_variant;
                $inventory->inventory_added_time = time();
                $inventory->save();
                $product->addProductHistory("NEW_INVENTORY_ADDED",$inventory->inventory_id, $variant['product_var_qty'],0);
            }
        }
        else {
            $inventory = new Inventory();
            $inventory->inventory_product = $product->product_id;
            $inventory->inventory_customer = $user->id;
            $inventory->inventory_ref = $request->product_ref;
            $inventory->inventory_var_name = $request->product_name;
            $inventory->inventory_qty = 0;
            $inventory->inventory_qty_not_received = $request->product_qty;
            $inventory->inventory_variant = $product->product_variant;
            $inventory->inventory_added_time = time();
            $inventory->save();
            $product->addProductHistory("NEW_INVENTORY_ADDED",$inventory->inventory_id, $request->product_qty, 0);
        }

        return Response::json([
                'success' => true, 
                'message' => __('Le produit a été ajouté'),
                'redirect' => route('clients.inventory.index')
            ]);
    }

    public function delete(Request $request, $id) {
        $product = Product::where('product_id', $id)->where('product_customer', $request->user()->id)->first();

        if(empty($product)) {
            return Response::json(['success' => false, 'message' => __('Produit introuvable')]);
        }

        if($product->product_received == 1) {
            return Response::json(['success' => false, 'message' => __('Impossible de supprimer ce produit')]);
        }

        if($product->product_pic != '')
            unlink(public_path('images/inventory/'.$product->product_pic));
        $product->delete();

        return Response::json(['success' => true, 'message' => __('Le produit a été supprimé')]);
    }

    public function edit(Request $request, $id) {
        $product = Product::where('product_id', $id)->where('product_customer', $request->user()->id)->first();

        if(empty($product))
            abort(404);

        return view('clients.inventory.edit')->with('product', $product);
    }

    public function update(Request $request) {
        $user = $request->user();
        $product = Product::where('product_id', $request->product_id)->where('product_customer', $request->user()->id)->first();

        if(empty($product)) {
            return Response::json(['success' => false, 'message' => __('Produit introuvable')]);
        }

        if($product->product_variant == 0) {
            $validator = Validator::make($request->all(), [
                'product_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'],
                'product_name' => ['required', 'string', 'min:5', 'max:255'],
                'product_qty' => ['required', 'integer', 'min:0', 'max:1000'],
                'product_notes' => ['nullable', 'string', 'max:1000']
            ]);

            $validator->setAttributeNames([
                'product_name' => __('Nom du produit'),
                'product_qty' => __('Quantité'),
                'product_notes' => __('Note du produit'),
            ]);
        }
        else {
            $validator = Validator::make($request->all(), [
                'product_picture' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:5120'],
                'product_name' => ['required', 'string', 'min:5', 'max:100'],
                'product_notes' => ['nullable', 'string', 'max:1000'],
                'product_var_qty.*' => ['required', 'integer', 'min:0', 'max:1000'],
                'product_var_name.*' => ['required', 'min:2', 'string', 'max:255']
            ]);

            $attributeNames = [];
            $attributeNames["product_name"] = __('Nom du produit');
            foreach ($request->product_var_qty as $index => $variante) {
                $attributeNames["product_var_qty.{$index}"] = __('Quantité de la variante').' '.($index + 1);
                $attributeNames["product_var_name.{$index}"] = __('Nom de la variante').' '.($index + 1);
            }

            $validator->setAttributeNames($attributeNames); 
        }


        if ($validator->fails()) {
            $message = '<div class="d-flex flex-column" style="text-align: left;">';
            $message .= '<li class="d-flex align-items-center py-2"><span class="bullet bg-danger me-5"></span> ';
            $message .= implode('</li><li class="d-flex align-items-center py-2"><span class="bullet bg-danger me-5"></span> ', $validator->messages()->all());
            $message .= '</li></ul>';

            return Response::json([
                'success' => false, 
                'message' => $message
            ], 200);
        }

        // UPLOAD IMAGE
        if($request->product_picture_remove == 1 && $product->product_pic != "") {
            // DELET THE OLD ONE
            if ($product->product_pic != "" && file_exists(public_path('images/inventory/'.$product->product_pic)))
                unlink(public_path('images/inventory/'.$product->product_pic));

            // UPDATE THE NEW ON DATABASE
            $product->product_pic = "";
        }

        if ($request->hasFile('product_picture')) {
            // UPLOAD THE NEW ONE
            $image = $request->file('product_picture');
            $imageName = time().'_'.rand(100,999).'_'.$image->getClientOriginalName();
            $image->move(public_path('images/inventory'), $imageName);

            // DELET THE OLD ONE
            if ($product->product_pic != "" && file_exists(public_path('images/inventory/'.$product->product_pic)))
                unlink(public_path('images/inventory/'.$product->product_pic));

            // UPDATE THE NEW ON DATABASE
            $product->product_pic = $imageName;
        }

        

        // PROCESS THE PRODUCT UPADTE
        $product->product_name = $request->product_name;
        $product->product_desc = $request->product_notes;
        $product->save();

        if($product->product_variant == 0) {
            $inventory = Inventory::where('inventory_product', $product->product_id)
                ->first();

            $inventory->inventory_var_name = $request->product_name;
            $inventory->inventory_qty_not_received = $request->product_qty;
            $inventory->save();
        }
        else {
            foreach($request->product_ref as $key => $inventory_ref) {
                $inventory = Inventory::where('inventory_product', $product->product_id)
                    ->where('inventory_ref', $inventory_ref)
                    ->first();

                $inventory->inventory_var_name = $request->product_var_name[$key];
                $inventory->inventory_qty_not_received = $request->product_var_qty[$key];
                $inventory->save();
            }    
        }
        

        return Response::json([
                'success' => true, 
                'message' => __('Le produit a été modifié')
            ]);
    }

    public function loadForParcel(Request $request) {
        $products = Product::select(['product_id', 'product_pic', 'product_name', 'product_variant'])
                        ->with(['avalaible_inventory' =>  function ($query) {
                            $query->select('inventory_product', 'inventory_var_name', 'inventory_ref', 'inventory_qty', 'inventory_id')->selectRaw('0 as is_adding, 0 as is_pulsing');
                        }])
                        ->whereHas('avalaible_inventory')
                        ->where('product_customer', $request->user()->id)
                        ->get();

        return Response::json(['products' => $products]);
    }
    
    public function parcelProducts(Request $request, $id) {
        /*$products = ParcelContent::where('parcel_content_customer_id', $request->user()->id)->where('parcel_content_parcel_id', $id)->get()->groupBy('parcel_content_inventory_id');*/
        $tmp_products = Inventory::select(['inventory_id', 'inventory_product', 'inventory_var_name', 'inventory_ref', 'inventory_qty'])->selectRaw('0 as is_removing, 0 as is_pulsing')->whereHas('affected_content', function($query) use ($request, $id) {
            $query->where('parcel_content_customer_id', $request->user()->id)->where('parcel_content_parcel_id', $id);
        })->with(['affected_content' => function($query) use ($request, $id) {
            $query->select(['parcel_content_id', 'parcel_content_time', 'parcel_content_inventory_id', 'parcel_content_remarque'])->where('parcel_content_customer_id', $request->user()->id)->where('parcel_content_parcel_id', $id);
        }])->with(['product' => function($query) {
            $query->select(['product_id', 'product_name', 'product_pic', 'product_variant']);
        }])->get()->groupBy('product');

        $products = [];
        foreach($tmp_products as $product => $inventory) {
            $product = json_decode($product);
            $product->inventory = $inventory;
            $products[] = $product;
        }

        return Response::json(['products' => $products]);
    }

    public function addParcelProducts(Request $request) {
        $user = $request->user();
        $parcel = Parcel::where('parcel_id', $request->parcel_id)
            ->where('parcel_customer', $user->id)
            ->first();

        if(empty($parcel)) {
            return Response::json(['success' => false, 'message' => __('Colis introuvable')]);
        }

        if($parcel->parcel_status != 'NEW_PARCEL' || $parcel->stock_ready != 0) {
            return Response::json(['success' => false, 'message' => __('Impossible de modifier ce colis')]);
        }

        $inventory = Inventory::with('product')->where('inventory_customer', $user->id)->where('inventory_id', $request->inventory_id)->first();

        if(empty($inventory)) {
            return Response::json(['success' => false, 'message' => __('Produit introuvable')]);
        }

        if($inventory->inventory_qty <= 0) {
            return Response::json(['success' => false, 'message' => __('Ce produit est en rupture de stock.')]);
        }

        $parcel_content = new ParcelContent();
        $parcel_content->parcel_content_customer_id = $user->id;
        $parcel_content->parcel_content_parcel_id = $parcel->parcel_id;
        $parcel_content->parcel_content_inventory_id = $inventory->inventory_id;
        $parcel_content->parcel_content_product_id = $inventory->inventory_product;
        $parcel_content->parcel_content_product_name = $inventory->product != null ? $inventory->product->product_name : '';
        $parcel_content->parcel_content_product_pic = $inventory->product != null ? $inventory->product->product_pic : '';
        $parcel_content->parcel_content_variant_name = $inventory->inventory_var_name;
        $parcel_content->parcel_content_variant_ref = $inventory->inventory_ref;
        $parcel_content->parcel_content_remarque = $inventory->inventory_remarque;
        $parcel_content->parcel_content_time = time();
        $parcel_content->save();

        $inventory->inventory_qty = $inventory->inventory_qty - 1;
        $inventory->save();

        return Response::json(['success' => true, 'message' => __('Ce produit a été ajouté.')]);
    }

    public function removeParcelProducts(Request $request) {
        $user = $request->user();
        $parcel = Parcel::where('parcel_id', $request->parcel_id)
            ->where('parcel_customer', $user->id)
            ->first();

        if(empty($parcel)) {
            return Response::json(['success' => false, 'message' => __('Colis introuvable')]);
        }

        if($parcel->parcel_status != 'NEW_PARCEL' || $parcel->stock_ready != 0) {
            return Response::json(['success' => false, 'message' => __('Impossible de modifier ce colis')]);
        }

        $inventory = Inventory::where('inventory_customer', $user->id)->where('inventory_id', $request->inventory_id)->first();

        if(empty($inventory)) {
            return Response::json(['success' => false, 'message' => __('Produit introuvable')]);
        }

        $parcel_content = ParcelContent::where('parcel_content_customer_id', $user->id)->where('parcel_content_parcel_id', $parcel->parcel_id)->where('parcel_content_inventory_id', $inventory->inventory_id)->first();

        if(empty($parcel_content)) {
            return Response::json(['success' => false, 'message' => __('Impossible de supprimer ce produit')]);
        }

        $parcel_content->delete();
        $inventory->inventory_qty = $inventory->inventory_qty + 1;
        $inventory->save();

        return Response::json(['success' => true, 'message' => __('Ce produit a été supprimé.')]);
    }

    public function load(Request $request) {
        $data = Product::select("*")->where('product_customer', $request->user()->id);

        if(!$request->get('order')) {
            $data->orderBy('product_added_time', 'desc');
        }

        return Datatables::of($data)->addIndexColumn()
            ->filter(function ($query) use ($request) {
                if ($request->has('search') && isset($request->search['value']) && !empty($request->search['value'])) {
                    $query->where(function ($query) use ($request) {
                        $query->whereHas('inventory', function ($query) use ($request) {
                            $query->where('inventory_var_name', 'like', "%" . $request->search['value'] . "%")->orWhere('inventory_ref', 'like', "%" . $request->search['value'] . "%");
                        })->orWhere('product_name', 'like', "%" . $request->search['value'] . "%")->orWhere('product_desc', 'like', "%" . $request->search['value'] . "%");
                    });
                }

                if($request->has('filters')) {

                    $filters = $request->get('filters');



                    if(isset($filters['product_status']) && !empty($filters['product_status'])) {
                        $query->where('product_received', $filters['product_status'] == "-1" ? 0 : 1);
                    }
                }
            })
            ->addColumn('checkbox', function($row){
                return '<div class="form-check form-check-sm form-check-custom form-check-solid placeholder-loader">
                            <input class="form-check-input" type="checkbox" value="'.$row->product_id.'" />
                        </div>';
            })
            ->addColumn('product_name', function($row){
                $image = asset('assets/clients/media/svg/files/blank-image.svg');
                if(!empty($row->product_pic)) $image = asset("images/inventory/".rawurlencode($row->product_pic));

                $name = '<div class="d-flex align-items-center justify-content-center justify-content-md-start">
                        <div class="symbol symbol-60px symbol-2by3 placeholder-loader">
                            <span class="symbol-label" style="background-image:url('.$image.');"></span>
                        </div>
                        <div class="ms-5">
                            <span class="text-gray-800 text-hover-primary fs-5 fw-bold d-block text-capitalize placeholder-loader">'.$row->product_name.'</span>';

                if($row->product_variant == 1) {
                    $name .= '<span class="badge badge-success placeholder-loader">'. __("Produit avec variantes") .'</span>';
                }
                else {
                    $name .= '<span class="badge badge-primary placeholder-loader">'. __("Produit simple") .'</span>';
                }
                $name .= '</div></div>';

                return $name;
            })
            ->addColumn('product_qty', function($row){
                $inventory = '';
                foreach($row->inventory as $key => $inv) {
                    $inventory .= '<div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
                        <div class="me-5">
                            <span class="text-gray-800 fw-bold text-hover-primary fs-7 placeholder-loader">#.'.$inv->inventory_ref.'</span>
                            <span class="text-gray-400 fw-semibold fs-8 d-block text-start ps-0 placeholder-loader">'.$inv->inventory_var_name.'</span>   
                        </div>
                        <div class="d-flex align-items-center"> 
                            <div class="m-0">
                                <span class="badge badge-light-success fs-4 me-1 placeholder-loader" title="'.__("Quantité Reçu").'" data-bs-toggle="tooltip" data-bs-placement="top">                                
                                    <i class="ki-outline ki-arrow-up fs-4 text-success ms-n1"></i>                                                              
                                    '.$inv->inventory_qty.'
                                </span>
                                <span class="badge badge-light-warning fs-4 placeholder-loader" title="'.__("Quantité Non Reçu").'" data-bs-toggle="tooltip" data-bs-placement="top">                                
                                    <i class="ki-outline ki-arrow-down fs-4 text-warning ms-n1"></i>                                                              
                                    '.$inv->inventory_qty_not_received.'
                                </span> 
                            </div>  
                        </div>
                    </div>';
                    if(count($row->inventory) != ($key + 1))
                        $inventory .= '<div class="separator mb-2 border-3"></div>';
                }

                return $inventory.'</div>';
            })
            ->addColumn('action', function($row){
                $action = '<div class="d-flex justify-content-center justify-content-md-end flex-shrink-0">';


                $action .= '<button class="btn btn-icon btn-success btn-sm me-1 info placeholder-loader" data-id="'.$row->product_id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('Voir').'">
                                <i class="ki-outline ki-eye fs-2"></i></button>';
                $action .= '
                    <a href="'.route('clients.inventory.edit', ['id' => $row->product_id]).'" class="btn btn-icon btn-primary btn-sm me-1 placeholder-loader" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('Modifier').'">
                        <i class="ki-outline ki-pencil fs-2"></i></a>';

                if($row->product_received == 0) {
                    $action .= '<button class="btn btn-icon btn-danger btn-sm me-1 remove placeholder-loader" data-kt-indicator="off" data-id="'.$row->product_id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('Supprimer').'">
                            <span class="indicator-label"><i class="ki-outline ki-trash fs-2"></i></span>
                            <span class="indicator-progress ">
                                <span class="spinner-border spinner-border-sm align-middle"></span>
                            </span>
                        </button>';    
                }
                

                $action .= '</div>';

                return $action;
            })
            ->smart(false)
            ->orderColumn('parcel_code', function ($query, $order) {$query->orderBy('parcel_code', $order);})
            ->rawColumns(['checkbox', 'product_name', 'product_qty', 'parcel_situation', 'parcel_status', 'parcel_price',  'action'])
            ->make(true);
    }
}
