<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use DataTables;
use App\Models\Parcel;
use App\Models\ParcelEdit;

class ParcelEditController extends Controller
{
    public function editRequest(Request $request, $id) {
        $parcel = Parcel::where('parcel_id', $id)->where('parcel_customer', $request->user()->id)->first();

        if(!empty($parcel) && $parcel->canBeEdited()) {
            $parcelEditObject = new \stdClass();
            $parcelEditObject->code  = $parcel->parcel_code;

            if($parcel->parcel_edit_request == 1) {
                $parcel_edited = $parcel->parcelEdit()->where('parcel_edit_statut', 0)->first();

                $parcelEditObject->statut = 'edited';
                $parcelEditObject->receiver =  $parcel_edited->parcel_edit_receiver;
                $parcelEditObject->phone =  $parcel_edited->parcel_edit_phone;
                $parcelEditObject->district =  $parcel_edited->parcel_edit_district;
                $parcelEditObject->address =  $parcel_edited->parcel_edit_address;
                $parcelEditObject->note =  $parcel_edited->parcel_edit_note;
                $parcelEditObject->price =  $parcel_edited->parcel_edit_price;
            }
            else {
                $parcelEditObject->statut = 'original';
                $parcelEditObject->receiver =  $parcel->parcel_receiver;
                $parcelEditObject->phone =  $parcel->parcel_phone;
                $parcelEditObject->district =  $parcel->parcel_district;
                $parcelEditObject->address =  $parcel->parcel_address;
                $parcelEditObject->note =  $parcel->parcel_note;
                $parcelEditObject->price =  $parcel->parcel_price;
            }            

            return Response::json(['success' => true, 'parcel' => $parcelEditObject]);
        }

        return Response::json(['success' => false, 'message' => __("Ce colis ne peut pas être modifié.")]);
    }

    public function sendEditRequest(Request $request) {
        // Validation process
        $validator = Validator::make($request->all(), [
            'parcel_code' => ['required'],
            'parcel_receiver' => ['required', 'string', 'min:2', 'max:50'],
            'parcel_phone' => ['required', 'regex:/^(05|06|07|08) \d{2} \d{2} \d{2} \d{2}$/'],
            'parcel_price' => ['required', 'regex:/^\d+(\.\d{1,2})?$/'],
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
            'parcel_price' => __('Prix'),
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

        $parcel = Parcel::where('parcel_code', $request->parcel_code)->where('parcel_customer', $request->user()->id)->first();

        if(empty($parcel)) {
            return Response::json(['success' => false, 'message' => __('Colis introuvable')]);
        }

        if(!$parcel->canBeEdited()) {
            return Response::json(['success' => false, 'message' => __("Ce colis ne peut pas être modifié.")]);
        }

        // Begin with the process
        $old_values = array(
            'phone' => $parcel->parcel_phone,
            'price' => $parcel->parcel_price,
            'address' => $parcel->parcel_address,
            'receiver' => $parcel->parcel_receiver,
            'note' => $parcel->parcel_note,
        );
            
        $new_values = array(
            'phone' => $request->parcel_phone,
            'price' => $request->parcel_price,
            'address' => $request->parcel_address,
            'receiver' => $request->parcel_receiver,
            'note' => $request->parcel_note
        );

        if($new_values == $old_values) {
            return Response::json(['success' => false, 'message' => __("Vous n'avez rien modifié. Veuillez modifier certains champs et réessayer.")]);
        }

        $result_change = $parcel->changeInfoDetails($old_values, $new_values);

        if($parcel->parcel_edit_request == 1) {
            $parcelEdit = $parcel->parcelEdit()->where('parcel_edit_statut', 0)->first();    
        }
        else {
            $parcelEdit = new ParcelEdit();
            $parcelEdit->parcel_edit_code = $parcel->parcel_code;
            $parcelEdit->parcel_edit_customer = $parcel->parcel_customer;
        }

        $parcelEdit->parcel_edit_receiver = $request->parcel_receiver;
        $parcelEdit->parcel_edit_phone = $request->parcel_phone;
        $parcelEdit->parcel_edit_price = $request->parcel_price;
        $parcelEdit->parcel_edit_address = $request->parcel_address;
        $parcelEdit->parcel_edit_note = $request->parcel_note;
        $parcelEdit->parcel_edit_time = time();
        $parcelEdit->parcel_edit_string = $result_change['infos'];
        $parcelEdit->parcel_edit_location = json_encode($result_change['keys']);
        $parcelEdit->parcel_edit_statut = 0;
        $parcelEdit->save();

        // chnage parcel status
        $parcel->parcel_edit_request = 1;
        $parcel->save();

        // SEND NOTIF
        // here

        return Response::json(['success' => true, 'message' =>__("Votre demande de modification a été envoyée.")]);
    }
}
