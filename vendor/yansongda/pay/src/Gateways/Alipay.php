<?php

namespace Yansongda\Pay\Gateways;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Yansongda\Pay\Contracts\GatewayApplicationInterface;
use Yansongda\Pay\Contracts\GatewayInterface;
use Yansongda\Pay\Events;
use Yansongda\Pay\Exceptions\GatewayException;
use Yansongda\Pay\Exceptions\InvalidConfigException;
use Yansongda\Pay\Exceptions\InvalidGatewayException;
use Yansongda\Pay\Exceptions\InvalidSignException;
use Yansongda\Pay\Gateways\Alipay\Support;
use Yansongda\Pay\Log;
use Yansongda\Supports\Collection;
use Yansongda\Supports\Config;
use Yansongda\Supports\Str;

/**
 * @method Response app(array $config) APP 支付
 * @method Collection pos(array $config) 刷卡支付
 * @method Collection scan(array $config) 扫码支付
 * @method Collection transfer(array $config) 帐户转账
 * @method Response wap(array $config) 手机网站支付
 * @method Response web(array $config) 电脑支付
 * @method Collection mini(array $config) 小程序支付
 */
class Alipay implements GatewayApplicationInterface
{
    /**
     * Const mode_normal.
     */
    const MODE_NORMAL = 'normal';

    /**
     * Const mode_dev.
     */
    const MODE_DEV = 'dev';

    /**
     * Const url.
     */
    const URL = [
        self::MODE_NORMAL => 'https://openapi.alipay.com/gateway.do',
        self::MODE_DEV    => 'https://openapi.alipaydev.com/gateway.do',
    ];

    /**
     * Alipay payload.
     *
     * @var array
     */
    protected $payload;

    /**
     * Alipay gateway.
     *
     * @var string
     */
    protected $gateway;

    /**
     * Bootstrap.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->gateway = Support::create($config)->getBaseUri();
        $this->payload = [
            'app_id'         => $config->get('app_id'),
            'method'         => '',
            'format'         => 'JSON',
            'charset'        => 'utf-8',
            'sign_type'      => 'RSA2',
            'version'        => '1.0',
            'return_url'     => $config->get('return_url'),
            'notify_url'     => $config->get('notify_url'),
            'timestamp'      => date('Y-m-d H:i:s'),
            'sign'           => '',
            'biz_content'    => '',
            'app_auth_token' => $config->get('app_auth_token'),
        ];
    }

    /**
     * Magic pay.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $method
     * @param array  $params
     *
     * @throws InvalidGatewayException
     *
     * @return Response|Collection
     */
    public function __call($method, $params)
    {
        return $this->pay($method, ...$params);
    }

    /**
     * Pay an order.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $gateway
     * @param array  $params
     *
     * @throws InvalidGatewayException
     *
     * @return Response|Collection
     */
    public function pay($gateway, $params = [])
    {
        Events::dispatch(Events::PAY_STARTING, new Events\PayStarting('Alipay', $gateway, $params));

        $this->payload['return_url'] = $params['return_url'] ?? $this->payload['return_url'];
        $this->payload['notify_url'] = $params['notify_url'] ?? $this->payload['notify_url'];

        unset($params['return_url'], $params['notify_url']);

        $this->payload['biz_content'] = json_encode($params);

        $gateway = get_class($this).'\\'.Str::studly($gateway).'Gateway';

        if (class_exists($gateway)) {
            return $this->makePay($gateway);
        }

        throw new InvalidGatewayException("Pay Gateway [{$gateway}] not exists");
    }

    /**
     * Verify sign.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param null|array $data
     * @param bool       $refund
     *
     * @throws InvalidSignException
     * @throws InvalidConfigException
     *
     * @return Collection
     */
    public function verify($data = null, $refund = false): Collection
    {
        if (is_null($data)) {
            $request = Request::createFromGlobals();

            $data = $request->request->count() > 0 ? $request->request->all() : $request->query->all();
            $data = Support::encoding($data, 'utf-8', $data['charset'] ?? 'gb2312');
        }

        if (isset($data['fund_bill_list'])) {
            $data['fund_bill_list'] = htmlspecialchars_decode($data['fund_bill_list']);
        }

        Events::dispatch(Events::REQUEST_RECEIVED, new Events\RequestReceived('Alipay', '', $data));

        if (Support::verifySign($data)) {
            return new Collection($data);
        }

        Events::dispatch(Events::SIGN_FAILED, new Events\SignFailed('Alipay', '', $data));

        throw new InvalidSignException('Alipay Sign Verify FAILED', $data);
    }

