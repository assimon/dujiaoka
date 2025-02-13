<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayGateway extends Model
{
    protected $table = 'pays';

    protected $fillable = [
        'pay_name',
        'merchant_id',
        'merchant_key',
        'merchant_pem',
        'pay_check'
    ];

    /**
     * 获取 Gomypay 支付网关
     *
     * @return PayGateway|null
     */
    public static function getByPayCheck()
    {
        return self::where('pay_check', 'gomypay')->first();
    }
} 