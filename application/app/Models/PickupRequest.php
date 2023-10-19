<?php

namespace App\Models;

use App\Enums\PickupRequestEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PickupRequest extends Model
{
    use HasFactory;

    protected $table = 'pickup_request';
    protected $primaryKey = 'pickup_request_id';
    // public $timestamps = false;

    protected $casts = [
        'pickup_request_statut' => PickupRequestEnum::class
    ];
}
