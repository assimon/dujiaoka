<?php

namespace Yansongda\Pay\Gateways\Alipay;

use Yansongda\Pay\Contracts\GatewayInterface;
use Yansongda\Pay\Events;
use Yansongda\Pay\Exceptions\GatewayException;
use Yansongda\Pay\Exceptions\InvalidArgumentException;
use Yansongda\Pay\Exceptions\InvalidConfigException;
use Yansongda\Pay\Exceptions\InvalidSignException;
use Yansongda\Supports\Collection;

class MiniGateway implements GatewayInterface
{
    /**
     * Pay an order.
     *
     * @author xiaozan <i@xiaozan.me>
     *
     * @param string $endpoint
     * @param array  $payload
     *
     * @throws GatewayException
     * @throws InvalidArgumentException
     * @throws InvalidConfigException
     * @throws InvalidSignException
     *
     * @link https://docs.alipay.com/mini/introduce/pay
     *
     * @return Collection
     */
    public function pay($endpoint, array $payload): Collection
    {
        if (empty(json_decode($payload['biz_content'], true)['buyer_id'])) {
            throw new InvalidArgumentException('buyer_id required');
        }

        $payload['method'] = 'alipay.trade.create';
        $payload['sign'] = Support::generateSign($payload);

        Events::dispatch(Events::PAY_STARTED, new Events\PayStarted('Alipay', 'Mini', $endpoint, $payload));

        return Support::requestApi($payload);
    }
}
