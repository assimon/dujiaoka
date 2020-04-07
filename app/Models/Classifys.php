<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classifys extends Model
{

    public function products()
    {
        return $this->hasMany(Products::class, 'pd_class');
    }

}
