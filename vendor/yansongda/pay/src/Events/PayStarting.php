<?php

namespace Yansongda\Pay\Events;

class PayStarting extends Event
{
    /**
     * Params.
     *
     * @var array
     */
    public $params;

    /**
     * Bootstrap.
     *
     * @param string $driver
     * @param string $gateway
     * @param array  $params
     */
    public function __construct(string $driver, string $gateway, array $params)
    {
        $this->params = $params;

        parent::__construct($driver, $gateway);
    }
}
