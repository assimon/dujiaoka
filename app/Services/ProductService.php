<?php


namespace App\Services;

use App\Exceptions\AppException;
use App\Models\Classifys;
use App\Models\Products;

/**
 * 商品服务层.
 * Class ProductService
 * @package App\Services
 */
class ProductService
{

    /**
     * 支付服务层.
     * @var PaysService
     */
    private $paysService;

    public function __construct()
    {
        $this->paysService = new PaysService();
    }

    /**
     * 获取所有商品及分类
     * @param array $params
     */
    public function classAndProducts(array $params)
    {
        $products = Classifys::query()->with(['products' => function($query) {
            $query->where('pd_status', 1)->orderBy('ord', 'desc');
        }])->where('c_status', 1)->orderBy('ord', 'desc')->get();
        return $products;
    }

    /**
     * 加载商品详情.
     * @param Products $product
     * @return Products
     * @throws AppException
     */
    public function productInfo(Products $product)
    {
        if ($product['pd_status'] != 1) throw new AppException(__('prompt.product_off_the_shelf'));
        // 格式化批发配置以及输入框配置
        $product['wholesale_price'] = $product['wholesale_price'] ? $this->formatWholesalePrice($product['wholesale_price']) : null;
        // 如果存在其他配置输入框且为代充
        $product['other_ipu'] = $product['other_ipu'] ? $this->formatChargeInput($product['other_ipu']) : null;
        $product['payways'] = $this->paysService->pays();
        return $product;
    }

    /**
     * 根据id获取商品详情.
     * @param int $id
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function product(int $id)
    {
        return Products::query()->where('id', $id)->first();
    }

    /**
     * 设置商品库存减去
     * @param int $productId 商品id
     * @param int $number 减去库存
     */
    public function stockDecr(int $productId, int $number)
    {
        return Products::query()->where('id', $productId)->decrement('in_stock', $number);
    }

    /**
     * 格式化批发价，用于计算.
     * @param string $wholesalePriceArr 待格式化的批发价.
     * @return array 格式化后的批发价数组.
     */
    public function formatWholesalePrice(string $wholesalePriceArr) : array
    {
        $waitArr = explode(PHP_EOL, $wholesalePriceArr);
        $formatData = [];
        foreach ($waitArr as $key => $val) {
            if($val != ""){
                $explodeFormat = explode('=', delete_html($val));
                if (count($explodeFormat) != 2) throw new AppException(__('prompt.wholesale_price_format_error'));
                $formatData[$key]['number'] = $explodeFormat[0];
                $formatData[$key]['price'] = $explodeFormat[1];
            }
        }
        sort($formatData);
        return $formatData;
    }

    /**
     * 格式化代充输入框.
     * @param string $charge 待格式化内容.
     * @return array 格式化后的内容.
     * @throws AppException
     */
    public function formatChargeInput(string $charge) : array
    {
        $inputArr = explode(PHP_EOL, $charge);
        $formatData = [];
        foreach ($inputArr as $key => $val) {
            if($val != ""){
                $explodeFormat = explode('=', delete_html($val));
                if (count($explodeFormat) != 3) throw new AppException(__('prompt.charge_input_format_error'));
                $formatData[$key]['field'] = $explodeFormat[0];
                $formatData[$key]['desc'] = $explodeFormat[1];
                $formatData[$key]['rule'] = filter_var($explodeFormat[2], FILTER_VALIDATE_BOOLEAN);
            }
        }
        return $formatData;
    }



}
