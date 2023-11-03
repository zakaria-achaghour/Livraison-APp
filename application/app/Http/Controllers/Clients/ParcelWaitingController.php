<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DataTables;
use App\Models\Parcel;

class ParcelWaitingController extends Controller
{
    public function index() {
        return view('clients.parcels.waiting-pick-up');
    } 

    public function load(Request $request) {
        $data = Parcel::select("*")->with('city')
            ->where('parcel_customer', \Auth()->user()->customers_id)
            ->where('parcel_from_stock', 0)
            ->whereIn('parcel_status', ['NEW_PARCEL', 'WAITING_PICKUP']);


        if(!$request->get('order')) {
            $data->orderBy('parcel_time', 'desc');
        }

        return Datatables::of($data)->addIndexColumn()
            ->filter(function ($query) use ($request) {
                if ($request->has('search') && isset($request->search['value']) && !empty($request->search['value'])) {
                    $query->where('parcel_code', 'like', "%" . $request->search['value'] . "%")->orWhere('parcel_receiver', 'like', "%" . $request->search['value'] . "%")->orWhere('parcel_phone', 'like', "%" . $request->search['value'] . "%");
                }

                if($request->has('filters')) {
                    $filters = $request->get('filters');

                    if(isset($filters['parcel_status']) && !empty($filters['parcel_status']))
                        $query->where(function ($query) use($filters) {
                            $query->where('parcel_status', $filters['parcel_status'])->orWhere('parcel_status_second', $filters['parcel_status']);
                        });

                    if(isset($filters['parcel_city']) && !empty($filters['parcel_city']))
                        $query->where('parcel_city', $filters['parcel_city']);
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
                return '
                    <div class="d-flex align-items-center justify-content-center justify-content-md-start">
                        <div class="symbol symbol-circle symbol-40px me-2 placeholder-loader">
                            <div class="symbol-label fs-5 fw-semibold bg-success text-inverse-success">'.$row->getAvatarLetters().'</div>
                        </div>
                        <div class="">
                            <span class="text-gray-700 fw-bold text-hover-primary fs-8 placeholder-loader">'.$row->parcel_receiver.'</span>
                            <span class="text-gray-400 fw-semibold fs-7 d-block ps-0 placeholder-loader">'.$row->parcel_phone.'</span> 
                            <span class="text-gray-800 fs-7 d-block ps-0 placeholder-loader">'.$row->city->name ?? ''  .'</span>  
                        </div>
                    </div>';
            })
            ->addColumn('parcel_status', function($row){
                $column = '<span class="badge badge-outline badge-lg placeholder-loader" style="color:'.$row->getStatus($row->parcel_status)['color'].'; border:1px solid '.$row->getStatus($row->parcel_status)['color'].'">'.$row->getStatus($row->parcel_status)['text'].'</span>';

                $column .= '<br/><small class="mt-2 d-block placeholder-loader">'. __('Créé le'). ' : '.date("d/m/Y ".__("à")." H:i", $row->parcel_time).'</small>';

                return $column;
            })
            ->addColumn('parcel_price', function($row){
                return '<span class="fs-5 text-gray-900 fw-bolder placeholder-loader">'.$row->parcel_price.' '.__('DH').'</span>';
            })
            /*->addColumn('parcel_time', function($row){
                return '<span><i class="ki-outline ki-calendar-tick me-2"></i>'.date("d/m/Y à H:i", $row->parcel_time).'</span>
                    ';
            })*/
            ->addColumn('delivery_note', function($row){
                $column = '';
                foreach($row->deliveryNotes as $dn) {
                    $column .= '<a class="btn btn-sm btn-success placeholder-loader" href="#">'.$dn->delivery_note_ref.'</a>';
                }

                if(empty($column)) {
                    $column .= '<small class="badge badge-outline badge-warning placeholder-loader">'. __("Pas encore créé") .'</small>';
                }
                return $column;
            })
            ->addColumn('action', function($row){
                $action = '<div class="d-flex justify-content-center justify-content-md-end flex-shrink-0">
                            <button class="btn btn-icon btn-success btn-sm me-1 info placeholder-loader" data-id="'.$row->parcel_id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('Informations').'">
                                <i class="ki-outline ki-eye fs-2"></i></button>';
                 if($row->parcel_status == "NEW_PARCEL")  {             
                    $action .= '
                        <a href="'.route('clients.parcels.edit', ['id' => $row->parcel_id]).'" class="btn btn-icon btn-primary btn-sm me-1 placeholder-loader" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('Modifier').'">
                            <i class="ki-outline ki-pencil fs-2"></i></a>
                        <button class="btn btn-icon btn-danger btn-sm me-1 remove placeholder-loader" data-kt-indicator="off" data-id="'.$row->parcel_id.'" data-bs-toggle="tooltip" data-bs-placement="top" title="'.__('Supprimer').'">
                            <span class="indicator-label"><i class="ki-outline ki-trash fs-2"></i></span>
                            <span class="indicator-progress ">
                                <span class="spinner-border spinner-border-sm align-middle"></span>
                            </span>
                        </button>';
                }

                $action .= '</div>';

                return $action;
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
            ->rawColumns(['checkbox', 'parcel_code', 'parcel_receiver', 'delivery_note', 'parcel_status', 'parcel_price',  'action'])
            ->make(true);
    }
}
