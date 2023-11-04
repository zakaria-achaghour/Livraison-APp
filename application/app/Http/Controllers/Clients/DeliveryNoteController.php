<?php

namespace App\Http\Controllers\Clients;

use App\Enums\ParcelStatusEnum;
use App\Enums\TrackingReceiptStatusEnum;
use App\Enums\TrackingReceiptTypeEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\DeliveryNote;
use App\Repositories\DeliveryNoteRepository;
use App\Repositories\ParcelsRepository;
use App\Repositories\TrackingReceiptRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;

class DeliveryNoteController extends Controller
{

    private $parcelsRepository;
    private $deliveryNoteRepository;
    private $trackingReceiptRepository;

    public function __construct(
        ParcelsRepository $parcelsRepository,
        DeliveryNoteRepository $deliveryNoteRepository,
        TrackingReceiptRepository $trackingReceiptRepository)
    {
        $this->parcelsRepository = $parcelsRepository;
        $this->deliveryNoteRepository = $deliveryNoteRepository;
        $this->trackingReceiptRepository = $trackingReceiptRepository;
    }

    public function index(Request $request) {
        return view('clients.delivery-note.index');
    }

    public function add(Request $request) {
        $parcels = $this->parcelsRepository->getNewAndWitingParcels(Auth::id(), [ParcelStatusEnum::NEW_PARCEL, ParcelStatusEnum::WAITING_PICKUP], 0);
    
        return view('clients.delivery-note.add', ['parcelsCount' => $parcels->count()]);
    }

    public function load(Request $request) {
        $data = DeliveryNote::select("*")->where('delivery_note_customer', $request->user()->id);

        if(!$request->get('order')) {
            $data->orderBy('delivery_note_time', 'desc');
        }

        return Datatables::of($data)->addIndexColumn()
            ->filter(function ($query) use ($request) {
                if ($request->has('search') && isset($request->search['value']) && !empty($request->search['value'])) {
                    $query->where('delivery_note_ref', 'LIKE', '%'.$request->search['value'].'%');
                }

                if($request->has('filters')) {
                    $filters = $request->get('filters');

                    if(isset($filters['status'])) {
                        $query->where('delivery_note_delivered', $filters['status']);
                    }

                    if(isset($filters['date']) && !empty($filters['date'])) {
                        $date = explode(' - ', $filters['date']);
                        $date_from = strtotime($date[0]." 00:00");
                        $date_to = strtotime($date[1]." 23:59:60");
                        $query->where('delivery_note_time', '>=', $date_from);
                        $query->where('delivery_note_time', '<=', $date_to);
                    }
                }
            })
            ->addColumn('checkbox', function($row){
                return '<div class="form-check form-check-sm form-check-custom form-check-solid placeholder-loader">
                            <input class="form-check-input" type="checkbox" value="'.$row->id.'" />
                        </div>';
            })
            ->addColumn('delivery_note_ref', function($row) {
                return '<a href="#" class="badge fs-5 badge-outline badge-info placeholder-loader">'.$row->delivery_note_ref.'</a>';
            })
            ->addColumn('delivery_note_time', function($row) {
                $span  = '<span class="text-gray-900 fs-5 placeholder-loader">'.date("d/m/Y", $row->delivery_note_time).'</span><br/>';
                $span .= '<span class="fw-bolder text-gray-500 fs-6 placeholder-loader">'.__('à').' '.date("H:i", $row->delivery_note_time).'</span>';

                return  $span;
            })
            ->addColumn('delivery_note_delivered', function($row) {
                if($row->delivery_note_delivered == 1) {
                    return '<span class="badge badge-success fs-6 placeholder-loader">'.__('Reçu').'</span>';
                }
                else {
                    return '<span class="badge badge-primary fs-6 placeholder-loader">'.__('Nouveau').'</span>';
                }
            })
            ->addColumn('delivery_parcels', function($row) {
                return '<span class="badge badge-circle badge-primary placeholder-loader fs-5 p-5">'.$row->parcels->count().'</span>';

            })
            ->addColumn('action', function($row){
                $actions = '<div class="d-flex justify-content-center justify-content-md-end flex-shrink-0">
                            <button class="btn btn-icon btn-success btn-sm me-1 info placeholder-loader" data-id="'.$row->parcel_id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('Voir').'">
                                <i class="ki-outline ki-eye fs-2"></i></button>';

                /*$more_actions = '';
                if(1 != 1) {
                    $more_actions .= '<div class="menu-item"><a class="menu-link px-3 edit" data-id="'.$row->parcel_id.'">
                        <i class="ki-outline ki-pencil fs-2 me-2"></i> '.__('Demande de Modifier').'
                    </a></div>';    
                }

                if(1 != 1) {
                    $more_actions .= '<div class="menu-item"><a class="menu-link px-3 livreur" data-id="'.$row->parcel_id.'">
                        <i class="ki-outline ki-delivery fs-2 me-2"></i> '.__('Livreur').'
                    </a></div>';  
                }

                $actions .= '<button class="btn btn-icon btn-secondary btn-sm me-1 placeholder-loader" '.($more_actions != '' ? 'data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-overflow="true"' : 'disabled').'>
                                <i class="ki-outline ki-dots-vertical fs-2"></i>
                            </button>';

                if($more_actions != '') {
                    $actions .= '<div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-200px placeholder-loader" data-kt-menu="true">'.$more_actions.'</div>';
                }*/
                
                $actions .= '</div>';
                return $actions;
            })
            ->smart(false)
            ->orderColumn('delivery_note_ref', function ($query, $order) {$query->orderBy('parcel_code', $order);})
            ->rawColumns(['checkbox', 'delivery_note_ref', 'delivery_note_time', 'delivery_note_delivered', 'delivery_parcels',  'action'])
            ->make(true);
    }

    public function parcelsLoad() {
        $parcels = $this->parcelsRepository->getNewAndWitingParcels(Auth::id(), [ParcelStatusEnum::NEW_PARCEL, ParcelStatusEnum::WAITING_PICKUP], 0);
    
        return Response::json(['parcels' => $parcels]);
    }

    public function save(Request $request ) {
        $customerId = Auth::id();
        $deliveryNote = new DeliveryNote();
        $deleiverynote->delivery_note_customer = $customerId;
        $deleiverynote->delivery_note_time = time();
        $deleiverynote->delivery_note_delivered = 0;
        $deleiverynote->save();

        $deleiveryNoteRef = $this->deliveryNoteRepository->generateDeliveryNoteRef($customerId, $deleiverynote->delivery_note_id);

        $deleiverynote->delivery_note_ref = $deleiveryNoteRef;
        $deleiverynote->save();

        // $new_dn_id,'delivery_note','Nouveau',2,0
        $this->trackingReceiptRepository->saveTrackingReceipt(
            $deleiverynote->delivery_note_id,
            TrackingReceiptTypeEnum::DELIVERY_NOTE,
            TrackingReceiptStatusEnum::NEW,
            2,
            0
        );
    }
}
