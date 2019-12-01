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
use Mockery\Generator\Method;
use test\Mockery\Fixtures\MethodWithHHVMReturnType;

class MockingHHVMMethodsTest extends MockeryTestCase
{
    /**
     * @var \Mockery\Container
     */
    private $container;

    protected function mockeryTestSetUp()
    {
        if (!$this->isHHVM()) {
            $this->markTestSkipped('For HHVM test only');
        }

        parent::mockeryTestSetUp();

        require_once __DIR__."/Fixtures/MethodWithHHVMReturnType.php";
    }

    /** @test */
    public function it_strip_hhvm_array_return_types()
    {
        $mock = mock('test\Mockery\Fixtures\MethodWithHHVMReturnType');

        $mock->shouldReceive('nullableHHVMArray')->andReturn(array('key' => true));
        $mock->nullableHHVMArray();
    }

    /** @test */
    public function it_strip_hhvm_void_return_types()
    {
        $mock = mock('test\Mockery\Fixtures\MethodWithHHVMReturnType');

        $mock->shouldReceive('HHVMVoid')->andReturnNull();
        $mock->HHVMVoid();
    }

    /** @test */
    public function it_strip_hhvm_mixed_return_types()
    {
        $mock = mock('test\Mockery\Fixtures\MethodWithHHVMReturnType');

        $mock->shouldReceive('HHVMMixed')->andReturnNull();
        $mock->HHVMMixed();
    }

    /** @test */
    public function it_strip_hhvm_this_return_types()
    {
        $mock = mock('test\Mockery\Fixtures\MethodWithHHVMReturnType');

        $mock->shouldReceive('HHVMThis')->andReturn(new MethodWithHHVMReturnType());
        $mock->HHVMThis();
    }

    /** @test */
    public function it_allow_hhvm_string_return_types()
    {
        $mock = mock('test\Mockery\Fixtures\MethodWithHHVMReturnType');

        $mock->shouldReceive('HHVMString')->andReturn('a string');
        $mock->HHVMString();
    }

    /** @test */
    public function it_allow_hhvm_imm_vector_return_types()
    {
        $mock = mock('test\Mockery\Fixtures\MethodWithHHVMReturnType');

        $mock->shouldReceive('HHVMImmVector')->andReturn(new \HH\ImmVector([1, 2, 3]));
        $mock->HHVMImmVector();
    }

    /**
     * Returns true when it is HHVM.
     */
    private function isHHVM()
    {
        return \defined('HHVM_VERSION');
    }
}
