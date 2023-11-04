<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackingReceipt extends Model
{
    use HasFactory;
    protected $table = 'suivi_bon';
    protected $primaryKey = 'suivi_id';
}
