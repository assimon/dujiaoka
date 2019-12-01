<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderStatistics extends Model
{
    protected $table = 'order_statistics';

    protected $fillable = ['count_ord', 'count_pd', 'count_money', 'count_day'];

    public $timestamps = false;

}
