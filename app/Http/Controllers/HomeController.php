<?php

namespace App\Http\Controllers;

use App\Exceptions\AppException;
use App\Interfaces\Order;
use App\Jobs\ReleaseOrder;
use App\Models\Classifys;
use App\Models\Coupons;
use App\Models\Pays;
use App\Models\Products;
use App\Rules\Searchpwd;
use App\Rules\VerifyImg;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Facades\App\Services\ProductsService;
use Facades\App\Services\OrderService;


class HomeController extends Controller
{

    /**
     * 首页加载所有商品
     */
    public function index()
    {
        $products = Classifys::with(['products' => function($query) {
            $query->where('pd_status', 1)->orderBy('ord', 'desc');
        }])->where('c_status', 1)->orderBy('ord', 'desc')->get();
        return $this->view('static_pages/home', ['classifys' => $products]);
    }

    /**
     * 商品详情.
     * @param Products $product
     */
    public function buy(Products $product)
    {
        if ($product['pd_status'] != 1) throw new AppException(__('prompt.product_off_the_shelf'));
        // 格式化批发配置以及输入框配置
        $product['wholesale_price'] = $product['wholesale_price'] ? ProductsService::formatWholesalePrice($product['wholesale_price']) : null;
        // 如果存在其他配置输入框且为代充
        $product['other_ipu'] = $product['other_ipu'] ? ProductsService::formatChargeInput($product['other_ipu']) : null;
        // 加载支付方式
        $product['payways'] = Pays::where('pay_status', 1)->get();
        return $this->view('static_pages/buy', $product);
    }

    /**
     * 提交订单
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account' => ['required', 'email'],
            'payway' => ['required', 'integer'],
            'search_pwd' => [new Searchpwd],
            'order_number' => ['required', 'integer'],
            'verify_img' => [new VerifyImg],
        ], [
            'order_number.required' =>  __('prompt.buy_order_number'),
            'order_number.integer' =>  __('prompt.buy_order_number'),
            'payway.required' =>  __('prompt.please_select_mode_of_payment'),
            'payway.integer' =>  __('prompt.please_select_mode_of_payment'),
            'account.required' =>  __('prompt.check_email_format'),
            'account.email' =>  __('prompt.check_email_format'),
        ]);
        if ($validator->fails()) {
            throw new AppException($validator->errors()->first());
        }
        $data = $request->all();
        if (config('app.shgeetest')) {
            if (!$this->validate($request, [
                'geetest_challenge' => 'geetest',
            ], [
                'geetest' => config('geetest.server_fail_alert')
            ])) {
                throw new AppException(__('prompt.behavior_verification_fail'));
            }
        }
        $product = Products::find($data['pid']);
        if (empty($product) || $product['pd_status'] != 1) throw new AppException(__('prompt.product_off_the_shelf'));
        if ($product['in_stock'] == 0 || $data['order_number'] > $product['in_stock']) throw new AppException(__('prompt.inventory_shortage'));
        // 订单缓存
        $cacheOrder = [
            'product_id' => $data['pid'], // 商品id
            'product_name' => $product['pd_name'],
            'product_price' => $product['actual_price'],
            'pay_way' => $data['payway'],
            'pd_name' => $product['pd_name'], // 名称
            'order_id' => Str::random(16), // 订单号
            'pd_type' => $product['pd_type'],
            'actual_price' => $product['actual_price'],
            'buy_amount' => intval($data['order_number']), // 订单个数
            'account' => $data['account'], // 充值账号
            'search_pwd' => $data['search_pwd'] ?? 'dujiaoka',
            'buy_ip' => $request->getClientIp(),
            'other_ipu' => ''
        ];
        $order = new Order($cacheOrder, $product->toArray());
        // 计算总价
        $order->calculateThePrice();
        /**
         * 这里是优惠券处理逻辑.
         */
        if (isset($data['coupon_code']) && $product['isopen_coupon'] == 1) {
            // 先查出有没有优惠券
            $coupon = Coupons::where(['card' => $data['coupon_code'], 'product_id' => $data['pid']])->first();
            if (empty($coupon)) throw new AppException(__('prompt.coupon_does_not_exist'));
            $order->setCoupon($coupon);
        }
        /**
         * 如果是代充，配置输入框
         */
        if ($product['pd_type'] == 2 && !empty($product['other_ipu'])) {
            // 如果有其他输入框 判断其他输入框内容  然后载入信息
            $order->formatChargeInput($data);
        }
        // 将订单信息载入缓存，等待支付
        $orderId = $order->cacheOrder();
        return redirect(url('/bill', ['orderid' => $orderId]));
    }

    /**
     * 结账
     * @param $orderid
     */
    public function bill($orderid)
    {
        $orderCache = Redis::hget('PENDING_ORDERS_LIST', $orderid);
        if (empty($orderCache)) throw new AppException(__('prompt.order_does_not_exist'));
        $orderInfo = json_decode($orderCache, true);
        return $this->view('static_pages/bill', $orderInfo);
    }


}
