<?php

namespace Yansongda\Pay\Gateways;

use Exception;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Yansongda\Pay\Contracts\GatewayApplicationInterface;
use Yansongda\Pay\Contracts\GatewayInterface;
use Yansongda\Pay\Events;
use Yansongda\Pay\Exceptions\GatewayException;
use Yansongda\Pay\Exceptions\InvalidArgumentException;
use Yansongda\Pay\Exceptions\InvalidGatewayException;
use Yansongda\Pay\Exceptions\InvalidSignException;
use Yansongda\Pay\Gateways\Wechat\Support;
use Yansongda\Pay\Log;
use Yansongda\Supports\Collection;
use Yansongda\Supports\Config;
use Yansongda\Supports\Str;

/**
 * @method Response app(array $config) APP 支付
 * @method Collection groupRedpack(array $config) 分裂红包
 * @method Collection miniapp(array $config) 小程序支付
 * @method Collection mp(array $config) 公众号支付
 * @method Collection pos(array $config) 刷卡支付
 * @method Collection redpack(array $config) 普通红包
 * @method Collection scan(array $config) 扫码支付
 * @method Collection transfer(array $config) 企业付款
 * @method RedirectResponse wap(array $config) H5 支付
 */
class Wechat implements GatewayApplicationInterface
{
    /**
     * 普通模式.
     */
    const MODE_NORMAL = 'normal';

    /**
     * 沙箱模式.
     */
    const MODE_DEV = 'dev';

    /**
     * 香港钱包 API.
     */
    const MODE_HK = 'hk';

    /**
     * 境外 API.
     */
    const MODE_US = 'us';

    /**
     * 服务商模式.
     */
    const MODE_SERVICE = 'service';

    /**
     * Const url.
     */
    const URL = [
        self::MODE_NORMAL  => 'https://api.mch.weixin.qq.com/',
        self::MODE_DEV     => 'https://api.mch.weixin.qq.com/sandboxnew/',
        self::MODE_HK      => 'https://apihk.mch.weixin.qq.com/',
        self::MODE_SERVICE => 'https://api.mch.weixin.qq.com/',
        self::MODE_US      => 'https://apius.mch.weixin.qq.com/',
    ];

    /**
     * Wechat payload.
     *
     * @var array
     */
    protected $payload;

    /**
     * Wechat gateway.
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
     *
     * @throws Exception
     */
    public function __construct(Config $config)
    {
        $this->gateway = Support::create($config)->getBaseUri();
        $this->payload = [
            'appid'            => $config->get('app_id', ''),
            'mch_id'           => $config->get('mch_id', ''),
            'nonce_str'        => Str::random(),
            'notify_url'       => $config->get('notify_url', ''),
            'sign'             => '',
            'trade_type'       => '',
            'spbill_create_ip' => Request::createFromGlobals()->getClientIp(),
        ];

        if ($config->get('mode', self::MODE_NORMAL) === static::MODE_SERVICE) {
            $this->payload = array_merge($this->payload, [
                'sub_mch_id' => $config->get('sub_mch_id'),
                'sub_appid'  => $config->get('sub_app_id', ''),
            ]);
        }
    }

    /**
     * Magic pay.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $method
     * @param string $params
     *
     * @throws InvalidGatewayException
     *
     * @return Response|Collection
     */
    public function __call($method, $params)
    {
        return self::pay($method, ...$params);
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
        Events::dispatch(Events::PAY_STARTING, new Events\PayStarting('Wechat', $gateway, $params));

        $this->payload = array_merge($this->payload, $params);

        $gateway = get_class($this).'\\'.Str::studly($gateway).'Gateway';

        if (class_exists($gateway)) {
            return $this->makePay($gateway);
        }

        throw new InvalidGatewayException("Pay Gateway [{$gateway}] Not Exists");
    }

    /**
     * Verify data.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string|null $content
     * @param bool        $refund
     *
     * @throws InvalidSignException
     * @throws InvalidArgumentException
     *
     * @return Collection
     */
    public function verify($content = null, $refund = false): Collection
    {
        $content = $content ?? Request::createFromGlobals()->getContent();

        Events::dispatch(Events::REQUEST_RECEIVED, new Events\RequestReceived('Wechat', '', [$content]));

        $data = Support::fromXml($content);
        if ($refund) {
            $decrypt_data = Support::decryptRefundContents($data['req_info']);
            $data = array_merge(Support::fromXml($decrypt_data), $data);
        }

        Log::debug('Resolved The Received Wechat Request Data', $data);

        if ($refund || Support::generateSign($data) === $data['sign']) {
            return new Collection($data);
        }

        Events::dispatch(Events::SIGN_FAILED, new Events\SignFailed('Wechat', '', $data));

        throw new InvalidSignException('Wechat Sign Verify FAILED', $data);
    }

