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

namespace Mockery\Generator;

use PHPUnit\Framework\TestCase;

class MockConfigurationTest extends TestCase
{
    /**
     * @test
     */
    public function blackListedMethodsShouldNotBeInListToBeMocked()
    {
        $config = new MockConfiguration(array("Mockery\Generator\\TestSubject"), array("foo"));

        $methods = $config->getMethodsToMock();
        $this->assertCount(1, $methods);
        $this->assertEquals("bar", $methods[0]->getName());
    }

    /**
     * @test
     */
    public function blackListsAreCaseInsensitive()
    {
        $config = new MockConfiguration(array("Mockery\Generator\\TestSubject"), array("FOO"));

        $methods = $config->getMethodsToMock();
        $this->assertCount(1, $methods);
        $this->assertEquals("bar", $methods[0]->getName());
    }


    /**
     * @test
     */
    public function onlyWhiteListedMethodsShouldBeInListToBeMocked()
    {
        $config = new MockConfiguration(array("Mockery\Generator\\TestSubject"), array(), array('foo'));

        $methods = $config->getMethodsToMock();
        $this->assertCount(1, $methods);
        $this->assertEquals("foo", $methods[0]->getName());
    }

    /**
     * @test
     */
    public function whitelistOverRulesBlackList()
    {
        $config = new MockConfiguration(array("Mockery\Generator\\TestSubject"), array("foo"), array("foo"));

        $methods = $config->getMethodsToMock();
        $this->assertCount(1, $methods);
        $this->assertEquals("foo", $methods[0]->getName());
    }

    /**
     * @test
     */
    public function whiteListsAreCaseInsensitive()
    {
        $config = new MockConfiguration(array("Mockery\Generator\\TestSubject"), array(), array("FOO"));

        $methods = $config->getMethodsToMock();
        $this->assertCount(1, $methods);
        $this->assertEquals("foo", $methods[0]->getName());
    }

    /**
     * @test
     */
    public function finalMethodsAreExcluded()
    {
        $config = new MockConfiguration(array("Mockery\Generator\\ClassWithFinalMethod"));

        $methods = $config->getMethodsToMock();
        $this->assertCount(1, $methods);
        $this->assertEquals("bar", $methods[0]->getName());
    }

    /**
     * @test
     */
    public function shouldIncludeMethodsFromAllTargets()
    {
        $config = new MockConfiguration(array("Mockery\\Generator\\TestInterface", "Mockery\\Generator\\TestInterface2"));
        $methods = $config->getMethodsToMock();
        $this->assertCount(2, $methods);
    }

    /**
     * @test
     */
    public function shouldThrowIfTargetClassIsFinal()
    {
        $this->expectException(\Mockery\Exception::class);
        $config = new MockConfiguration(array("Mockery\\Generator\\TestFinal"));
        $config->getTargetClass();
    }

    /**
     * @test
     */
    public function shouldTargetIteratorAggregateIfTryingToMockTraversable()
    {
        $config = new MockConfiguration(array("\\Traversable"));

        $interfaces = $config->getTargetInterfaces();
        $this->assertCount(1, $interfaces);
        $first = array_shift($interfaces);
        $this->assertEquals("IteratorAggregate", $first->getName());
    }

    /**
     * @test
     */
    public function shouldTargetIteratorAggregateIfTraversableInTargetsTree()
    {
        $config = new MockConfiguration(array("Mockery\Generator\TestTraversableInterface"));

        $interfaces = $config->getTargetInterfaces();
        $this->assertCount(2, $interfaces);
        $this->assertEquals("IteratorAggregate", $interfaces[0]->getName());
        $this->assertEquals("Mockery\Generator\TestTraversableInterface", $interfaces[1]->getName());
    }

    /**
     * @test
     */
    public function shouldBringIteratorToHeadOfTargetListIfTraversablePresent()
    {
        $config = new MockConfiguration(array("Mockery\Generator\TestTraversableInterface2"));

        $interfaces = $config->getTargetInterfaces();
        $this->assertCount(2, $interfaces);
        $this->assertEquals("Iterator", $interfaces[0]->getName());
        $this->assertEquals("Mockery\Generator\TestTraversableInterface2", $interfaces[1]->getName());
    }

    /**
     * @test
     */
    public function shouldBringIteratorAggregateToHeadOfTargetListIfTraversablePresent()
    {
        $config = new MockConfiguration(array("Mockery\Generator\TestTraversableInterface3"));

        $interfaces = $config->getTargetInterfaces();
        $this->assertCount(2, $interfaces);
        $this->assertEquals("IteratorAggregate", $interfaces[0]->getName());
        $this->assertEquals("Mockery\Generator\TestTraversableInterface3", $interfaces[1]->getName());
    }
}

interface TestTraversableInterface extends \Traversable
{
}
interface TestTraversableInterface2 extends \Traversable, \Iterator
{
}
interface TestTraversableInterface3 extends \Traversable, \IteratorAggregate
{
}

final class TestFinal
{
}

interface TestInterface
{
    public function foo();
}

interface TestInterface2
{
    public function bar();
}

class TestSubject
{
    public function foo()
    {
    }

    public function bar()
    {
    }
}

class ClassWithFinalMethod
{
    final public function foo()
    {
    }

    public function bar()
    {
    }
}
