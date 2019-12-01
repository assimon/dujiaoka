<?php

namespace Yansongda\Pay\Gateways\Wechat;

class RefundGateway extends Gateway
{
    /**
     * Find.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param $order
     *
     * @return array
     */
    public function find($order): array
    {
        return [
            'endpoint' => 'pay/refundquery',
            'order'    => is_array($order) ? $order : ['out_trade_no' => $order],
            'cert'     => false,
        ];
    }
}
