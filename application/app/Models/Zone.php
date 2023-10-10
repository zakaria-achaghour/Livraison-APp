<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Zone extends Model
{
    use HasFactory;

    protected $table = 'zone';
    protected $primaryKey = 'zone_id';


    public function moderator() {
        return $this->hasOne(User::class, 'users_city', 'zone_id')->where('users_type', 3)->where('users_active', 1);
    }
}
