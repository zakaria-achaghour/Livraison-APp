<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryNote extends Model
{
    use HasFactory;

    protected $table = 'delivery_note';
    protected $primaryKey = 'delivery_note_id';

    public function parcels() {
        return $this->belongsToMany(Parcel::class, 'dn_parcels', 'dn_parcels_dn', 'dn_parcels_parcel');
    }
}
