<?php

namespace App\Repositories;

use App\Models\Parcel;

class ParcelsRepository {


    public function getNewAndWitingParcels(int $customerId, array $status, bool $isStock) {
        return Parcel::select("*")->with('city')
        ->where('parcel_customer', $customerId)
        ->where('parcel_from_stock', $isStock)
        ->whereIn('parcel_status', $status)
        ->get();
    }
}