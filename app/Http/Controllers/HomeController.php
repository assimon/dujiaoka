<?php

namespace App\Http\Controllers;

use App\Jobs\ReleaseOrder;
use App\Models\Classifys;
use App\Models\Coupons;
use App\Models\Orders;
use App\Models\Pays;
use App\Models\Products;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Str;

class HomeController extends Controller
{

    /**
     * 首页加载所有商品
     */
    public function index()
    {
        $products = Classifys::with(['products' => function($query) {
            $query->where('pd_status', 1)->orderBy('ord', 'desc');
        }])->where('c_status', 1)->orderBy('ord', 'desc')->get()->toArray();
        return $this->view('static_pages/home', ['classifys' => $products]);
    }

    /**
     * 商品详情
     * @param Products $product
     */
    public function buy(Products $product)
    {
        $product = $product->toArray();
        if ($product['pd_status'] != 1) {
            return $this->error('   商品信息不存在！');
        }
        // 格式化批发配置以及输入框配置
        if ($product['wholesale_price']) {
            $dityArr = explode(PHP_EOL, $product['wholesale_price']);
            $dityList = [];
            foreach ($dityArr as $key => $v) {
                if($v != ""){
                    $dityInfo = explode('=', delete_html($v));
                    $dityList[$key]['number'] = $dityInfo[0];
                    $dityList[$key]['price'] = $dityInfo[1];
                }
            }
            sort($dityList);
            $product['wholesale_price'] = $dityList;
        } else {
            $product['wholesale_price'] = null;
        }
        // 如果存在其他配置输入框且为代充
        if ($product['other_ipu'] && $product['pd_type'] == 2) {
            $inputArr = explode(PHP_EOL, $product['other_ipu']);
            $inputList = [];
            foreach ($inputArr as $key => $v) {
                if($v != ""){
                    $inputInfo = explode('=', delete_html($v));
                    $inputList[$key]['field'] = $inputInfo[0];
                    $inputList[$key]['desc'] = $inputInfo[1];
                    $inputList[$key]['rule'] = filter_var($inputInfo[2], FILTER_VALIDATE_BOOLEAN);
                }
            }
            $product['other_ipu'] = $inputList;
        } else {
            $product['other_ipu'] = null;
        }
        // 加载支付方式
        $product['payways'] = Pays::where('pay_status', 1)->get()->toArray();
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
        if ($data['order_number'] <= 0) {
            return $this->error('购买数量不能为0');
        }
        if(!is_numeric($data['order_number']) || strpos($data['order_number'],".") !== false){
            return $this->error('请填正确购买数量');
        }
        if (empty($data['search_pwd'])) {
            return $this->error('查询密码不能为空');
        }
        $product = Products::find($data['pid']);
        if (empty($product)) {
            return $this->error('商品不存在或已下架');
        }

        if ($product['in_stock'] == 0 || $data['order_number'] > $product['in_stock']){
            return $this->error('库存不足');
        }
        if (!isset($data['payway'])) {
            return $this->error('支付方式不能为空');
        }
        if ($product['pd_type'] == 1) {
            if (!filter_var($data['account'],FILTER_VALIDATE_EMAIL) || empty($data['account'])) {
                return $this->error('请输入正确邮箱格式');
            }
        }
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
            'buy_amount' => $data['order_number'], // 订单个数
            'account' => $data['account'], // 充值账号
            'search_pwd' => $data['search_pwd'],
            'buy_ip' => $request->getClientIp(),
            'other_ipu' => ''
        ];
        // 如果存在批发价
        if (!empty($product['wholesale_price'])) {
            $cacheOrder['actual_price'] = number_format(Orders::wholesalePrice($cacheOrder, $product, $data), 2);
        } else {
            $cacheOrder['actual_price'] = number_format(($cacheOrder['actual_price'] * $data['order_number']), 2);
        }
        /**
         * 这里是优惠券
         */
        if (!empty($data['coupon_code'])) {
            // 先查出有没有优惠券
            $coupon = Coupons::where('card', '=', $data['coupon_code'])->where('product_id', '=', $data['pid'])->first();
            if (empty($coupon)) return $this->error('优惠券码不存在！请检查');
            // 判断类型  如果是一次性的话  先判断使用没有
            if ($coupon['c_type'] == 1 && $coupon['is_status'] == 2) {
                return $this->error('该优惠券已被使用，请勿重复使用');
            }
            if ($coupon['c_type'] == 2 && $coupon['ret'] <= 0) {
                return $this->error('该优惠券已无剩余次数,请更换');
            }
            if ($cacheOrder['actual_price'] <= $coupon['discount']) {
                return $this->error('优惠券金额已经大于或等于实际支付金额，无法使用该优惠券');
            }
            $cacheOrder['coupon_type'] = $coupon['c_type'];
            $cacheOrder['coupon_id'] = $coupon['id'];
            $cacheOrder['coupon_code'] = $data['coupon_code'];
            $cacheOrder['discount'] = number_format($coupon['discount'], 2);
            $cacheOrder['actual_price'] = number_format(($cacheOrder['actual_price'] - $coupon['discount']), 2);
        }

        if ($product['pd_type'] == 2) {
            // 如果有其他输入框 判断其他输入框内容  然后载入信息
            if (!empty($product['other_ipu'])) {
                $otherIpuAll = explode(PHP_EOL, $product['other_ipu']);
                foreach ($otherIpuAll as $value) {
                    $otherIpu = explode('=', delete_html($value));
                    if ($otherIpu[2] == 'req' && empty($data[$otherIpu[0]])) {
                        return $this->error($otherIpu[1].'不能为空，请仔细填写');
                    }
                    $cacheOrder['other_ipu'] .= $otherIpu[1].':'.$data[$otherIpu[0]].PHP_EOL;
                }
            }
        }
        // 将订单信息载入缓存，等待支付
        Redis::hset('PENDING_ORDERS_LIST', $cacheOrder['order_id'], json_encode($cacheOrder));
        // 开始事务
        DB::beginTransaction();
        // 减去数据库库存
        $deStock = Products::where('id', '=', $data['pid'])->decrement('in_stock', $data['order_number']);
        if ($data['coupon_code']) {
            // 将优惠券设置为已经使用 且次数-1
            $inCoupon = Coupons::where('card', '=', $data['coupon_code'])->update(['is_status' => 2]);
            $inCouponNum =  Coupons::where('card', '=', $data['coupon_code'])->decrement('ret', 1);
        } else {
            $inCoupon = true;
            $inCouponNum = true;
        }
        if (!$deStock || !$inCoupon || !$inCouponNum) {
            Redis::hdel('PENDING_ORDERS_LIST', $cacheOrder['order_id']);
            DB::rollBack();
            return $this->error('订单提交失败，过会再试吧~');
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
        if (empty($orderCache)) return $this->error('该订单不存在或已过期！', url('/'));
        $orderInfo = json_decode($orderCache, true);
        return $this->view('static_pages/bill', $orderInfo);
    }





}
