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

namespace tests\Mockery\Generator;

use Mockery as m;
use Mockery\Generator\MockConfigurationBuilder;
use PHPUnit\Framework\TestCase;

class MockConfigurationBuilderTest extends TestCase
{
    /**
     * @test
     */
    public function reservedWordsAreBlackListedByDefault()
    {
        $builder = new MockConfigurationBuilder;
        $this->assertContains('__halt_compiler', $builder->getMockConfiguration()->getBlackListedMethods());

        // need a builtin for this
        $this->markTestSkipped("Need a builtin class with a method that is a reserved word");
    }

    /**
     * @test
     */
    public function magicMethodsAreBlackListedByDefault()
    {
        $builder = new MockConfigurationBuilder;
        $builder->addTarget(ClassWithMagicCall::class);
        $methods = $builder->getMockConfiguration()->getMethodsToMock();
        $this->assertCount(1, $methods);
        $this->assertEquals("foo", $methods[0]->getName());
    }

    /** @test */
    public function xdebugs_debug_info_is_black_listed_by_default()
    {
        $builder = new MockConfigurationBuilder;
        $builder->addTarget(ClassWithDebugInfo::class);
        $methods = $builder->getMockConfiguration()->getMethodsToMock();
        $this->assertCount(1, $methods);
        $this->assertEquals("foo", $methods[0]->getName());
    }
}

class ClassWithMagicCall
{
    public function foo()
    {
    }

    public function __call($method, $args)
    {
    }
}

class ClassWithDebugInfo
{
    public function foo()
    {
    }

    public function __debugInfo()
    {
    }
}
