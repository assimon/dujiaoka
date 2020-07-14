<?php

namespace App\Http\Controllers;

use App\Exceptions\AppException;
use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redis;

class OrdersController extends Controller
{

    /**
     * 查询订单首页
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchOrder()
    {
        return $this->view('static_pages/searchOrder');
    }

    /**
     * 获取订单支付状态
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
        $order = Orders::where('order_id', $orderId)->get();
        if (empty($orderId) || empty($order)) throw new AppException(__('prompt.order_does_not_exist'));
        return $this->view('static_pages/orderinfo', ['orders' => $order]);
    }

    /**
     *根据账户信息查询
     */
    public function searchOrderByAccount(Request $request)
    {
        $data = $request->only(['account', 'search_pwd']);
        $data['search_pwd'] = $data['search_pwd'] ?? 'dujiaoka';
        if (empty($data['account']) || (config('webset.isopen_searchpwd') == 1 && empty($data['search_pwd']))) throw new AppException(__('prompt.required_fields_cannot_be_empty'));
        $where['account'] = $data['account'];
        $orders = Orders::where(['account' => $data['account'], 'search_pwd' => $data['search_pwd']])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
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
        $orders = Orders::whereIn('order_id', $orderIds)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();
        if (empty($orders)) throw new AppException(__('prompt.no_related_order_found_for_cache'));
        return $this->view('static_pages/orderinfo', ['orders' => $orders]);

    }


}
