<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use DataTables;
use App\Models\Parcel;
use App\Models\ParcelContent;
use App\Models\ParcelEdit;
use App\Models\ParcelHistory;
use App\Models\ParcelCallHistory;
use App\Models\City;
use App\Models\Inventory;


class ParcelController extends Controller
{
    public function index(Request $request) {
        return view('clients.parcels.index');
    }

    public function add(Request $request) {
        return view('clients.parcels.add');
    }

    public function edit(Request $request, $id) {
        $parcel = Parcel::where('parcel_id', $id)->where('parcel_customer', $request->user()->customers_id)->first();

        if(empty($parcel) || $parcel->parcel_status != 'NEW_PARCEL')
            abort(404);

        if($parcel->parcel_from_stock == 1) {
            return view('clients.parcels.edit_stock')->with('parcel', $parcel);
        }

        return view('clients.parcels.edit')->with('parcel', $parcel);
    }

    public function loadCities(Request $request) {
        $cities = City::selectRaw("id, name as text")->where('active', 1)->orderBy('name')->get();

        return Response::json($cities);
    }

    public function tracking(Request $request, $id){
        $history = ParcelHistory::whereHas('parcel', function ($query) use ($request) {
                $query->where('parcel_customer', $request->user()->id);
            })
            ->select(['parcel_history_id', 'parcel_history_parcel', 'parcel_history_comment', 'parcel_history_situation', 'parcel_history_status', 'parcel_history_status_second', 'parcel_movments', 'parcel_history_time', 'parcel_history_data'])
            ->with(['movmentsZone' => function ($query) {
                $query->select('zone_id', 'zone_name');
            }])
            ->where('parcel_history_parcel', $id)
            ->get();

        $historyCall = ParcelCallHistory::whereHas('parcel', function ($query) use ($request) {
                $query->where('parcel_customer', $request->user()->id);
            })
            ->where('parcel_call_history_parcel', $id)
            ->get();

        return Response::json([
            'history' => $history,
            'historyCall' => $historyCall,
            'status' => allStatus()
        ]);
    }

    public function informations(Request $request, $id) {
        $parcel = Parcel::select(['parcel_id', 'parcel_code', 'parcel_product_name', 'parcel_product_qty', 'parcel_receiver', 'parcel_phone', 'parcel_city', 'parcel_address', 'parcel_note', 'parcel_from_stock'])
            ->with(['city' => function ($query) {
                        $query->select('id', 'name');
                    }])
            ->with(['content', 'content.inventory', 'content.product'])
            ->where('parcel_id', $id)
            ->where('parcel_customer', $request->user()->id)
            ->first();

        if($parcel->parcel_from_stock == 1) {
            $products = $parcel->content->groupBy('product');
            $new_products = [];
            foreach($products as $product => $content) {
                $product = json_decode($product);
                $new_product = (object) [
                    'product_name' => $product->product_name,
                    'product_pic' => $product->product_pic,
                    'product_variant' => $product->product_variant,
                    'inventory' => []
                ];

                $inventories = $content->groupBy('inventory');
                foreach($inventories as $inventory => $content2) {
                    $inventory = json_decode($inventory);
                    $new_product->inventory[] = (object) [
                        'inventory_ref' => $inventory->inventory_ref,
                        'inventory_var_name' => $inventory->inventory_var_name,
                        'inventory_qty' => count($content2)
                    ];
                }

                $new_products[] = $new_product;
            }

            $parcel->unsetRelation('content');
            unset($parcel->parcel_product_name, $parcel->parcel_product_qty);
            $parcel->products = $new_products;
        }

        return Response::json($parcel);
    }

    public function livreur(Request $request, $id) {
        $parcel = Parcel::select(['parcel_livreur', 'en_agence', 'parcel_city', 'parcel_status'])
            ->where('parcel_id', $id)
            ->where('parcel_customer', $request->user()->id)
            ->with([
                'livreur' => function($query) {
                    $query->select(['users_id', 'users_name', 'users_phone']);
                },
                'city' => function($query) {
                    $query->select(['id', 'name', 'code']);
                },
                'city.zones' => function($query) {
                    $query->select(['zone_id', 'zone_name']);
                },
                'city.zones.moderator' => function($query) {
                    $query->select(['users_city', 'users_name', 'users_phone']);
                }])
            ->first();

        if(empty($parcel) || !in_array($parcel->parcel_status, ['IN_PROGRESS', 'DISTRIBUTION'])) {
            return null;
        }

        return Response::json($parcel);
    }

