<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClaimMessage extends Model
{
    use HasFactory;
    protected $table = 'claims_msg';
    protected $primaryKey = 'claims_msg_id';

    public function claim()
    {
        return $this->belongsTo(Claim::class, 'claims_msg_claim', 'claims_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'claims_msg_from_id', 'users_id');
    }

    public function sender()
    {
        return $this->morphTo('sender', 'claims_msg_from', 'claims_msg_from_id');
    
    }
}
