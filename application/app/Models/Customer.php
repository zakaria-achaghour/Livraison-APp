<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Notifications\ClientResetPassword;
use App\Models\CustomerCode;
use App\Notifications\ClientEmailVerificationNotification;
use Carbon\Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class Customer extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $table = 'customers';
    protected $primaryKey = 'customers_id';



    /**
 * The attributes that are mass assignable.
 *
 * @var array
 */
protected $fillable = [
    'email_verified_at',
];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'customers_password',
        'password',
        'remember_token'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    /*
    ***************
    RELATIONS
    ***************
    */
    public function companyType() {
        return $this->belongsTo(CompanyType::class, 'customers_company_type', 'id');
    }

    public function paimentModes() {
        return $this->hasMany(PaymentMode::class, 'customer_id', 'customers_id');
    }

    public function activeInvoices() {
        // status = 0 => draft
        // status = 1 => saved
        // status = 2 => paid
        return $this->hasMany(Invoice::class, 'invoice_customer', 'customers_id')->where('invoice_statut', '!=', 0);
    }

    public function parcelsAllReceived () {
        return $this->hasMany(Parcel::class, 'parcel_customer', 'customers_id')->whereNotIn('parcel_status', ['NEW_PARCEL', 'WAITING_PICKUP']);
    }

    public function newParcels () {
        return $this->hasMany(Parcel::class, 'parcel_customer', 'customers_id')->where('parcel_status', 'NEW_PARCEL');
    }


    /*
    ***************
    FUNCTIONS
    ***************
    */
    public function tarifs($city_id = null) {
        if($city_id != null)
            return $this->hasMany(CustomerTarif::class, 'customer_id', 'customers_id')->where('city_id', $city_id);

        return $this->hasMany(CustomerTarif::class, 'customer_id', 'customers_id');
    }

    public function getCityFees($city_id) {
        if($this->custom_tarif == 1) {
            $tarifs = $this->tarifs($city_id)->selectRaw('delivered_price as fees,returned_price as retrun,refused_price as refuse')->first();

            if(empty($tarifs)) {
                return $tarifs;
            }
        }
        
        $city = City::select(['fees', 'return', 'refuse'])->where('id', $city_id)->first();
        if(empty($city)) {
            return (object) ['fees' => 0, 'return' => 0, 'refuse' => 0];
        }

        return $city;        
    }


    // public function getAttribute($key)
    // {
    //     if ($key === 'created_at' || $key === 'updated_at') {
    //         return null; // Exclude created_at and updated_at
    //     }
    //     // Check if the key starts with the prefix or if it's a special Eloquent attribute
    //     if (array_key_exists($key, $this->attributes)) {
    //         return parent::getAttribute($key);
    //     }

    //     return parent::getAttribute('customers_' . $key);
    // }

    // public function setAttribute($key, $value)
    // {
    //     // Check if the key starts with the prefix or if it's a special Eloquent attribute
    //     if (array_key_exists($key, $this->attributes)) {
    //         return parent::setAttribute($key, $value);
    //     }

    //     return parent::setAttribute('customers_' . $key, $value);
    // }


    public function getAvatarLetters() {
        $names = explode(" ", $this->name);
        if(count($names) == 0) {
            return "";
        }
        else if(count($names) == 1) {
            return strtoupper(substr($names[0], 0, 2));
        }
        else {
            return strtoupper(substr($names[0], 0, 1).substr($names[1], 0, 1));
        }
    }


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ClientResetPassword($token));
    }

    /**
     * Send email verification notice.
     * 
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new ClientEmailVerificationNotification);
    }
}
