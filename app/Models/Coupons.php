<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupons extends Model
{
    public function product()
    {
        return $this->belongsTo(Products::class, "product_id");
    }
}
