<?php

namespace App\Http\Controllers\Clients;

use App\Enums\PickupRequestEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Clients\PickupRequest\StorePickUpRequest;
use App\Models\City;
use App\Models\PickupRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use DataTables;
class PickupRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    { 
        $cities = City::where('active', 1)->get(['id', 'name']);
        $TYPE_OF_PICKUP_REQUEST = ['SIMPLE_PARCEL' => 'Parcel pickup'];
        return view("clients.requests.pickups.index", [
            "types" => $TYPE_OF_PICKUP_REQUEST,
            "cities" => $cities
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("clients.requests.pickups.add");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePickUpRequest $request)
    {
        $pickupRequest = new PickupRequest();
        $pickupRequest->pickup_request_customer = Auth::id();
        $pickupRequest->pickup_request_type = $request->typeOfPickup;
        $pickupRequest->pickup_request_phone = $request->phone;
        $pickupRequest->pickup_request_address = $request->address;
        $pickupRequest->pickup_request_note = $request->note;
        $pickupRequest->pickup_request_statut = PickupRequestEnum::NEW;
        $pickupRequest->pickup_request_city = $request->city;
        $pickupRequest->save();

        return Response::json([
            'success' => true, 
            'message' => __('The Collection added succesfully')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function load(Request $request)
    {
        $data = PickupRequest::select("*")
                              ->where("pickup_request_customer", Auth::id());
        // if(!$request->get('order')) {
        //     $data->orderByRaw('ifnull(pickup_request_time,created_at)', 'desc');
        // }

        return Datatables::of($data)->addIndexColumn()
            // ->filter(function ($query) use ($request) {
            //     if ($request->has('search') && isset($request->search['value']) && !empty($request->search['value'])) {
            //         $query->where('pickup_request_note', 'LIKE', '%'.$request->search['value'].'%');
            //     }

            //     if($request->has('filters')) {
            //         $filters = $request->get('filters');

            //         if(isset($filters['type'])) {
            //             $query->where('pickup_request_type', $filters['type']);
            //         }

            //         if(isset($filters['date']) && !empty($filters['date'])) {
            //             $date = explode(' - ', $filters['date']);
            //             $date_from = strtotime($date[0]." 00:00");
            //             $date_to = strtotime($date[1]." 23:59:60");
            //             $query->whereRaw('ifnull(pickup_request_time,created_at)', '>=', $date_from);
            //             $query->whereRaw('ifnull(pickup_request_time,created_at)', '<=', $date_to);
            //         }
            //     }
            // })
            ->addColumn('checkbox', function($row){
                return '<div class="form-check form-check-sm form-check-custom form-check-solid placeholder-loader">
                            <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                        </div>';
            })
            // ->addColumn('delivery_note_ref', function($row) {
            //     return '<a href="#" class="badge fs-5 badge-outline badge-info placeholder-loader">'.$row->delivery_note_ref.'</a>';
            // })
            // ->addColumn('delivery_note_time', function($row) {
            //     $span  = '<span class="text-gray-900 fs-5 placeholder-loader">'.date("d/m/Y", $row->delivery_note_time).'</span><br/>';
            //     $span .= '<span class="fw-bolder text-gray-500 fs-6 placeholder-loader">'.__('à').' '.date("H:i", $row->delivery_note_time).'</span>';

            //     return  $span;
            // })
            // ->addColumn('delivery_note_delivered', function($row) {
            //     if($row->delivery_note_delivered == 1) {
            //         return '<span class="badge badge-success fs-6 placeholder-loader">'.__('Reçu').'</span>';
            //     }
            //     else {
            //         return '<span class="badge badge-primary fs-6 placeholder-loader">'.__('Nouveau').'</span>';
            //     }
            // })
            // ->addColumn('delivery_parcels', function($row) {
            //     return '<span class="badge badge-circle badge-primary placeholder-loader fs-5 p-5">'.$row->parcels->count().'</span>';

            // })
            // ->addColumn('action', function($row){
            //     $actions = '<div class="d-flex justify-content-center justify-content-md-end flex-shrink-0">
            //                 <button class="btn btn-icon btn-success btn-sm me-1 info placeholder-loader" data-id="'.$row->parcel_id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('Voir').'">
            //                     <i class="ki-outline ki-eye fs-2"></i></button>';
            //     $actions .= '</div>';
            //     return $actions;
            // })

            ->smart(false)
            ->rawColumns(['checkbox', 'pickup_request_type', 'pickup_request_statut', 'pickup_request_time', 'pickup_request_phone', 'pickup_request_address', 'action'])
            // ->orderColumn('delivery_note_ref', function ($query, $order) {$query->orderBy('parcel_code', $order);})
            // ->rawColumns(['checkbox', 'delivery_note_ref', 'delivery_note_time', 'delivery_note_delivered', 'delivery_parcels',  'action'])
            ->make(true);
    }

 
    // public function load(Request $request) {
    //     $data = Product::select("*")->where('product_customer', $request->user()->id);

    //     if(!$request->get('order')) {
    //         $data->orderBy('product_added_time', 'desc');
    //     }

    //     return Datatables::of($data)->addIndexColumn()
    //         ->filter(function ($query) use ($request) {
    //             if ($request->has('search') && isset($request->search['value']) && !empty($request->search['value'])) {
    //                 $query->where(function ($query) use ($request) {
    //                     $query->whereHas('inventory', function ($query) use ($request) {
    //                         $query->where('inventory_var_name', 'like', "%" . $request->search['value'] . "%")->orWhere('inventory_ref', 'like', "%" . $request->search['value'] . "%");
    //                     })->orWhere('product_name', 'like', "%" . $request->search['value'] . "%")->orWhere('product_desc', 'like', "%" . $request->search['value'] . "%");
    //                 });
    //             }

    //             if($request->has('filters')) {

    //                 $filters = $request->get('filters');



    //                 if(isset($filters['product_status']) && !empty($filters['product_status'])) {
    //                     $query->where('product_received', $filters['product_status'] == "-1" ? 0 : 1);
    //                 }
    //             }
    //         })
    //         ->addColumn('checkbox', function($row){
    //             return '<div class="form-check form-check-sm form-check-custom form-check-solid placeholder-loader">
    //                         <input class="form-check-input" type="checkbox" value="'.$row->product_id.'" />
    //                     </div>';
    //         })
    //         ->addColumn('product_name', function($row){
    //             $image = asset('assets/clients/media/svg/files/blank-image.svg');
    //             if(!empty($row->product_pic)) $image = asset("images/inventory/".rawurlencode($row->product_pic));

    //             $name = '<div class="d-flex align-items-center justify-content-center justify-content-md-start">
    //                     <div class="symbol symbol-60px symbol-2by3 placeholder-loader">
    //                         <span class="symbol-label" style="background-image:url('.$image.');"></span>
    //                     </div>
    //                     <div class="ms-5">
    //                         <span class="text-gray-800 text-hover-primary fs-5 fw-bold d-block text-capitalize placeholder-loader">'.$row->product_name.'</span>';

    //             if($row->product_variant == 1) {
    //                 $name .= '<span class="badge badge-success placeholder-loader">'. __("Produit avec variantes") .'</span>';
    //             }
    //             else {
    //                 $name .= '<span class="badge badge-primary placeholder-loader">'. __("Produit simple") .'</span>';
    //             }
    //             $name .= '</div></div>';

    //             return $name;
    //         })
    //         ->addColumn('product_qty', function($row){
    //             $inventory = '';
    //             foreach($row->inventory as $key => $inv) {
    //                 $inventory .= '<div class="d-flex align-items-center flex-stack flex-wrap flex-row-fluid d-grid gap-2">
    //                     <div class="me-5">
    //                         <span class="text-gray-800 fw-bold text-hover-primary fs-7 placeholder-loader">#.'.$inv->inventory_ref.'</span>
    //                         <span class="text-gray-400 fw-semibold fs-8 d-block text-start ps-0 placeholder-loader">'.$inv->inventory_var_name.'</span>   
    //                     </div>
    //                     <div class="d-flex align-items-center"> 
    //                         <div class="m-0">
    //                             <span class="badge badge-light-success fs-4 me-1 placeholder-loader" title="'.__("Quantité Reçu").'" data-bs-toggle="tooltip" data-bs-placement="top">                                
    //                                 <i class="ki-outline ki-arrow-up fs-4 text-success ms-n1"></i>                                                              
    //                                 '.$inv->inventory_qty.'
    //                             </span>
    //                             <span class="badge badge-light-warning fs-4 placeholder-loader" title="'.__("Quantité Non Reçu").'" data-bs-toggle="tooltip" data-bs-placement="top">                                
    //                                 <i class="ki-outline ki-arrow-down fs-4 text-warning ms-n1"></i>                                                              
    //                                 '.$inv->inventory_qty_not_received.'
    //                             </span> 
    //                         </div>  
    //                     </div>
    //                 </div>';
    //                 if(count($row->inventory) != ($key + 1))
    //                     $inventory .= '<div class="separator mb-2 border-3"></div>';
    //             }

    //             return $inventory.'</div>';
    //         })
    //         ->addColumn('action', function($row){
    //             $action = '<div class="d-flex justify-content-center justify-content-md-end flex-shrink-0">';


    //             $action .= '<button class="btn btn-icon btn-success btn-sm me-1 info placeholder-loader" data-id="'.$row->product_id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('Voir').'">
    //                             <i class="ki-outline ki-eye fs-2"></i></button>';
    //             $action .= '
    //                 <a href="'.route('clients.inventory.edit', ['id' => $row->product_id]).'" class="btn btn-icon btn-primary btn-sm me-1 placeholder-loader" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('Modifier').'">
    //                     <i class="ki-outline ki-pencil fs-2"></i></a>';

    //             if($row->product_received == 0) {
    //                 $action .= '<button class="btn btn-icon btn-danger btn-sm me-1 remove placeholder-loader" data-kt-indicator="off" data-id="'.$row->product_id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('Supprimer').'">
    //                         <span class="indicator-label"><i class="ki-outline ki-trash fs-2"></i></span>
    //                         <span class="indicator-progress ">
    //                             <span class="spinner-border spinner-border-sm align-middle"></span>
    //                         </span>
    //                     </button>';    
    //             }
                

    //             $action .= '</div>';

    //             return $action;
    //         })
    //         ->smart(false)
    //         ->orderColumn('parcel_code', function ($query, $order) {$query->orderBy('parcel_code', $order);})
    //         ->rawColumns(['checkbox', 'product_name', 'product_qty', 'parcel_situation', 'parcel_status', 'parcel_price',  'action'])
    //         ->make(true);
    // }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view("clients.requests.pickups.edit");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
