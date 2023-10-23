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
        return $this->belongsTo(Claim::class, 'claims_msg_id', 'claims_id');
    }
}
