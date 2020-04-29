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
     * 商品列表
     * @param Request $request
     */
    public function productlist(Request $request)
    {	header('Content-type: application/json');
        $data = $request->all();
        $tid=$data['tid'];
        $passwd=Classifys::where('id', $tid)->get()[0]['passwd'];
        if($passwd) {
            if(isset($data['password'])) {
                if($passwd!=$data['password']) {
                    die('{"code":"1002","msg":"密码错误"}');
                }
            } else {
                die('{"code":"1002","msg":"密码错误"}');
            }
        }
        $products= Classifys::with(['products' => function($query) {
            $query->where('pd_status', 1)->orderBy('ord', 'desc');
        }
        ])->where('id', $tid)->orderBy('ord', 'desc')->get()->toArray()[0]['products'];
        foreach ($products as $key=>$value) {
            $productlist[$key] = [
                'id'=>$value['id'],
                'name'=>$value['pd_name'],
                'password'=>''
            ];
            if($value['passwd']!=''){
                $productlist[$key]['password']='hidden';
            }
        }
        $arr=[
            'code' => 1,
            'data' => ['products'=>$productlist],
            'msg' => 'success',

        ];
        die(json_encode($arr));
    }

    /**
     * 商品信息
     * @param Products $pid
     */
    public function proudctinfo(Request $request)
    {
        header('Content-type: application/json');
        $data = $request->all();
        $pid=$data['pid'];
        $pid=Products::where('id', $pid)->get()[0];
        $passwd=$pid['passwd'];
        if($passwd) {
            if(isset($data['password'])) {
                if($passwd!=$data['password']) {
                    die('{"code":"1002","msg":"密码错误"}');
                }
            } else {
                die('{"code":"1002","msg":"密码错误"}');
            }
        }
        $product = $pid->toArray();
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
        unset($product['passwd']);
        unset($product['deleted_at']);
        unset($product['updated_at']);
        unset($product['created_at']);
        unset($product['pd_class']);
        unset($product['pd_status']);
        unset($product['ord']);
        unset($product['sales_volume']);
        $product['pd_picture']=\Illuminate\Support\Facades\Storage::disk('admin')->url($product['pd_picture']);
        $productinfo=[
            'code'=>1,
            'data'=>$product,
            'msg'=>'success'
        ];
        die(json_encode($productinfo));
        //return $this->view('static_pages/buy', $product);
    }

    /**
     * 支付方式
     */
    public function payways()
    {	header('Content-type: application/json');
        $pays = Pays::where('pay_status', 1)->get()->toArray();
        foreach ($pays as $key=>$value) {
            $payways[]=[
                'name'=>$value['pay_name'],
                'value'=>$value['id']

            ];
        }
        $arr=[
            'code' => 1,
            'data' => ['payways'=>$payways],
            'msg' => 'success',

        ];
        die(json_encode($arr));

    }
}
