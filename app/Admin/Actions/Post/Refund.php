<?php
/**
 * The file was created by Assimon.
 *
 * @author    assimon<ashang@utf8.hk>
 * @copyright assimon<ashang@utf8.hk>
 * @link      http://utf8.hk/
 */

namespace App\Admin\Actions\Post;


use App\Models\Order;
use Yansongda\Pay\Pay;
use Dcat\Admin\Grid\RowAction;
use Illuminate\Http\Request;
use App\Exceptions\RuleValidationException;

class Refund extends RowAction
{

    protected $title;

    protected $model;

    // 注意构造方法的参数必须要有默认值
    public function __construct(string $model = null)
    {
        $this->title = admin_trans('dujiaoka.refund');
        $this->model = $model;
    }

    public function handle(Request $request)
    {
        $key = $this->getKey();
        $model = $request->get('model');

        $orderModel = $model::withTrashed()->findOrFail($key);
        // 检查支付状态
        if ($orderModel->status != Order::STATUS_COMPLETED) {
            throw new RuleValidationException(__('dujiaoka.order_pay_status_error'));
        }
        // 检查支付方式
        if ($orderModel->pay_id !== 8) { // 只支持微信扫码点 native 支付
            throw new RuleValidationException(__('dujiaoka.order_refund_method_unsupport'));
        }


        $this->payService = app('Service\PayService');
        $this->payGateway = $this->payService->detailByCheck('wescan'); // 微信扫码支付（native 支付）的支付配置
        $config = [
            'app_id' => $this->payGateway->merchant_id,
            'mch_id' => $this->payGateway->merchant_key,
            'key' => $this->payGateway->merchant_pem,
            'notify_url' => url($this->payGateway->pay_handleroute . '/notify_url'),
            'return_url' => url('detail-order-sn', ['orderSN' => $orderModel->order_sn]),
            'cert_client' => storage_path('apiclient_cert.pem'),
            'cert_key' => storage_path('apiclient_key.pem'),
            'http' => [ // optional
                'timeout' => 10.0,
                'connect_timeout' => 10.0,
                'verify' => false,
            ],
        ];
        $order = [
            'out_trade_no' => $orderModel->order_sn,
            'out_refund_no' => sprintf('refund_%s_%s', date('Ymdhis'), $orderModel->order_sn),
            'total_fee' => intval(bcmul($orderModel->total_price, 100, 0)),
            'refund_fee' => intval(bcmul($orderModel->actual_price, 100, 0)),
            'refund_desc' => '订单退款',
        ];

        $result = Pay::wechat($config)->refund($order)->toArray();

        if ($result['return_code'] != 'SUCCESS') {
            return $this->response()->success(admin_trans('dujiaoka.refund_already_submit'))->refresh();
        }

        $orderModel->update([
            'status' => $model::STATUS_REFUNDED,
        ]);
        return $this->response()->success(admin_trans('dujiaoka.refund_success'))->refresh();
    }

    public function confirm()
    {
        return [admin_trans('dujiaoka.are_you_refund_sure')];
    }

    public function parameters()
    {
        return [
            'model' => $this->model,
        ];
    }

}