    public function getCityTarfis(Request $request) {
        /*$tarifs = \Auth::user()->tarifs($request->city_id)->selectRaw('delivered_price as fees,returned_price as retrun,refused_price as refuse')->get();

        if($tarifs->isEmpty()) {
            $city = City::select(['fees', 'return', 'refuse'])->where('id', $request->city_id)->first();

            if(empty($city)) {
                return Response::json(['fees' => 0, 'return' => 0, 'refuse' => 0]);
            }

            return Response::json($city);
        }

        
        return Response::json($tarifs);*/
        return Response::json($request->user()->getCityFees($request->city_id));
    }

    public function save(Request $request) {
        $validator = Validator::make($request->all(), [
            'parcel_code' => ['nullable', 'string', 'min:8', 'max:100', 'unique:parcel,parcel_code'],
            'parcel_receiver' => ['required', 'string', 'min:2', 'max:50'],
            'parcel_phone' => ['required', 'regex:/^(05|06|07|08) \d{2} \d{2} \d{2} \d{2}$/'],
            'parcel_prd_name' => ['nullable','string', 'max:100'],
            'parcel_prd_qty' => ['required', 'numeric', 'min:1', 'max:1000'],
            'parcel_price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'parcel_city' => ['required', 'exists:cities,id'],
            'parcel_address' => ['required', 'string', 'max:1000'],
            'parcel_note' => ['nullable', 'string', 'max:1000'],
        ], [
            'parcel_phone.regex' => __('Le format du téléphone est invalide.'),
            'parcel_price.regex' => __('Le format du prix est invalide.')
        ]);

        $validator->setAttributeNames([
            'parcel_code' => __('Code suivi'),
            'parcel_receiver' => __('Destinataire'),
            'parcel_phone' => __('Téléphone'),
            'parcel_prd_name' => __('Marchandise'),
            'parcel_prd_qty' => __('Quantité'),
            'parcel_price' => __('Prix'),
            'parcel_city' => __('Ville'),
            'parcel_address' => __('Adresse'),
            'parcel_note' => __('Commentaire'),
        ]);

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

        // GET TARIFS
        $user = \Auth::user();
        $tarifs = $user->tarifs($request->parcel_city)->selectRaw('delivered_price as fees,returned_price as retrun,refused_price as refuse')->get();

        if($tarifs->isEmpty()) {
            $tarifs = City::select(['fees', 'return', 'refuse'])->where('id', $request->parcel_city)->first();
        }

        $parcel = new Parcel();        
        $parcel->parcel_receiver = $request->parcel_receiver;
        $parcel->parcel_phone = $request->parcel_phone;
        $parcel->parcel_product_name = $request->parcel_prd_name;
        $parcel->parcel_product_qty = $request->parcel_prd_qty;
        $parcel->parcel_price = $request->parcel_price;
        $parcel->parcel_city = $request->parcel_city;
        $parcel->parcel_address = $request->parcel_address;
        $parcel->parcel_note = $request->parcel_note;
        $parcel->parcel_delivered_fees = $tarifs->fees;
        $parcel->parcel_returned_fees = $tarifs->return;
        $parcel->parcel_refused_fees = $tarifs->refuse;
        $parcel->parcel_replace = $request->parcel_replace == "on" ? 1 : 0;
        $parcel->parcel_open = $request->parcel_open == "on" ? 1 : 0;
        if($user->customers_stock == 1) {
            $parcel->parcel_from_stock = $request->parcel_stock_check == "on" ? 1 : 0;    
        }
        $parcel->parcel_situation = 'NOT_PAID';
        $parcel->parcel_status = 'NEW_PARCEL';
        $parcel->parcel_customer = $user->customers_id;
        $parcel->parcel_time = time();
        $parcel->save();
        $parcel->addParcelHistory(0, "NOT_PAID", "NEW_PARCEL", 0);

        // GENERATE CODE SUIVI
        if(!empty($request->parcel_code)) {
            $parcel->parcel_code = $request->parcel_code;    
        }
        else{
            $city = City::find($parcel->parcel_city);
            $parcel->parcel_code = $parcel->generateCode($city->code);
        }
        $parcel->parcel_code_interne = $parcel->generateCodeInerne();
        $parcel->save();
        

        return Response::json([
                "success" => true,
                "message" => __('Le colis a été ajouter'),
                "redirect" => $parcel->parcel_from_stock == 1 ? route('clients.parcels.edit', ['id' => $parcel->parcel_id]).'?active=products' : route('clients.parcels.waiting-pick-up')
            ]);
    }

