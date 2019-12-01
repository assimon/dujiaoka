<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;


class Commodity extends Model
{
    protected $table = 'commodity';

    protected $fillable = [
        'in_stock',
    ];


    public function classify()
    {
        return $this->belongsTo(Classify::class, 'pd_type');
    }

    public function cardlist()
    {
        return $this->hasOne(Classify::class);
    }

    public function orders()
    {
        return $this->hasOne(Orders::class);
    }

    /**
     * 商品图片访问器
     * @param $value
     * @return string
     */
    public function getProductPictureAttribute($value)
    {
        return Storage::disk('admin')->url($value);
    }
}
