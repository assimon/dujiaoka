<?php

namespace App\Http\Controllers;

use App\Exceptions\AppException;
use App\Jobs\ReleaseOrder;
use App\Models\Classifys;
use App\Models\Coupons;
use App\Models\Pays;
use App\Models\Products;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
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
        if ($product['pd_status'] != 1) throw new AppException(__('prompt.please_select_mode_of_payment'));
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
        $data = $request->all();
        if (intval($data['order_number']) <= 0)
        if(!is_numeric($data['order_number']) || strpos($data['order_number'],".") !== false) throw new AppException(__('prompt.buy_order_number'));
        if (empty($data['search_pwd'])) throw new AppException(__('prompt.search_password_not_null'));
        if (!captcha_check($data['verify_img'])) throw new AppException(__('prompt.verify_code_error'));
        $product = Products::find($data['pid']);
        if (empty($product) || $product['pd_status'] != 1) throw new AppException(__('prompt.please_select_mode_of_payment'));
        if ($product['in_stock'] == 0 || $data['order_number'] > $product['in_stock']) throw new AppException(__('prompt.inventory_shortage'));
        if (!isset($data['payway'])) throw new AppException(__('prompt.please_select_mode_of_payment'));
        if (!filter_var($data['account'],FILTER_VALIDATE_EMAIL) || empty($data['account'])) throw new AppException(__('prompt.check_email_format'));
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
            'search_pwd' => $data['search_pwd'],
            'buy_ip' => $request->getClientIp(),
            'other_ipu' => ''
        ];
        // 如果存在批发价
        if (!empty($product['wholesale_price'])) {
            $cacheOrder['actual_price'] = OrderService::getWholesalePrice(
                ProductsService::formatWholesalePrice($product['wholesale_price']),
                $cacheOrder['actual_price'],
                $cacheOrder['buy_amount']
            );
        } else {
            $cacheOrder['actual_price'] = number_format(($cacheOrder['actual_price'] * $cacheOrder['buy_amount']), 2, '.', '');
        }
        /**
         * 这里是优惠券
         */
        if (!empty($data['coupon_code'])) {
            // 先查出有没有优惠券
            $coupon = Coupons::where('card', '=', $data['coupon_code'])->where('product_id', '=', $data['pid'])->first();
            if (empty($coupon)) throw new AppException(__('prompt.coupon_does_not_exist'));
            // 判断类型  如果是一次性的话  先判断使用没有
            if ($coupon['c_type'] == 1 && $coupon['is_status'] == 2) {
                throw new AppException(__('prompt.coupon_already_used'));
            }
            if ($coupon['c_type'] == 2 && $coupon['ret'] <= 0) {
                throw new AppException(__('prompt.coupon_no_more'));
            }
            if ($cacheOrder['actual_price'] <= $coupon['discount']) {
                throw new AppException(__('prompt.coupon_price_error'));
            }
            $cacheOrder['coupon_type'] = $coupon['c_type'];
            $cacheOrder['coupon_id'] = $coupon['id'];
            $cacheOrder['coupon_code'] = $data['coupon_code'];
            $cacheOrder['discount'] = number_format($coupon['discount'], 2, '.', '');
            $cacheOrder['actual_price'] = number_format(($cacheOrder['actual_price'] - $coupon['discount']), 2, '.', '');
        }

        if ($product['pd_type'] == 2) {
            // 如果有其他输入框 判断其他输入框内容  然后载入信息
            if (!empty($product['other_ipu'])) {
                $otherIpuAll =  ProductsService::formatChargeInput($product['other_ipu']);
                foreach ($otherIpuAll as $value) {
                    if ($value['rule'] && empty($data[$value['field']])) {
                        throw new AppException("{$value['desc']}" . __('prompt.charge_not_null'));
                    }
                    $cacheOrder['other_ipu'] .= $value['desc'].':'.$data[$value['field']].PHP_EOL;
                }
            }
        }
        // 将订单信息载入缓存，等待支付
        Redis::hset('PENDING_ORDERS_LIST', $cacheOrder['order_id'], json_encode($cacheOrder));
        // 开始事务
        DB::beginTransaction();
        // 减去数据库库存
        $deStock = Products::where(['id' => $data['pid'], 'in_stock' => $product['in_stock']])->decrement('in_stock', $data['order_number']);
        if ($data['coupon_code']) {
            // 将优惠券设置为已经使用 且次数-1
            $inCoupon = Coupons::where('card', '=', $data['coupon_code'])->update(['is_status' => 2]);
            $inCouponNum =  Coupons::where(['card' => $data['coupon_code'], 'ret' => $coupon['ret']])->decrement('ret', 1);
        } else {
            $inCoupon = true;
            $inCouponNum = true;
        }
        if (!$deStock || !$inCoupon || !$inCouponNum) {
            Redis::hdel('PENDING_ORDERS_LIST', $cacheOrder['order_id']);
            DB::rollBack();
            throw new AppException(__('prompt.order_post_error'));
        }
        DB::commit();
        // 设置订单cookie
        $cookies = Cookie::get('orders');
        if (empty($cookies)) {
            Cookie::queue('orders', json_encode([$cacheOrder['order_id']]));
        } else {
            $cookies = json_decode($cookies, true);
            array_push($cookies, $cacheOrder['order_id']);
            Cookie::queue('orders', json_encode($cookies));
        }
        // 将过期释放的订单载入队列 x分钟后释放
        ReleaseOrder::dispatch($cacheOrder['order_id'],  $data['order_number'], $data['pid'])->delay(Carbon::now()->addMinutes(config('app.order_expire_date')));
        return redirect(url('/bill', ['orderid' => $cacheOrder['order_id']]));
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
