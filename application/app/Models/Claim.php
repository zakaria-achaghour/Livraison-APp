<?php

namespace App\Models;

use App\Enums\ClaimsStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Claim extends Model
{
    use HasFactory;
    
    protected $table = 'claims';
    protected $primaryKey = 'claims_id';

    protected $casts = [
        'claims_statut' => ClaimsStatusEnum::class
    ];

    public function messages()
    {
       return $this->hasMany(ClaimMessage::class, 'claims_id', 'claims_msg_id');
    }
}