    public function update(Request $request) {
        $user = $request->user();
        $parcel = Parcel::where('parcel_id', $request->parcel_id)
            ->where('parcel_customer', $user->id)
            ->first();

        if(empty($parcel)) {
            return Response::json(['success' => false, 'message' => __('Colis introuvable')]);
        }

        if($parcel->parcel_status != 'NEW_PARCEL') {
            return Response::json(['success' => false, 'message' => __('Impossible de modifier ce colis')]);
        }

        $attributeValidation = [
            'parcel_code' => ['nullable', 'string', 'min:8', 'max:100', 'unique:parcel,parcel_code,'.$request->parcel_id.',parcel_id'],
            'parcel_receiver' => ['required', 'string', 'min:2', 'max:50'],
            'parcel_phone' => ['required', 'regex:/^(05|06|07|08) \d{2} \d{2} \d{2} \d{2}$/'],
            'parcel_price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
            'parcel_city' => ['required', 'exists:cities,id'],
            'parcel_address' => ['required', 'string', 'max:1000'],
            'parcel_note' => ['nullable', 'string', 'max:1000']
        ];

        $attributeNames = [
            'parcel_code' => __('Code suivi'),
            'parcel_receiver' => __('Destinataire'),
            'parcel_phone' => __('Téléphone'),
            'parcel_price' => __('Prix'),
            'parcel_city' => __('Ville'),
            'parcel_address' => __('Adresse'),
            'parcel_note' => __('Commentaire')
        ];

        if($parcel->parcel_from_stock == 0) {
            $attributeValidation['parcel_prd_name'] = ['nullable','string', 'max:100'];
            $attributeValidation['parcel_prd_qty'] = ['required', 'numeric', 'min:1', 'max:1000'];
            $attributeNames['parcel_prd_name'] = __('Marchandise');
            $attributeNames['parcel_prd_qty'] = __('Quantité');
        }

        $validator = Validator::make($request->all(), $attributeValidation, [
            'parcel_phone.regex' => __('Le format du téléphone est invalide.'),
            'parcel_price.regex' => __('Le format du prix est invalide.')
        ]);

        $validator->setAttributeNames($attributeNames);

        if ($validator->fails()) {
            $message = '<div class="d-flex flex-column" style="text-align: left;">';
            $message .= '<li class="d-flex align-items-center py-2"><span class="bullet bg-danger me-5"></span> ';
            $message .= implode('</li><li class="d-flex align-items-center py-2"><span class="bullet bg-danger me-5"></span> ', $validator->messages()->all());
            $message .= '</li></ul>';

            return Response::json([
                'success' => false, 
                'message' => $message,
            ], 200);
        }

        // GET TARIFS
        $tarifs = $user->tarifs($request->parcel_city)->selectRaw('delivered_price as fees,returned_price as retrun,refused_price as refuse')->get();

        if($tarifs->isEmpty()) {
            $tarifs = City::select(['fees', 'return', 'refuse'])->where('id', $request->parcel_city)->first();
        }

        $parcel->parcel_receiver = $request->parcel_receiver;
        $parcel->parcel_phone = $request->parcel_phone;

        if($parcel->parcel_from_stock == 0) {
            $parcel->parcel_product_name = $request->parcel_prd_name;
            $parcel->parcel_product_qty = $request->parcel_prd_qty;
        }

        $parcel->parcel_price = $request->parcel_price;
        $parcel->parcel_city = $request->parcel_city;
        $parcel->parcel_address = $request->parcel_address;
        $parcel->parcel_note = $request->parcel_note;
        $parcel->parcel_delivered_fees = $tarifs->fees;
        $parcel->parcel_returned_fees = $tarifs->return;
        $parcel->parcel_refused_fees = $tarifs->refuse;
        $parcel->parcel_replace = $request->parcel_replace == "on" ? 1 : 0;
        $parcel->parcel_open = $request->parcel_open == "on" ? 1 : 0;
        $parcel->save();

        // GENERATE CODE SUIVI
        if(!empty($request->parcel_code)) {
            $parcel->parcel_code = $request->parcel_code;    
        }
        /*else{
            $city = City::find($parcel->parcel_city);
            $parcel->parcel_code = $parcel->generateCode($city->code);
        }*/
        $parcel->save();
        
        if($parcel->parcel_from_stock == 0) {
            $redirect = route('clients.parcels.waiting-pick-up');
        }
        else {
            $redirect = route('clients.parcels.from-inventory');
        }

        return Response::json([
                "success" => true,
                "message" => __('Le colis a été modifié'),
                'redirect' => $redirect
            ]);
    }

