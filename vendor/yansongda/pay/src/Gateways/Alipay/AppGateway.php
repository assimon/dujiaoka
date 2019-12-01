<?php

namespace Yansongda\Pay\Gateways\Alipay;

use Symfony\Component\HttpFoundation\Response;
use Yansongda\Pay\Contracts\GatewayInterface;
use Yansongda\Pay\Events;
use Yansongda\Pay\Exceptions\InvalidConfigException;

class AppGateway implements GatewayInterface
{
    /**
     * Pay an order.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $endpoint
     * @param array  $payload
     *
     * @throws InvalidConfigException
     *
     * @return Response
     */
    public function pay($endpoint, array $payload): Response
    {
        $payload['method'] = 'alipay.trade.app.pay';
        $payload['biz_content'] = json_encode(array_merge(
            json_decode($payload['biz_content'], true),
            ['product_code' => 'QUICK_MSECURITY_PAY']
        ));
        $payload['sign'] = Support::generateSign($payload);

        Events::dispatch(Events::PAY_STARTED, new Events\PayStarted('Alipay', 'App', $endpoint, $payload));

        return Response::create(http_build_query($payload));
    }
}
