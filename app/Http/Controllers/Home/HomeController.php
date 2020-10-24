<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Products;
use App\Services\ProductService;
use Illuminate\Http\Request;

/**
 * 公共控制器.
 * Class HomeController
 * @package App\Http\Controllers\Home
 */
class HomeController extends Controller
{

    /**
     * 商品服务层.
     * @var
     */
    private $productService;

    /**
     * HomeController constructor.
     */
    public function __construct(ProductService $productsService)
    {
        $this->productService = $productsService;
    }

    /**
     * 首页
     * @param Request $request
     */
    public function index(Request $request)
    {
        $products = $this->productService->classAndProducts($request->all());
        return $this->view('static_pages/home', ['classifys' => $products]);
    }

    /**
     * 商品详情.
     * @param Products $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \App\Exceptions\AppException
     */
    public function buy(Products $product)
    {
        $info = $this->productService->productInfo($product);
        return $this->view('static_pages/buy', $info);
    }

}
