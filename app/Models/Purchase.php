<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'number', 'bought_at', 'amount',
		'access_key', 'user_id', 'company_id'
    ];
    public $timestamps = false;
}
