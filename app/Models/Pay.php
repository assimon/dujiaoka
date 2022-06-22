<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Pay extends BaseModel
{

    use SoftDeletes;

    protected $table = 'pays';

    /**
     * 跳转
     */
    const METHOD_JUMP = 1;

    /**
     * 扫码
     */
    const METHOD_SCAN = 2;

    /**
     * 电脑
     */
    const PAY_CLIENT_PC = 1;

    /**
     * 手机
     */
    const PAY_CLIENT_MOBILE = 2;

    /**
     * 通用
     */
    const PAY_CLIENT_ALL = 3;

    public static function getMethodMap()
    {
        return [
            self::METHOD_JUMP => admin_trans('pay.fields.method_jump'),
            self::METHOD_SCAN => admin_trans('pay.fields.method_scan'),
        ];
    }

    public static function getClientMap()
    {
        return [
            self::PAY_CLIENT_PC => admin_trans('pay.fields.pay_client_pc'),
            self::PAY_CLIENT_MOBILE => admin_trans('pay.fields.pay_client_mobile'),
            self::PAY_CLIENT_ALL => admin_trans('pay.fields.pay_client_all'),
        ];
    }

}
