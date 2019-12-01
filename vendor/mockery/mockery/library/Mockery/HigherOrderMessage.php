<?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/blob/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

namespace Mockery;

/**
 * @method \Mockery\Expectation withArgs(\Closure|array $args)
 */
class HigherOrderMessage
{
    private $mock;
    private $method;

    public function __construct(MockInterface $mock, $method)
    {
        $this->mock = $mock;
        $this->method = $method;
    }

    /**
     * @return \Mockery\Expectation
     */
    public function __call($method, $args)
    {
        if ($this->method === 'shouldNotHaveReceived') {
            return $this->mock->{$this->method}($method, $args);
        }

        $expectation = $this->mock->{$this->method}($method);
        return $expectation->withArgs($args);
    }
}
