<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payconfig extends Model
{
    protected $table = 'payconfig';

    public function orders()
    {
        return $this->hasOne(Orders::class);
    }

}
