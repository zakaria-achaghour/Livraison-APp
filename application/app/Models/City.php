<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'cities';
    protected $primaryKey = 'id';


    public function zones() {
        return $this->belongsToMany(Zone::class, 'zone_cities', 'zone_cities_city_id', 'zone_cities_zone_id');
    }

    public function customers()
    {
       return $this->hasMany(Customer::class, 'id', 'customers_pickup_city');
    }
}
