<?php
/**
 * Created by PhpStorm.
 * User: simon
 * Date: 2019-03-07
 * Time: 16:13
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiController;
use App\Jobs\SendEmail;
use App\Models\Classify;
use App\Models\Commodity;
use App\Models\Orders;
use App\Models\Payconfig;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use SebastianBergmann\CodeCoverage\Report\PHP;
use App\Jobs\CleanUpStock;
use Illuminate\Support\Facades\Validator;

class IndexController extends ApiController
{


    public function getSysInfo()
    {
        $sysinfo = [
            'sys_name' => config('SYS_NAME'),
            'sys_describe' => config('SYS_DESCRIBE'),
            'sys_icp'   => config('SYS_ICP'),
            'sys_index_tips' => config('SYS_INDEX_TIPS'),
            'sys_top_tips' => config('SYS_TOP_TIPS')
        ];
        return $this->success($sysinfo);
    }


    /**
     * 获取所有商品分类
     */
    public function getClassifyAll()
    {
        $classAll = Classify::where('c_status', '=', '1')->orderBy('ord','desc')->get()->toArray();
        $headArr = [
            'id' => 0,
            'name' => '所有商品',
            'ico' => '',
            'ord' => 1,
            'c_status' => 1
        ];
        array_unshift($classAll, $headArr);
        return $this->success($classAll);
    }

    /**
     * 根据分类id获取商品列表
     * @param $cid
     */
    public function getCommodityAllByClassId($cid, $p = 0)
    {
        $p = $p ? $p : 1;
        $where['pd_status'] = 1;
        if ($cid != 0) {
            $where['pd_type'] = $cid;
        }
        $commodityAll = Commodity::where($where)
            ->orderBy('pd_ord','desc')
            ->paginate(20,['*'], null, $p)
            ->toArray();
        return $this->success($commodityAll);
    }


    /**
     * 根据商品id获取商品详情
     * @param $cid
     * @return mixed
     */
    public function getCommodityInfoByClassId($cid)
    {
        $commodityInfo = Commodity::where(['id' => $cid, 'pd_status' => 1])->first()->toArray();
        if(empty($commodityInfo)) {
            return $this->failed('商品不存在或已下架');
        }
        $commodityInfo['wholesale_price'] = null;
        $commodityInfo['other_ipu'] = null;
        $payAll = Payconfig::where('pay_status', '=', 1)->get(['id','pay_method','pay_name', 'pay_handleroute', 'pay_check']);
        $commodityInfo['pays'] =  $payAll;// 加载所有支付方式
        return $this->success($commodityInfo);
    }

    /**
     * 订单提交方法
     * @param Request $request
     * @return mixed
     */
    public function postOrders(Request $request)
    {
        $data = $request->all();
        if ($data['ord_number'] <= 0) {
            return $this->failed('购买数量不能为0');
        }
        if(!is_numeric($data['ord_number']) || strpos($data['ord_number'],".") !== false){
            return $this->failed('请填正确购买数量');
        }
        // 判断商品是否存在
        $commidity = Commodity::where(['id' => $data['id'], 'pd_status' => 1])->first();

        if (empty($commidity)) {
            return $this->failed('商品不存在或已下架');
        }
        if ($commidity['in_stock'] == 0 || $data['ord_number'] > $commidity['in_stock']){
            return $this->failed('库存不足');
        }
        if (!$data['pay_check'] || !$data['pay_id']) {
            return $this->failed('支付方式不能为空');
        }
        if (!filter_var($data['rcg_account'],FILTER_VALIDATE_EMAIL) || empty($data['rcg_account'])) {
            return $this->failed('当前商品为卡密，请输入正确邮箱格式');
        }
        // 订单缓存
        $cacheOrder = [
            'pid' => $data['id'], // 商品id
            'pay_id' => $data['pay_id'],
            'pay_check' => $data['pay_check'],
            'pname' => $commidity['pd_name'], // 名称
            'oid' => str_random(24), // 订单号
            'actual_price' => $commidity['actual_price'],
            'price' => $commidity['actual_price'],
            'ord_num' => $data['ord_number'], // 订单个数
            'rcg_account' => $data['rcg_account'], // 充值账号
            'search_pwd' => $data['search_pwd'], // 查询密码
        ];
        $cacheOrder['actual_price'] = $cacheOrder['actual_price'] * $data['ord_number'];
        // 将订单信息载入缓存，等待支付
        Redis::hset(config('PENDING_ORDERS_LIST'), $cacheOrder['oid'], json_encode($cacheOrder));
        // 减去数据库库存
        $inStock = Commodity::where('id', '=', $data['id'])->decrement('in_stock', $data['ord_number']);
        if (!$inStock) {
            Redis::hdel(config('PENDING_ORDERS_LIST'), $cacheOrder['oid']);
            return $this->failed('订单提交失败，请重试~');
        }
        // 将过期释放的订单载入队列 2分钟后释放
        CleanUpStock::dispatch($cacheOrder['oid'], $data['ord_number'], $data['id'])->delay(Carbon::now()->addMinutes(3))->onQueue('orderclean');
        return $this->success(['oid' => $cacheOrder['oid'], 'orderInfo' => $cacheOrder]);
    }

    /**
     * 查询订单信息
     * @param Request $request
     */
    public function searchOrder(Request $request)
    {
        $data = $request->all();
        $p = isset($data['p']) ? isset($data['p']) : 1;
        $rules = array(
            'rcg_account' => 'required',
            'search_pwd' => 'required',
        );
        $messages = ['rcg_account.required' => '请输入查询账号', 'search_pwd.required' => '请输入查询密码'];
        if (!isset($data['oid'])) {
            $validator = Validator::make($data, $rules, $messages);
            if ($validator->fails()) {
                $errors = $validator->errors();
                return $this->failed($errors->first());
            }
            $where = ['rcg_account' => $data['rcg_account'], 'search_pwd' => $data['search_pwd']];
        } else {
            $where = ['oid' => $data['oid']];
        }
        $orderInfo = Orders::where($where)
            ->orderBy('created_at','desc')
            ->paginate(20,['oid','pd_money','ord_countmoney','ord_num','rcg_account','ord_name', 'pay_type','ord_info','ord_status','created_at'], '', $p)->toArray();
        if (!$orderInfo['data']) {
            return $this->failed('订单信息不存在或查询密码错误');
        }
        foreach ($orderInfo['data'] as &$val){
            $tmpPay = Payconfig::where('id','=',$val['pay_type'])->first(['pay_name']);
            $val['pay_type'] = $tmpPay['pay_name'];
        }
        return $this->success($orderInfo);
    }


    /**
     * 获取订单支付状态
     */
    public function getOrderStatus($oid)
    {
        $orderInfo = json_decode(Redis::hget(config('PENDING_ORDERS_LIST'), $oid), true);
        $isSuccess = Redis::hget(config('ORDERS_SUCCESS_LIST'), $oid);
        if (!$orderInfo && !$isSuccess) {
            return $this->failed('订单已过期！', 311);
        }
        if (!$isSuccess) {
            return $this->failed('等待..', 325);
        }
        return $this->success(['oid' => $oid]);
    }


}