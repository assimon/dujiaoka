<?php


namespace App\Services;


use App\Models\Cards;

class CardsService
{

    /**
     * 根据商品获取卡密.
     * @param int $productId 商品id
     * @param int $number 数量.
     * @return mixed
     */
    public function cardByProduct(int $productId, int $number)
    {
        return Cards::query()->where(['product_id' => $productId, 'card_status' => 1])->take($number)->get();
    }

}
