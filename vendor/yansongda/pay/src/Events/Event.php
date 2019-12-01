<?php

namespace Yansongda\Pay\Events;

class Event extends \Symfony\Component\EventDispatcher\Event
{
    /**
     * Driver.
     *
     * @var string
     */
    public $driver;

    /**
     * Method.
     *
     * @var string
     */
    public $gateway;

    /**
     * Extra attributes.
     *
     * @var mixed
     */
    public $attributes;

    /**
     * Bootstrap.
     *
     * @author yansongda <me@yansongda.cn>
     *
     * @param string $driver
     * @param string $gateway
     */
    public function __construct(string $driver, string $gateway)
    {
        $this->driver = $driver;
        $this->gateway = $gateway;
    }
}
