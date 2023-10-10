<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParcelStatut extends Model
{
    use HasFactory;

    protected $table = 'parcel_statut';
    protected $primaryKey = 'parcel_statut_id';
}
