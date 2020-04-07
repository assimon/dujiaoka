<?php

namespace App\Http\Controllers;

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
            return response()->json(['msg' => '订单已过期', 'code' => 400001]);
        }
        if (!$isSuccess) {
            return response()->json(['msg' => '等待支付', 'code' => 400000]);
        }
        return response()->json(['msg' => '支付成功', 'code' => 200, 'oid' => $oid]);
    }

    /**
     * 通过订单号查询
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function searchOrderById($oid = "")
    {
        $orderId =  \request()->input('order_id') ? \request()->input('order_id') : $oid;
        $order = Orders::where('order_id', $orderId)->get()->toArray();
        if (empty($orderId) || empty($order)) return $this->error('订单信息不存在！', url('searchOrder'));
        return $this->view('static_pages/orderinfo', ['orders' => $order]);
    }

    /**
     *根据账户信息查询
     */
    public function searchOrderByAccount(Request $request)
    {
        $data = $request->only(['account', 'search_pwd']);
        if (empty($data['account']) || empty($data['search_pwd'])) return $this->error('必填项不能为空', url('searchOrder'));
        $orders = Orders::where(['account' => $data['account'], 'search_pwd' => $data['search_pwd']])
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->toArray();
        if (empty($orders)) return $this->error('未找到相关订单！', url('searchOrder'));
        return $this->view('static_pages/orderinfo', ['orders' => $orders]);
    }

    /**
     * 根据浏览器缓存查询订单
     */
    public function searchOrderByBrowser()
    {
        $cookies = Cookie::get('orders');
        if (empty($cookies)) return $this->error('未找到相关订单缓存', url('searchOrder'));
        $orderIds = json_decode($cookies, true);
        $orders = Orders::whereIn('order_id', $orderIds)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get()
            ->toArray();
        if (empty($orders)) return $this->error('未找到相关订单！', url('searchOrder'));
        return $this->view('static_pages/orderinfo', ['orders' => $orders]);

    }


}
