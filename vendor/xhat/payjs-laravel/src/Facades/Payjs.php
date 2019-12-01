<?php

namespace Xhat\Payjs\Facades;

use Illuminate\Support\Facades\Facade;

class Payjs extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'payjs';
    }
}
