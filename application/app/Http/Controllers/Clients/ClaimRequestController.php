<?php

namespace App\Http\Controllers\Clients;

use App\Enums\ClaimsStatusEnum;
use App\Enums\ClaimsTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Clients\Claims\StoreClaimRequest;
use App\Models\Claim;
use App\Models\ClaimMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;

class ClaimRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = [
            ClaimsTypeEnum::URGENT_DELIVERY,
            ClaimsTypeEnum::REQUEST_ANOTHER_ATTEMPT,
            ClaimsTypeEnum::PRICE_CHANGE,
            ClaimsTypeEnum::NUMBER_CHANGE,
            ClaimsTypeEnum::CHANGE_OF_RECIPIENT,
            ClaimsTypeEnum::UPDATE_DELAY,
            ClaimsTypeEnum::CANCEL_REQUEST
        ];
        return view("clients.requests.claims.index", [
            "types" => $types
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreClaimRequest $request)
    {
        $user = Auth::user();
        $claim = new Claim();
        $claim->claims_customer = $user->customers_id;
        $claim->claims_time     = time();
        $claim->claims_object   = $request->type;
        $claim->claims_statut   = 1;
        $claim->parcel_code   = $request->parcelCode;
        $claim->pickup_zone   = $user->city->zones->first()->zone_id;
        $claim->save();

        $message = new ClaimMessage();
        $message->claims_msg_claim = $claim->claims_id;
        $message->claims_msg_from = 1;
        $message->claims_msg_from_id = $user->customers_id;
        $message->claims_msg_time = time();
        $message->claims_msg_text = $request->message;
        $message->save();

        return Response::json([
            'success' => true, 
            'message' => __('The Claim added succesfully')
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function load(Request $request)
    {
        $data = Claim::select(
            'claims_id', 'claims_statut','claims_object', 
             'parcel_code', 
            //  'pickup_zone',
            DB::raw('COALESCE(claims_time) as claims_time')
        )->where("claims_customer", Auth::id());

        $orderBy = $request->get('order');
        if(!$orderBy) {
            $data->orderBy('claims_time', 'desc');
        } else {
            $data->orderBy('claims_time', $orderBy[0]['dir'] );
        }

        return Datatables::of($data)->addIndexColumn()
                ->filter(function ($query) use ($request) {
                    if ($request->has('search') && isset($request->search['value']) && !empty($request->search['value'])) {
                        $query->where('parcel_code', 'LIKE', '%'.$request->search['value'].'%');
                    }
                    if($request->has('filters')) {
                        $filters = $request->get('filters');

                        if(isset($filters['status'])) {
                            $query->where('claims_statut', $filters['status']);
                        }
                    }
                })
                ->addColumn('checkbox', function($row){
                    return '<div class="form-check form-check-sm form-check-custom form-check-solid placeholder-loader">
                                <input class="form-check-input" type="checkbox" value="'.$row->claims_id.'" />
                            </div>';
                })
                ->addColumn('claims_time', function($row) {
                    $date = is_numeric($row->claims_time) ? 
                    Carbon::createFromTimestamp($row->claims_time) : 
                    Carbon::createFromFormat('Y-m-d H:i:s', $row->claims_time);
            
                    $span = '<span class="text-gray-900 fs-5 placeholder-loader">'. $date->format('Y-m-d') .'</span><br/>';
                    $span .= '<span class="fw-bolder text-gray-500 fs-6 placeholder-loader">'.__('à') . $date->format('H:i:s') .'</span>';
                return  $span;
                })
                ->addColumn('claims_statut', function($row) {
                    if($row->claims_statut == ClaimsStatusEnum::Claim_Processed) {
                        return '<span class="badge badge-success fs-6 placeholder-loader">'.__('Claim Processed').'</span>';
                    }elseif ($row->claims_statut == ClaimsStatusEnum::Team_Response_Pending) {
                        return '<span class="badge badge-primary fs-6 placeholder-loader">'.__('Team Response Pending').'</span>';
                    }else {
                        return '<span class="badge badge-info fs-6 placeholder-loader">'.__('Waiting For Customer Response').'</span>';
                    }
                })
                ->addColumn('action', function($row){
                    $actions = '<div class="d-flex justify-content-center justify-content-md-end flex-shrink-0">
                            <button class="btn btn-icon btn-success btn-sm me-1 info placeholder-loader" data-id="'.$row->claims_id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('Voir').'">
                                <i class="ki-outline ki-eye fs-2"></i></button>';
                    return $actions;
                })

            ->smart(false)
            ->rawColumns(['checkbox', 'claims_object', 'parcel_code', 'claims_statut', 'claims_time', 'action'])
            ->make(true);
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
