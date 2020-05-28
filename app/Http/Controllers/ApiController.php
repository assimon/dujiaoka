<?php
/**
 * ApiController.php
 * Author iLay1678
 * Created on 2020/4/29 18:38
 */

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

class ApiController extends Controller
{
    /**
     * 分类列表
     */
    public function typelist()
    {
        header('Content-type: application/json');
        $list = Classifys::where('c_status', 1)->orderBy('ord', 'desc')->get()->toArray();
        foreach ($list as $key => $value) {
            $typelist[$key] = [
                'id' => $value['id'],
                'name' => $value['name'],
                'password' => ''
            ];
            if ($value['passwd'] != '') {
                $typelist[$key]['password'] = 'hidden';
            }
        }
        $arr = [
            'code' => 1,
            'data' => ['typelist' => $typelist],
            'msg' => 'success',

        ];
        return $arr;
    }

    /**
     * 商品列表
     * @param Request $request
     */
    public function productlist(Request $request)
    {
        header('Content-type: application/json');
        $data = $request->all();
        $tid = $data['tid'];
        $passwd = Classifys::where('id', $tid)->orderBy('ord', 'desc')->get()[0]['passwd'];
        if ($passwd) {
            if (isset($data['password'])) {
                if ($passwd != $data['password']) {
                    $msg = "分类密码错误";
                    return ['code' => -1, 'msg' => $msg];
                }
            } else {
                $msg = "分类密码不能为空";
                return ['code' => -1, 'msg' => $msg];
            }
        }
        $products = Classifys::with(['products' => function ($query) {
            $query->where('pd_status', 1)->orderBy('ord', 'desc');
        }
        ])->where('id', $tid)->orderBy('ord', 'desc')->get()->toArray()[0]['products'];
        foreach ($products as $key => $value) {
            $productlist[$key] = [
                'id' => $value['id'],
                'name' => $value['pd_name'],
                'password' => ''
            ];
            if ($value['passwd'] != '') {
                $productlist[$key]['password'] = 'hidden';
            }
        }
        $arr = [
            'code' => 1,
            'data' => ['products' => $productlist],
            'msg' => 'success',

        ];
        return $arr;
    }

