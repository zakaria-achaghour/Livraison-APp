<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParcelContent extends Model
{
    use HasFactory;

    protected $table = 'parcel_content';
    protected $primaryKey = 'parcel_content_id';

    public function inventory() {
        return $this->belongsTo(Inventory::class, 'parcel_content_inventory_id', 'inventory_id');
    }

    public function product() {
        return $this->belongsTo(Product::class, 'parcel_content_product_id', 'product_id');
    }
}