<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParcelCallHistory extends Model
{
    use HasFactory;

    protected $table = 'parcel_call_history';
    protected $primaryKey = 'parcel_call_history_id';


    public function parcel() {
        return $this->belongsTo(Parcel::class, 'parcel_call_history_parcel', 'parcel_id');
    }
}