    /**
     * 商品信息
     * @param Products $pid
     */
    public function proudctinfo(Request $request)
    {
        header('Content-type: application/json');
        $data = $request->all();
        $pid = $data['pid'];
        $pid = Products::where('id', $pid)->get()[0];
        $passwd = $pid['passwd'];
        if ($passwd) {
            if (isset($data['password'])) {
                if ($passwd != $data['password']) {
                    $msg = "商品密码错误";
                    return ['code' => -1, 'msg' => $msg];
                }
            } else {
                $msg = "商品密码不能为空";
                return ['code' => -1, 'msg' => $msg];
            }
        }
        $product = $pid->toArray();
        if ($product['pd_status'] != 1) {
            $msg = "商品不存在";
            return ['code' => -1, 'msg' => $msg];
        }
        // 格式化批发配置以及输入框配置
        if ($product['wholesale_price']) {
            $dityArr = explode(PHP_EOL, $product['wholesale_price']);
            $dityList = [];
            foreach ($dityArr as $key => $v) {
                if ($v != "") {
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
                if ($v != "") {
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
        unset($product['passwd']);
        unset($product['deleted_at']);
        unset($product['updated_at']);
        unset($product['created_at']);
        unset($product['pd_class']);
        unset($product['pd_status']);
        unset($product['ord']);
        unset($product['sales_volume']);
        $product['pd_picture'] = \Illuminate\Support\Facades\Storage::disk('admin')->url($product['pd_picture']);
        $productinfo = [
            'code' => 1,
            'data' => $product,
            'msg' => 'success'
        ];
        return $productinfo;
    }

    /**
     * 支付方式
     */
    public function payways()
    {
        header('Content-type: application/json');
        $pays = Pays::where('pay_status', 1)->get()->toArray();
        foreach ($pays as $key => $value) {
            $payways[] = [
                'name' => $value['pay_name'],
                'value' => $value['id']

            ];
        }
        $arr = [
            'code' => 1,
            'data' => ['payways' => $payways],
            'msg' => 'success',

        ];
        return $arr;

    }

    /**
     * 通过订单号查询
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchOrderById($oid = "")
    {
        header('Content-type: application/json');
        $orderId = \request()->input('order_id') ? \request()->input('order_id') : $oid;
        if ($orderId == '') {
            $msg = "订单号码不能为空";
            return ['code' => -1, 'msg' => $msg];
        }
        $orders = Orders::where('order_id', $orderId)->get()->toArray();
        if (!$orders) {
            $msg = "未找到相关订单";
            return ['code' => -1, 'msg' => $msg];
        }
        foreach ($orders as $order) {


            switch ($order['ord_status']) {
                case '1':
                    $order['order_status'] = '待处理';
                    break;
                case '2':
                    $order['order_status'] = '已处理';
                    break;
                case '3':
                    $order['order_status'] = '已完成';
                    break;
                case '4':
                    $order['order_status'] = '已失败';
                    break;
                default:
                    $order['order_status'] = '查询失败';
            }
            switch ($order['ord_class']) {
                case '1':
                    $order['ord_class'] = '自动发货';
                    break;
                case '2':
                    $order['ord_class'] = '代充';
                    break;
                default:
                    $order['ord_class'] = '查询失败';
            }
            $order['pay_way'] = \App\Models\Pays::find($order['pay_way'])->pay_name;
            $orderinfo[] = [
                'order_id' => $order['order_id'],
                'order_title' => $order['ord_title'],
                'buy_amount' => $order['buy_amount'],
                'created_at' => $order['created_at'],
                'account' => $order['account'],
                'order_price' => $order['ord_price'],
                'order_status' => $order['order_status'],
                'pay_way' => $order['pay_way'],
                'order_info' => $order['ord_info'],
                'order_class' => $order['ord_class'],

            ];

        }

        $arr = [
            'code' => 1,
            'data' => $orderinfo,
            'msg' => 'success'
        ];
        return $arr;
    }

    /**
     *根据账户信息查询
     */
    public function searchOrderByAccount(Request $request)
    {
        header('Content-type: application/json');
        $data = $request->only(['account', 'search_pwd']);
        if (empty($data['account']) || empty($data['search_pwd'])) {
            $msg = "必填项不能为空";
            return ['code' => -1, 'msg' => $msg];
        }
        $orders = Orders::where(['account' => $data['account'], 'search_pwd' => $data['search_pwd']])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->toArray();
        if (empty($orders)) {
            $msg = "未找到相关订单";
            return ['code' => -1, 'msg' => $msg];
        }
        foreach ($orders as $order) {


            switch ($order['ord_status']) {
                case '1':
                    $order['order_status'] = '待处理';
                    break;
                case '2':
                    $order['order_status'] = '已处理';
                    break;
                case '3':
                    $order['order_status'] = '已完成';
                    break;
                case '4':
                    $order['order_status'] = '已失败';
                    break;
                default:
                    $order['order_status'] = '查询失败';
            }
            switch ($order['ord_class']) {
                case '1':
                    $order['ord_class'] = '自动发货';
                    break;
                case '2':
                    $order['ord_class'] = '代充';
                    break;
                default:
                    $order['ord_class'] = '查询失败';
            }
            $order['pay_way'] = \App\Models\Pays::find($order['pay_way'])->pay_name;
            $orderinfo[] = [
                'order_id' => $order['order_id'],
                'order_title' => $order['ord_title'],
                'buy_amount' => $order['buy_amount'],
                'created_at' => $order['created_at'],
                'account' => $order['account'],
                'order_price' => $order['ord_price'],
                'order_status' => $order['order_status'],
                'pay_way' => $order['pay_way'],
                'order_info' => $order['ord_info'],
                'order_class' => $order['ord_class'],

            ];

        }

        $arr = [
            'code' => 1,
            'data' => $orderinfo,
            'msg' => 'success'
        ];
        return $arr;
    }

    /**
     * 根据浏览器缓存查询订单
     */
    public function searchOrderByBrowser()
    {
        header('Content-type: application/json');
        $cookies = Cookie::get('orders');
        if (empty($cookies)) {
            $msg = "未找到相关订单";
            return ['code' => -1, 'msg' => $msg];
        }
        $orderIds = json_decode($cookies, true);
        $orders = Orders::whereIn('order_id', $orderIds)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->toArray();
        if (empty($orders)) {
            $msg = "未找到相关订单";
            return ['code' => -1, 'msg' => $msg];
        }
        foreach ($orders as $order) {


            switch ($order['ord_status']) {
                case '1':
                    $order['order_status'] = '待处理';
                    break;
                case '2':
                    $order['order_status'] = '已处理';
                    break;
                case '3':
                    $order['order_status'] = '已完成';
                    break;
                case '4':
                    $order['order_status'] = '已失败';
                    break;
                default:
                    $order['order_status'] = '查询失败';
            }
            switch ($order['ord_class']) {
                case '1':
                    $order['ord_class'] = '自动发货';
                    break;
                case '2':
                    $order['ord_class'] = '代充';
                    break;
                default:
                    $order['ord_class'] = '查询失败';
            }
            $order['pay_way'] = \App\Models\Pays::find($order['pay_way'])->pay_name;
            $orderinfo[] = [
                'order_id' => $order['order_id'],
                'order_title' => $order['ord_title'],
                'buy_amount' => $order['buy_amount'],
                'created_at' => $order['created_at'],
                'account' => $order['account'],
                'order_price' => $order['ord_price'],
                'order_status' => $order['order_status'],
                'pay_way' => $order['pay_way'],
                'order_info' => $order['ord_info'],
                'order_class' => $order['ord_class'],

            ];

        }

        $arr = [
            'code' => 1,
            'data' => $orderinfo,
            'msg' => 'success'
        ];
        return $arr;

    }

    /**
     * 提交订单
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function postOrder(Request $request)
    {
        header('Content-type: application/json');
        $data = $request->all();
        if (empty($data['order_number'])) {
            $data['order_number'] = 0;
        }
        if ($data['order_number'] <= 0) {
            $msg = "购买数量不能为0";
            return ['code' => -1, 'msg' => $msg];
        }
        if (!is_numeric($data['order_number']) || strpos($data['order_number'], ".") !== false) {
            $msg = "请填正确购买数量";
            return ['code' => -1, 'msg' => $msg];
        }
        if (empty($data['search_pwd'])) {
            $msg = "查询密码不能为空";
            return ['code' => -1, 'msg' => $msg];
        }
        if (config('app.shcaptcha')) {
            if (empty($data['verify_img'])) {
                $msg = "验证码不能为空";
                return ['code' => -1, 'msg' => $msg];
            }
            if (!captcha_check($data['verify_img'])) {
                $msg = "验证码错误";
                return ['code' => -1, 'msg' => $msg];
            }
        }
        $product = Products::find($data['pid']);
        if (empty($product)) {
            $msg = "商品不存在或已下架";
            return ['code' => -1, 'msg' => $msg];
        }
        if ($product['pd_status'] != 1){
        $msg="商品不存在或已下架";
        return ['code'=>-1,'msg'=>$msg];
    }
        if ($product['in_stock'] == 0 || $data['order_number'] > $product['in_stock']) {
            $msg = "库存不足";
            return ['code' => -1, 'msg' => $msg];
        }
        if (!isset($data['payway'])) {
            $msg = "支付方式不能为空";
            return ['code' => -1, 'msg' => $msg];
        }
        if (!filter_var($data['account'], FILTER_VALIDATE_EMAIL) || empty($data['account'])) {
            $msg = "请输入正确邮箱格式";
            return ['code' => -1, 'msg' => $msg];
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
            'buy_amount' => intval($data['order_number']), // 订单个数
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
            if (empty($coupon)) {
                $msg = "优惠券码不存在！请检查";
                return ['code' => -1, 'msg' => $msg];
            }
            // 判断类型  如果是一次性的话  先判断使用没有
            if ($coupon['c_type'] == 1 && $coupon['is_status'] == 2) {
                $msg = "该优惠券已被使用，请勿重复使用";
                return ['code' => -1, 'msg' => $msg];
            }
            if ($coupon['c_type'] == 2 && $coupon['ret'] <= 0) {
                $msg = "该优惠券已无剩余次数,请更换";
                return ['code' => -1, 'msg' => $msg];
            }
            if ($cacheOrder['actual_price'] <= $coupon['discount']) {
                $msg = "优惠券金额已经大于或等于实际支付金额，无法使用该优惠券";
                return ['code' => -1, 'msg' => $msg];
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
                        $msg = $otherIpu[1] . '不能为空，请仔细填写';
                        return ['code' => -1, 'msg' => $msg];

                    }
                    $cacheOrder['other_ipu'] .= $otherIpu[1] . ':' . $data[$otherIpu[0]] . PHP_EOL;
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
            $inCouponNum = Coupons::where('card', '=', $data['coupon_code'])->decrement('ret', 1);
        } else {
            $inCoupon = true;
            $inCouponNum = true;
        }
        if (!$deStock || !$inCoupon || !$inCouponNum) {
            Redis::hdel('PENDING_ORDERS_LIST', $cacheOrder['order_id']);
            DB::rollBack();
            $msg = "订单提交失败，过会再试吧~";
            return ['code' => -1, 'msg' => $msg];
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
        ReleaseOrder::dispatch($cacheOrder['order_id'], $data['order_number'], $data['pid'])->delay(Carbon::now()->addMinutes(config('app.order_expire_date')));
        $bill['actual_price'] = $cacheOrder['actual_price'];
        $bill['pay_way'] = \App\Models\Pays::find($cacheOrder['pay_way'])->pay_name;
        $bill['pay_url'] = url(\App\Models\Pays::find($cacheOrder['pay_way'])->pay_handleroute, ['payway' => $cacheOrder['pay_way'], 'oid' => $cacheOrder['order_id']]);
        $arr = [
            'code' => 1,
            'data' => $bill,
            'msg' => 'success'
        ];
        return $arr;
    }
}
