<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory';
    protected $primaryKey = 'inventory_id';

    public function product() {
        return $this->belongsTo(Product::class, 'inventory_product', 'product_id');
    }


    public function affected_content() {
        return $this->hasMany(ParcelContent::class, 'parcel_content_inventory_id', 'inventory_id');
    }
}
