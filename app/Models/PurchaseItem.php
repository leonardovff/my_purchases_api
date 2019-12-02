<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseItem extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'purchase_id',
        'quantity',
        'unitary_value',
        'amount',
        'item_id'
    ];
}
