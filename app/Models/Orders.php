<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orders extends Model
{
    use SoftDeletes;

    protected $fillable = ['oid', 'pd_id', 'pd_money', 'ord_countmoney', 'ord_num', 'ord_name', 'search_pwd', 'rcg_account', 'ord_info', 'pay_ord', 'pay_type', 'ord_status', 'created_at'];//开启白名单字段



    public function commodity()
    {
        return $this->belongsTo(Commodity::class, 'pd_id');
    }

    public function payconfig()
    {
        return $this->belongsTo(Payconfig::class, 'pay_type');
    }


}
