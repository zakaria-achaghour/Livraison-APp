<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParcelEdit extends Model
{
    use HasFactory;

    protected $table = 'parcel_edit';
    protected $primaryKey = 'parcel_edit_id';
}
