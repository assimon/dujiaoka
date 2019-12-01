<?php

namespace Yansongda\Pay\Contracts;

use Symfony\Component\HttpFoundation\Response;
use Yansongda\Supports\Collection;

interface GatewayInterface
{
    /**
     * Pay an order.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $endpoint
     * @param array  $payload
     *
     * @return Collection|Response
     */
    public function pay($endpoint, array $payload);
}
