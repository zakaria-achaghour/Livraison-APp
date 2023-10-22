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
use Illuminate\Support\Facades\DB;

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
    public function load(Request $request)
    {
        $data = PickupRequest::select(
            'pickup_request_id', 'pickup_request_type', 'pickup_request_statut', 
             'pickup_request_phone', 'pickup_request_address','pickup_request_note',
            DB::raw('COALESCE(pickup_request_time, created_at) as pickup_request_time')
        )->where("pickup_request_customer", Auth::id());

        $orderBy = $request->get('order');
        if(!$orderBy) {
            $data->orderBy('pickup_request_time', 'desc');
        } else {
            $data->orderBy('pickup_request_time', $orderBy[0]['dir'] );
        }

        return Datatables::of($data)->addIndexColumn()
                ->filter(function ($query) use ($request) {
                    if ($request->has('search') && isset($request->search['value']) && !empty($request->search['value'])) {
                        $query->where('pickup_request_note', 'LIKE', '%'.$request->search['value'].'%');
                    }
                    if($request->has('filters')) {
                        $filters = $request->get('filters');

                        if(isset($filters['status'])) {
                            $query->where('pickup_request_statut', $filters['status']);
                        }
                    }
                })
                ->addColumn('checkbox', function($row){
                    return '<div class="form-check form-check-sm form-check-custom form-check-solid placeholder-loader">
                                <input class="form-check-input" type="checkbox" value="'.$row->pickup_request_id.'" />
                            </div>';
                })
                ->addColumn('pickup_request_time', function($row) {
                    $date = is_numeric($row->pickup_request_time) ? 
                    Carbon::createFromTimestamp($row->pickup_request_time) : 
                    Carbon::createFromFormat('Y-m-d H:i:s', $row->pickup_request_time);
            
                    $span = '<span class="text-gray-900 fs-5 placeholder-loader">'. $date->format('Y-m-d') .'</span><br/>';
                    $span .= '<span class="fw-bolder text-gray-500 fs-6 placeholder-loader">'.__('à') . $date->format('H:i:s') .'</span>';
                return  $span;
                })
                ->addColumn('pickup_request_type', function($row) {
                    return '<span class="badge  fs-6 placeholder-loader">'. ($row->pickup_request_type == 'SIMPLE_PARCEL') ? __('Parcel pickup') :__('Stock pickup') .'</span>';
                })
                ->addColumn('pickup_request_statut', function($row) {
                    // dd(PickupRequestEnum::TREATED->value);
                    if($row->pickup_request_statut == PickupRequestEnum::TREATED) {
                        return '<span class="badge badge-success fs-6 placeholder-loader">'.__('Treated').'</span>';
                    }elseif ($row->pickup_request_statut == PickupRequestEnum::NEW) {
                        return '<span class="badge badge-primary fs-6 placeholder-loader">'.__('Nouveau').'</span>';
                    }elseif ($row->pickup_request_statut == PickupRequestEnum::RECEIVED) {
                        return '<span class="badge badge-info fs-6 placeholder-loader">'.__('Received').'</span>';
                    }else {
                        return '<span class="badge badge-danger fs-6 placeholder-loader">'.__('Cancelled').'</span>';
                    }
                })
                ->addColumn('action', function($row){
                    $actions = '';
                    if ($row->pickup_request_statut == PickupRequestEnum::NEW) {
                        $actions .= '<div class="d-flex justify-content-center justify-content-md-end flex-shrink-0">
                        <button class="btn btn-icon btn-danger btn-sm me-1 remove placeholder-loader" data-kt-indicator="off" data-id="'.$row->pickup_request_id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('Supprimer').'">
                        <span class="indicator-label"><i class="ki-outline ki-trash fs-2"></i></span>
                        <span class="indicator-progress ">
                            <span class="spinner-border spinner-border-sm align-middle"></span>
                        </span>
                    </button>';
                        $actions .= '</div>';
                    }
                    return $actions;
                })

            ->smart(false)
            ->rawColumns(['checkbox', 'pickup_request_type', 'pickup_request_statut', 'pickup_request_time', 'pickup_request_phone', 'pickup_request_address', 'action'])
            ->make(true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $pickupRequest = PickupRequest::where('pickup_request_id', $id)->where('pickup_request_customer', $request->user()->customers_id)->first();

        if(empty($pickupRequest)) {
            return Response::json(['success' => false, 'message' => __('Introuvable')]);
        }

        if($pickupRequest->pickup_request_statut != PickupRequestEnum::NEW) {
            return Response::json(['success' => false, 'message' => __('Cannot be cancelled')]);
        }

        $pickupRequest->pickup_request_statut = PickupRequestEnum::CANCELLED;
        $pickupRequest->save();

        return Response::json(['success' => true, 'message' => __('Cancelled Successfully')]);
    
    }
}
