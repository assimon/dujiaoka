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

namespace Mockery\Exception;

use Mockery;
use Mockery\Exception\RuntimeException;

class InvalidCountException extends Mockery\CountValidator\Exception
{
    protected $method = null;

    protected $expected = 0;

    protected $expectedComparative = '<=';

    protected $actual = null;

    protected $mockObject = null;

    public function setMock(Mockery\LegacyMockInterface $mock)
    {
        $this->mockObject = $mock;
        return $this;
    }

    public function setMethodName($name)
    {
        $this->method = $name;
        return $this;
    }

    public function setActualCount($count)
    {
        $this->actual = $count;
        return $this;
    }

    public function setExpectedCount($count)
    {
        $this->expected = $count;
        return $this;
    }

    public function setExpectedCountComparative($comp)
    {
        if (!in_array($comp, array('=', '>', '<', '>=', '<='))) {
            throw new RuntimeException(
                'Illegal comparative for expected call counts set: ' . $comp
            );
        }
        $this->expectedComparative = $comp;
        return $this;
    }

    public function getMock()
    {
        return $this->mockObject;
    }

    public function getMethodName()
    {
        return $this->method;
    }

    public function getActualCount()
    {
        return $this->actual;
    }

    public function getExpectedCount()
    {
        return $this->expected;
    }

    public function getMockName()
    {
        return $this->getMock()->mockery_getName();
    }

    public function getExpectedCountComparative()
    {
        return $this->expectedComparative;
    }
}