    /**
     * Query an order.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string|array $order
     * @param string       $type
     *
     * @throws GatewayException
     * @throws InvalidSignException
     * @throws InvalidArgumentException
     *
     * @return Collection
     */
    public function find($order, $type = 'wap'): Collection
    {
        if ($type === true) {
            Log::warning('DEPRECATED: In Wechat->find(), the REFUND param is deprecated since v2.7.8, use TYPE param instead!');
            @trigger_error('In yansongda/pay Wechat->find(), the REFUND param is deprecated since v2.7.8, use TYPE param instead!', E_USER_DEPRECATED);

            $type = 'refund';
        }

        if ($type === false) {
            Log::warning('DEPRECATED: In Wechat->find(), the REFUND param is deprecated since v2.7.8, use TYPE param instead!');
            @trigger_error('In yansongda/pay Wechat->find(), the REFUND param is deprecated since v2.7.8, use TYPE param instead!', E_USER_DEPRECATED);

            $type = 'wap';
        }

        if ($type != 'wap') {
            unset($this->payload['spbill_create_ip']);
        }

        $gateway = get_class($this).'\\'.Str::studly($type).'Gateway';

        if (!class_exists($gateway) || !is_callable([new $gateway(), 'find'])) {
            throw new GatewayException("{$gateway} Done Not Exist Or Done Not Has FIND Method");
        }

        $config = call_user_func([new $gateway(), 'find'], $order);

        $this->payload = Support::filterPayload($this->payload, $config['order']);

        Events::dispatch(Events::METHOD_CALLED, new Events\MethodCalled('Wechat', 'Find', $this->gateway, $this->payload));

        return Support::requestApi(
            $config['endpoint'],
            $this->payload,
            $config['cert']
        );
    }

    /**
     * Refund an order.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param array $order
     *
     * @throws GatewayException
     * @throws InvalidSignException
     * @throws InvalidArgumentException
     *
     * @return Collection
     */
    public function refund($order): Collection
    {
        $this->payload = Support::filterPayload($this->payload, $order, true);

        Events::dispatch(Events::METHOD_CALLED, new Events\MethodCalled('Wechat', 'Refund', $this->gateway, $this->payload));

        return Support::requestApi(
            'secapi/pay/refund',
            $this->payload,
            true
        );
    }

    /**
     * Cancel an order.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param array $order
     *
     * @throws GatewayException
     * @throws InvalidSignException
     * @throws InvalidArgumentException
     *
     * @return Collection
     */
    public function cancel($order): Collection
    {
        unset($this->payload['spbill_create_ip']);

        $this->payload = Support::filterPayload($this->payload, $order, true);

        Events::dispatch(Events::METHOD_CALLED, new Events\MethodCalled('Wechat', 'Cancel', $this->gateway, $this->payload));

        return Support::requestApi(
            'secapi/pay/reverse',
            $this->payload,
            true
        );
    }

    /**
     * Close an order.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string|array $order
     *
     * @throws GatewayException
     * @throws InvalidSignException
     * @throws InvalidArgumentException
     *
     * @return Collection
     */
    public function close($order): Collection
    {
        unset($this->payload['spbill_create_ip']);

        $this->payload = Support::filterPayload($this->payload, $order);

        Events::dispatch(Events::METHOD_CALLED, new Events\MethodCalled('Wechat', 'Close', $this->gateway, $this->payload));

        return Support::requestApi('pay/closeorder', $this->payload);
    }

    /**
     * Echo success to server.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @throws InvalidArgumentException
     *
     * @return Response
     */
    public function success(): Response
    {
        Events::dispatch(Events::METHOD_CALLED, new Events\MethodCalled('Wechat', 'Success', $this->gateway));

        return Response::create(
            Support::toXml(['return_code' => 'SUCCESS', 'return_msg' => 'OK']),
            200,
            ['Content-Type' => 'application/xml']
        );
    }

    /**
     * Download the bill.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param array $params
     *
     * @throws GatewayException
     * @throws InvalidArgumentException
     *
     * @return string
     */
    public function download(array $params): string
    {
        unset($this->payload['spbill_create_ip']);

        $this->payload = Support::filterPayload($this->payload, $params, true);

        Events::dispatch(Events::METHOD_CALLED, new Events\MethodCalled('Wechat', 'Download', $this->gateway, $this->payload));

        $result = Support::getInstance()->post(
            'pay/downloadbill',
            Support::getInstance()->toXml($this->payload)
        );

        if (is_array($result)) {
            throw new GatewayException('Get Wechat API Error: '.$result['return_msg'], $result);
        }

        return $result;
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
