<?php


namespace App\Services;


use App\Models\Pays;

class PaysService
{

    /**
     * 加载所有支付方式.
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function pays()
    {
        return Pays::query()->where('pay_status', 1)->get();
    }

    /**
     * 根据id查询支付方式.
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function payInfoById(int $id)
    {
        return Pays::query()->where(['id' => $id,  'pay_status' => 1])->first();
    }

}
