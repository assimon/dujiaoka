<?php


namespace App\Services;


class OrderService
{

    /**
     * 获取批发价格.
     * @param array $wholesalePriceArr 批发价匹配数组.
     * @param float $actualPrice 原始价格.
     * @param int $orderNumber 购买数量.
     * @return float 批发后的总价.
     */
    public function getWholesalePrice(array $wholesalePriceArr, float $actualPrice, int $orderNumber) : float
    {
        $wholesalePrice = $actualPrice * $orderNumber;
        foreach ($wholesalePriceArr as $wholesale) {
            if ($orderNumber >= $wholesale['number']) {
                $wholesalePrice = $wholesale['price'] * $orderNumber;
            }
        }
        return number_format($wholesalePrice, 2, '.', '');
    }

}
