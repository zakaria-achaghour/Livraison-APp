<?php

namespace App\Repositories;

use App\Models\DeliveryNote;

class DeliveryNoteRepository {

    public function generateDeliveryNoteRef($customerId, $deliveryNoteId) {
        $deliveryNoteRef = "BL-".date("d").date("m").date("y").'-0'.$deliveryNoteId.'0-'.rand(10, 99).'-'.$customerId;
        $count = DeliveryNote::where("delivery_note_ref", $deliveryNoteRef)->count(); 
        if($count !=0 ){
            generateDeliveryNoteRef($customerId, $deliveryNoteId);
        }
        else{
            return $deliveryNoteRef;
        }
    }


}