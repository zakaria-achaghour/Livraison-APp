<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoice';
    protected $primaryKey = 'invoice_id';

    public function getAttribute($key)
    {
        // Check if the key starts with the prefix or if it's a special Eloquent attribute
        if (array_key_exists($key, $this->attributes)) {
            return parent::getAttribute($key);
        }

        return parent::getAttribute('invoice_' . $key);
    }

    public function setAttribute($key, $value)
    {
        // Check if the key starts with the prefix or if it's a special Eloquent attribute
        if (array_key_exists($key, $this->attributes)) {
            return parent::setAttribute($key, $value);
        }

        return parent::setAttribute('invoice_' . $key, $value);
    }
}
