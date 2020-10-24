<?php

namespace App\Http\Controllers\Home;

use App\Exceptions\AppException;
use App\Http\Controllers\Controller;
use App\Rules\Searchpwd;
use App\Rules\VerifyImg;
use App\Services\CouponService;
use App\Services\OrderService;
use App\Services\ProductService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

/**
 * 订单控制器.
 * Class OrderController
 * @package App\Http\Controllers\Home
 */
class OrderController extends Controller
{

    /**
     * 订单服务层.
     * @var OrderService
     */
    private $orderService;

    /**
     * 商品服务层.
     * @var
     */
    private $productService;

    /**
     * 优惠券服务层
     * @var
     */
    private $couponService;

    public function __construct(
        OrderService $orderService,
        ProductService $productService,
        CouponService $couponService)
    {
        $this->orderService = $orderService;
        $this->productService = $productService;
        $this->couponService = $couponService;
    }

    /**
     * 订单查询页.
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchOrder()
    {
        return $this->view('static_pages/searchOrder');
    }

    /**
     * 创建订单.
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     * @throws AppException
     * @throws \Illuminate\Validation\ValidationException
     */
    public function createOrder(Request $request)
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
        // 如果开启了极验
        if ($validator->fails()) {
            throw new AppException($validator->errors()->first());
        }
        if (config('app.shgeetest')) {
            if (!$this->validate($request, [
                'geetest_challenge' => 'geetest',
            ], [
                'geetest' => config('geetest.server_fail_alert')
            ])) {
                throw new AppException(__('prompt.behavior_verification_fail'));
            }
        }
        $data = $request->all();
        $product = $this->productService->product($data['pid']);
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
        // 设置订单详情。
        $this->orderService->setOrderInfo($cacheOrder);
        $this->orderService->setProduct($product);
        // 计算订单总价
        $this->orderService->calculateThePrice();
        /**
         * 这里是优惠券处理逻辑.
         */
        if (isset($data['coupon_code']) && $product['isopen_coupon'] == 1) {
            // 先查出有没有优惠券
            $coupon = $this->couponService->couponByProduct($data['pid'], $data['coupon_code']);
            if (!$coupon) throw new AppException(__('prompt.coupon_does_not_exist'));
            $this->orderService->setCoupon($coupon);
        }
        /**
         * 如果是代充，配置输入框
         */
        if ($product['pd_type'] == 2 && !empty($product['other_ipu'])) {
            // 如果有其他输入框 判断其他输入框内容  然后载入信息
            $this->orderService->formatChargeInput($data);
        }
        // 缓存订单
        $orderId = $this->orderService->cacheOrder();
        return redirect(url('/bill', ['orderid' => $orderId]));
    }

    /**
     * 结账.
     * @param $orderid
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws AppException
     */
    public function bill($orderid)
    {
        $orderCache = Redis::hget('PENDING_ORDERS_LIST', $orderid);
        if (empty($orderCache)) throw new AppException(__('prompt.order_does_not_exist'));
        $orderInfo = json_decode($orderCache, true);
        return $this->view('static_pages/bill', $orderInfo);
    }

    /**
     * 获取订单支付状态
     * @param $oid
     * @return \Illuminate\Http\JsonResponse
     */
    public function getOrderStatus($oid)
    {
        $orderInfo = json_decode(Redis::hget('PENDING_ORDERS_LIST', $oid), true);
        $isSuccess = Redis::hget('ORDERS_SUCCESS_LIST', $oid);
        if (!$orderInfo && !$isSuccess) {
            return response()->json(['msg' => __('prompt.order_time_out'), 'code' => 400001]);
        }
        if (!$isSuccess) {
            return response()->json(['msg' => __('prompt.order_wait_for_payment'), 'code' => 400000]);
        }
        return response()->json(['msg' => __('prompt.order_payment_success'), 'code' => 200, 'oid' => $oid]);
    }

    /**
     * 通过订单号查询
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchOrderById($oid = "")
    {
        $orderId =  \request()->input('order_id') ? \request()->input('order_id') : $oid;
        $order = $this->orderService->orderById($orderId);
        if (empty($orderId) || empty($order)) throw new AppException(__('prompt.order_does_not_exist'));
        return $this->view('static_pages/orderinfo', ['orders' => $order]);
    }

    /**
     *根据账户信息查询
     */
    public function searchOrderByAccount(Request $request)
    {
        $data = $request->only(['account', 'search_pwd']);
        if (
            empty($data['account']) ||
            (config('webset.isopen_searchpwd') == 1 && !isset($data['search_pwd']))
        ) {
            throw new AppException(__('prompt.required_fields_cannot_be_empty'));
        }

        $orders = $this->orderService->searchOrderByAccount($data['account'], $data['search_pwd']);
        if (empty($orders)) throw new AppException(__('prompt.no_related_order_found'));
        return $this->view('static_pages/orderinfo', ['orders' => $orders]);
    }

    /**
     * 根据浏览器缓存查询订单
     */
    public function searchOrderByBrowser()
    {
        $cookies = Cookie::get('orders');
        if (empty($cookies)) throw new AppException(__('prompt.no_related_order_found_for_cache'));
        $orderIds = json_decode($cookies, true);
        $orders = $this->orderService->ordersByIds($orderIds);
        if (empty($orders)) throw new AppException(__('prompt.no_related_order_found_for_cache'));
        return $this->view('static_pages/orderinfo', ['orders' => $orders]);

    }

}
