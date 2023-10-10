<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParcelHistory extends Model
{
    use HasFactory;

    protected $table = 'parcel_history';
    protected $primaryKey = 'parcel_history_id';

    /*
    ***************
    RELATIONS
    ***************
    */
    public function movmentsZone() {
        return $this->belongsTo(Zone::class, 'parcel_movments', 'zone_id');
    }

    public function parcel() {
        return $this->belongsTo(Parcel::class, 'parcel_history_parcel', 'parcel_id');
    }
}
