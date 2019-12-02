<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    protected $fillable = [
        "cnpj",
        "company_name",
        "trade_name",
        "main_activity_id",
        "secondary_activity_id",
    ];
    public $timestamps = false;
}
