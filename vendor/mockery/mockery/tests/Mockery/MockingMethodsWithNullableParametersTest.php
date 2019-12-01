<?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

namespace test\Mockery;

use Mockery\Adapter\Phpunit\MockeryTestCase;

/**
 */
class MockingMethodsWithNullableParametersTest extends MockeryTestCase
{
    /**
     * @test
     * @requires PHP 7.1.0RC3
     */
    public function it_can_handle_nullable_typed_parameters()
    {
        require __DIR__."/Fixtures/MethodWithNullableTypedParameter.php";
        $mock = mock("test\Mockery\Fixtures\MethodWithNullableTypedParameter");

        $this->assertInstanceOf(\test\Mockery\Fixtures\MethodWithNullableTypedParameter::class, $mock);
    }

    /**
     * @test
     */
    public function it_can_handle_default_parameters()
    {
        require __DIR__."/Fixtures/MethodWithParametersWithDefaultValues.php";
        $mock = mock("test\Mockery\Fixtures\MethodWithParametersWithDefaultValues");

        $this->assertInstanceOf(\test\Mockery\Fixtures\MethodWithParametersWithDefaultValues::class, $mock);
    }
}
