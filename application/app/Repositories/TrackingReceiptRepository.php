<?php

namespace App\Repositories;

use App\Models\TrackingReceipt;
use Illuminate\Support\Facades\Auth;

class TrackingReceiptRepository {

    public function saveTrackingReceipt($receiptId, $type, $status, $user = 1, $scan = 0) {
        $user_id = Auth::id();
        $trackingReceipt = new TrackingReceipt();
        $trackingReceipt->suivi_type = $type;
        $trackingReceipt->suivi_status = $status;
        $trackingReceipt->suivi_action_by = $user_id;
        $trackingReceipt->suivi_bon_id = $receiptId;
        $trackingReceipt->suivi_date = time();
        $trackingReceipt->user_type = $user;
        $trackingReceipt->scanned = $scan;
        $trackingReceipt->save();
    }


}