    public function delete(Request $request, $id) {
        $user = $request->user();
        $parcel = Parcel::where('parcel_id', $id)->where('parcel_customer', $user->customers_id)->first();

        if(empty($parcel)) {
            return Response::json(['success' => false, 'message' => __('Colis introuvable')]);
        }

        if($parcel->parcel_status != 'NEW_PARCEL') {
            return Response::json(['success' => false, 'message' => __('Impossible de supprimer ce colis')]);
        }

        if($parcel->parcel_from_stock == 1) {
            $contents = ParcelContent::where('parcel_content_parcel_id', $parcel->parcel_id)->where('parcel_content_customer_id', $user->id)->get();

            foreach($contents as $content) {
                $inventory = Inventory::where('inventory_customer', $user->id)->where('inventory_id', $content->parcel_content_inventory_id)->increment('inventory_qty', 1);
                $content->delete();
            }
        }
        $parcel->delete();

        return Response::json(['success' => true, 'message' => __('Le colis a été supprimé')]);
    }

    public function load(Request $request) {
        $data = Parcel::select("*")->with('city')->where('parcel_customer', \Auth()->user()->customers_id)->whereNotIn('parcel_status', ['NEW_PARCEL', 'WAITING_PICKUP']);

        if(!$request->get('order')) {
            $data->orderBy('parcel_time', 'desc');
        }

        return Datatables::of($data)->addIndexColumn()
            ->filter(function ($query) use ($request) {
                if ($request->has('search') && isset($request->search['value']) && !empty($request->search['value'])) {
                    $query->where(function ($query) use ($request) {
                        $query->where('parcel_code', 'like', "%" . $request->search['value'] . "%")->orWhere('parcel_receiver', 'like', "%" . $request->search['value'] . "%")->orWhere('parcel_phone', 'like', "%" . $request->search['value'] . "%");
                    });
                }

                if($request->has('filters')) {
                    $filters = $request->get('filters');

                    if(isset($filters['parcel_situation']) && !empty($filters['parcel_situation']))
                        $query->where('parcel_situation', $filters['parcel_situation']);

                    if(isset($filters['parcel_status']) && !empty($filters['parcel_status']))
                        $query->where(function ($query) use($filters) {
                            $query->where('parcel_status', $filters['parcel_status'])->orWhere('parcel_status_second', $filters['parcel_status']);
                        });

                    if(isset($filters['parcel_city']) && !empty($filters['parcel_city']))
                        $query->where('parcel_city', $filters['parcel_city']);

                    if(isset($filters['parcel_type_date']) && !empty($filters['parcel_type_date'])) {
                        $date = explode(' - ', $filters['parcel_date']);
                        $date_from = strtotime($date[0]." 00:00");
                        $date_to = strtotime($date[1]." 23:59:60");
                        $query->where($filters['parcel_type_date'], '>=', $date_from);
                        $query->where($filters['parcel_type_date'], '<=', $date_to);
                        //$query->orderBy($filters['parcel_type_date'], 'desc');
                    }
                }
            })
            ->addColumn('checkbox', function($row){
                return '<div class="form-check form-check-sm form-check-custom form-check-solid placeholder-loader">
                            <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                        </div>';
            })
            ->addColumn('parcel_code', function($row){
                $column = '<b class="text-uppercase placeholder-loader">'.$row->parcel_code.'</b>';
                

                if(!empty($row->parcel_amana_code))
                    $column .= '<br/>'.$row->parcel_amana_code;



                if($row->parcel_from_stock == 1)
                    $column .= '
                    <br/><span class="badge badge-success placeholder-loader"><i class="ki-solid ki-logistic text-white me-1"></i>'. __('Stock') .'</span>
                        ';
                else
                    $column .= '
                    <br/><span class="badge badge-info placeholder-loader"><i class="ki-solid ki-cube-2 text-white me-1"></i>'. __('Normal') .'</span>
                        ';

                if($row->parcel_replace == 1)
                    $column .='<span class="badge badge-warning me-1 placeholder-loader" data-bs-toggle="tooltip" data-bs-placement="bottom" title="'. __("Colis à remplacer") .'"><i class="ki-solid ki-arrow-right-left text-white"></i></span>'; 

                if($row->parcel_edited == 1)
                    $column .= '<span class="badge badge-primary placeholder-loader" data-bs-toggle="tooltip" data-bs-placement="bottom" title="'. __("Colis a été modifié") .'"><i class="ki-solid ki-pencil text-white"></i></span>';

                return $column;
            })
            ->addColumn('parcel_receiver', function($row){
                $column = '<div class="d-flex align-items-center justify-content-center justify-content-md-start">
                        <div class="symbol symbol-circle symbol-40px me-2 placeholder-loader">
                            <div class="symbol-label fs-5 fw-semibold bg-success text-inverse-success">'.$row->getAvatarLetters().'</div>
                        </div>
                        <div class="me-5">
                            <span class="text-gray-700 fw-bold text-hover-primary fs-8 placeholder-loader">'.$row->parcel_receiver.'</span>
                            <span class="text-gray-400 fw-semibold fs-7 d-block text-start ps-0 placeholder-loader">'.$row->parcel_phone.'</span> 

                            <span class="text-gray-800 fs-7 d-block text-start ps-0 placeholder-loader">'.$row->city->name ?? ''  .'</span>  
                        </div>
                    </div>';
                return $column;
            })
            ->addColumn('parcel_situation', function($row){
                return '<span class="badge badge-outline badge-lg placeholder-loader" style="color:'.Parcel::getStatus($row->parcel_situation)['color'].'; border:1px solid '.Parcel::getStatus($row->parcel_situation)['color'].'">'.Parcel::getStatus($row->parcel_situation)['text'].'</span>';
            })
            ->addColumn('parcel_status', function($row){
                /*$status = $row->parcel_status == 'IN_PROGRESS' ? $row->parcel_status_second : $row->parcel_status;
                $time = '';

                // ADD DATE TO "Les Colis Reporté ou Programmé"
                if($status == 'POSTPONED' || $status == 'PROGRAMMER') {
                    $history = $row->history()->where('parcel_history_status_second', $status)->orderBy('parcel_history_data', 'DESC')->first();
                    if(!empty($history) && !empty($history->parcel_history_data)) {
                        $link = ($status == 'POSTPONED') ? __('au') : __('pour le');
                        $time = ' '.$link.' '.date("d/m/Y", $history->parcel_history_data);
                    }
                }*/

                $status = $row->getStatusColored();
                return '<span class="badge badge-outline badge-lg placeholder-loader" style="color:'.$status['color'].'; border:1px solid '.$status['color'].'">'.$status['text'].'</span>';
            })
            ->addColumn('parcel_price', function($row){
                return '<span class="fs-5 text-gray-900 fw-bolder placeholder-loader">'.$row->parcel_price.' '.__('DH').'</span>';
            })
            ->addColumn('action', function($row){
                $actions = '<div class="d-flex justify-content-center justify-content-md-end flex-shrink-0">
                            <button class="btn btn-icon btn-info btn-sm me-1 track placeholder-loader" data-id="'.$row->parcel_id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('Suivi').'">
                                <i class="ki-outline ki-parcel-tracking fs-2"></i></button>
                            <button class="btn btn-icon btn-success btn-sm me-1 info placeholder-loader" data-id="'.$row->parcel_id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('Informations').'">
                                <i class="ki-outline ki-eye fs-2"></i></button>';

                $more_actions = '';
                if($row->canBeEdited()) {
                    $more_actions .= '<div class="menu-item"><a class="menu-link px-3 edit" data-id="'.$row->parcel_id.'">
                        <i class="ki-outline ki-pencil fs-2 me-2"></i> '.__('Demande de Modifier').'
                    </a></div>';    
                }

                if($row->en_agence == 0 && ($row->parcel_status == 'IN_PROGRESS' || $row->parcel_status == 'DISTRIBUTION')) {
                    $more_actions .= '<div class="menu-item"><a class="menu-link px-3 livreur" data-id="'.$row->parcel_id.'">
                        <i class="ki-outline ki-delivery fs-2 me-2"></i> '.__('Livreur').'
                    </a></div>';  
                }

                $actions .= '<button class="btn btn-icon btn-secondary btn-sm me-1 placeholder-loader" '.($more_actions != '' ? 'data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true"' : 'disabled').'>
                                <i class="ki-outline ki-dots-vertical fs-2"></i>
                            </button>';

                if($more_actions != '') {
                    $actions .= '<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px placeholder-loader" data-kt-menu="true">'.$more_actions.'</div>';
                }
                
                $actions .= '</div>';
                return $actions;
            })
            ->setRowClass(function ($row) {
                if($row->parcel_replace == 1)
                    return 'bg-light-warning';
                else if($row->parcel_edited == 1)
                    return 'bg-light-primary';
                return '';
            })
            ->smart(false)
            ->orderColumn('parcel_code', function ($query, $order) {$query->orderBy('parcel_code', $order);})
            ->rawColumns(['checkbox', 'parcel_code', 'parcel_receiver', 'parcel_situation', 'parcel_status', 'parcel_price',  'action'])
            ->make(true);
    }
}
