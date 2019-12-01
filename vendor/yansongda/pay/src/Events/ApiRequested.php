<?php

namespace Yansongda\Pay\Events;

class ApiRequested extends Event
{
    /**
     * Endpoint.
     *
     * @var string
     */
    public $endpoint;

    /**
     * Result.
     *
     * @var array
     */
    public $result;

    /**
     * Bootstrap.
     *
     * @param string $driver
     * @param string $gateway
     * @param string $endpoint
     * @param array  $result
     */
    public function __construct(string $driver, string $gateway, string $endpoint, array $result)
    {
        $this->endpoint = $endpoint;
        $this->result = $result;

        parent::__construct($driver, $gateway);
    }
}
