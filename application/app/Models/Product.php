<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'product';
    protected $primaryKey = 'product_id';

    public function addProductHistory($historyType, $dataF, $dataS, $dataT) {
        $history = new InventoryHistory();
        $history->inventory_history_product_id = $this->product_id;
        $history->inventory_history_type = $historyType;
        $history->inventory_history_data_f = $dataF;
        $history->inventory_history_data_s = $dataS;
        $history->inventory_history_data_t = $dataT;
        $history->inventory_history_time = time();
        $history->save();
    }


    /*
    ***************
    RELATIONS
    ***************
    */
    public function inventory() {
        return $this->hasMany(Inventory::class, 'inventory_product', 'product_id');
    }

    public function avalaible_inventory() {
        return $this->hasMany(Inventory::class, 'inventory_product', 'product_id')->where('inventory_qty', '>', 0);
    }

    /*public function affected_inventory($parcel_id) {
        return $this->hasMany(Inventory::class, 'inventory_product', 'product_id')->whereHas('affected_content', function($query) use ($parcel_id) {
                $query->where('parcel_content_customer_id', $this->product_customer)->where('parcel_content_parcel_id', $parcel_id);
            })->with(['affected_content' => function($query) use ($parcel_id) {
                $query->select(['parcel_content_id', 'parcel_content_time', 'parcel_content_inventory_id', 'parcel_content_remarque'])->where('parcel_content_customer_id', $this->product_customer)->where('parcel_content_parcel_id', $parcel_id);
            }]);
    }*/
}