    /**
     * Query an order.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string|array $order
     * @param string       $type
     * @param bool         $transfer @deprecated since v2.7.3
     *
     * @throws GatewayException
     * @throws InvalidConfigException
     * @throws InvalidSignException
     *
     * @return Collection
     */
    public function find($order, $type = 'wap', $transfer = false): Collection
    {
        if ($type === true || $transfer) {
            Log::warning('DEPRECATED: In Alipay->find(), the REFUND/TRANSFER param is deprecated since v2.7.3, use TYPE param instead!');
            @trigger_error('In yansongda/pay Alipay->find(), the REFUND/TRANSFER param is deprecated since v2.7.3, use TYPE param instead!', E_USER_DEPRECATED);

            $type = $type === true ? 'refund' : 'transfer';
        }

        if ($type === false) {
            Log::warning('DEPRECATED: In Alipay->find(), the REFUND/TRANSFER param is deprecated since v2.7.3, use TYPE param instead!');
            @trigger_error('In yansongda/pay Alipay->find(), the REFUND/TRANSFER param is deprecated since v2.7.3, use TYPE param instead!', E_USER_DEPRECATED);

            $type = 'wap';
        }

        $gateway = get_class($this).'\\'.Str::studly($type).'Gateway';

        if (!class_exists($gateway) || !is_callable([new $gateway(), 'find'])) {
            throw new GatewayException("{$gateway} Done Not Exist Or Done Not Has FIND Method");
        }

        $config = call_user_func([new $gateway(), 'find'], $order);

        $this->payload['method'] = $config['method'];
        $this->payload['biz_content'] = $config['biz_content'];
        $this->payload['sign'] = Support::generateSign($this->payload);

        Events::dispatch(Events::METHOD_CALLED, new Events\MethodCalled('Alipay', 'Find', $this->gateway, $this->payload));

        return Support::requestApi($this->payload);
    }

    /**
     * Refund an order.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param array $order
     *
     * @throws GatewayException
     * @throws InvalidConfigException
     * @throws InvalidSignException
     *
     * @return Collection
     */
    public function refund($order): Collection
    {
        $this->payload['method'] = 'alipay.trade.refund';
        $this->payload['biz_content'] = json_encode($order);
        $this->payload['sign'] = Support::generateSign($this->payload);

        Events::dispatch(Events::METHOD_CALLED, new Events\MethodCalled('Alipay', 'Refund', $this->gateway, $this->payload));

        return Support::requestApi($this->payload);
    }

    /**
     * Cancel an order.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param array $order
     *
     * @throws GatewayException
     * @throws InvalidConfigException
     * @throws InvalidSignException
     *
     * @return Collection
     */
    public function cancel($order): Collection
    {
        $this->payload['method'] = 'alipay.trade.cancel';
        $this->payload['biz_content'] = json_encode(is_array($order) ? $order : ['out_trade_no' => $order]);
        $this->payload['sign'] = Support::generateSign($this->payload);

        Events::dispatch(Events::METHOD_CALLED, new Events\MethodCalled('Alipay', 'Cancel', $this->gateway, $this->payload));

        return Support::requestApi($this->payload);
    }

    /**
     * Close an order.
     *
     * @param string|array $order
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @throws GatewayException
     * @throws InvalidConfigException
     * @throws InvalidSignException
     *
     * @return Collection
     */
    public function close($order): Collection
    {
        $this->payload['method'] = 'alipay.trade.close';
        $this->payload['biz_content'] = json_encode(is_array($order) ? $order : ['out_trade_no' => $order]);
        $this->payload['sign'] = Support::generateSign($this->payload);

        Events::dispatch(Events::METHOD_CALLED, new Events\MethodCalled('Alipay', 'Close', $this->gateway, $this->payload));

        return Support::requestApi($this->payload);
    }

    /**
     * Download bill.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string|array $bill
     *
     * @throws GatewayException
     * @throws InvalidConfigException
     * @throws InvalidSignException
     *
     * @return string
     */
    public function download($bill): string
    {
        $this->payload['method'] = 'alipay.data.dataservice.bill.downloadurl.query';
        $this->payload['biz_content'] = json_encode(is_array($bill) ? $bill : ['bill_type' => 'trade', 'bill_date' => $bill]);
        $this->payload['sign'] = Support::generateSign($this->payload);

        Events::dispatch(Events::METHOD_CALLED, new Events\MethodCalled('Alipay', 'Download', $this->gateway, $this->payload));

        $result = Support::requestApi($this->payload);

        return ($result instanceof Collection) ? $result->get('bill_download_url') : '';
    }

    /**
     * Reply success to alipay.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @return Response
     */
    public function success(): Response
    {
        Events::dispatch(Events::METHOD_CALLED, new Events\MethodCalled('Alipay', 'Success', $this->gateway));

        return Response::create('success');
    }

    /**
     * extend.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string   $method
     * @param callable $function
     *
     * @return void
     */
    public function extend(string $method, callable $function)
    {
    }

    /**
     * Make pay gateway.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $gateway
     *
     * @throws InvalidGatewayException
     *
     * @return Response|Collection
     */
    protected function makePay($gateway)
    {
        $app = new $gateway();

        if ($app instanceof GatewayInterface) {
            return $app->pay($this->gateway, array_filter($this->payload, function ($value) {
                return $value !== '' && !is_null($value);
            }));
        }

        throw new InvalidGatewayException("Pay Gateway [{$gateway}] Must Be An Instance Of GatewayInterface");
    }
}
