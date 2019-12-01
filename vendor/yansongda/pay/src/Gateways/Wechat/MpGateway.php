<?php

namespace Yansongda\Pay\Gateways\Wechat;

use Exception;
use Yansongda\Pay\Events;
use Yansongda\Pay\Exceptions\GatewayException;
use Yansongda\Pay\Exceptions\InvalidArgumentException;
use Yansongda\Pay\Exceptions\InvalidSignException;
use Yansongda\Supports\Collection;
use Yansongda\Supports\Str;

class MpGateway extends Gateway
{
    /**
     * @var bool
     */
    protected $payRequestUseSubAppId = false;

    /**
     * Pay an order.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $endpoint
     * @param array  $payload
     *
     * @throws GatewayException
     * @throws InvalidArgumentException
     * @throws InvalidSignException
     * @throws Exception
     *
     * @return Collection
     */
    public function pay($endpoint, array $payload): Collection
    {
        $payload['trade_type'] = $this->getTradeType();

        $pay_request = [
            'appId'     => !$this->payRequestUseSubAppId ? $payload['appid'] : $payload['sub_appid'],
            'timeStamp' => strval(time()),
            'nonceStr'  => Str::random(),
            'package'   => 'prepay_id='.$this->preOrder($payload)->get('prepay_id'),
            'signType'  => 'MD5',
        ];
        $pay_request['paySign'] = Support::generateSign($pay_request);

        Events::dispatch(Events::PAY_STARTED, new Events\PayStarted('Wechat', 'JSAPI', $endpoint, $pay_request));

        return new Collection($pay_request);
    }

    /**
     * Get trade type config.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @return string
     */
    protected function getTradeType(): string
    {
        return 'JSAPI';
    }
}
