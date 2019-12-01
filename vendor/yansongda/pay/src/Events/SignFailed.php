<?php

namespace Yansongda\Pay\Events;

class SignFailed extends Event
{
    /**
     * Received data.
     *
     * @var array
     */
    public $data;

    /**
     * Bootstrap.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $driver
     * @param string $gateway
     * @param array  $data
     */
    public function __construct(string $driver, string $gateway, array $data)
    {
        $this->data = $data;

        parent::__construct($driver, $gateway);
    }
}
