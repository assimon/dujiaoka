<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classify extends Model
{
    protected $table = 'classify';

    public $timestamps = false;


    public function commodity()
    {
        return $this->hasOne(Commodity::class);
    }

}
