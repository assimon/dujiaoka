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

require_once __DIR__.'/DummyClasses/Namespaced.php';

use Mockery\Adapter\Phpunit\MockeryTestCase;
use test\Mockery\Stubs\Animal;
use test\Mockery\Stubs\Habitat;

class NamedMockTest extends MockeryTestCase
{
    /** @test */
    public function itCreatesANamedMock()
    {
        $mock = Mockery::namedMock("Mockery\Dave123");
        $this->assertInstanceOf("Mockery\Dave123", $mock);
    }

    /** @test */
    public function itCreatesPassesFurtherArgumentsJustLikeMock()
    {
        $mock = Mockery::namedMock("Mockery\Dave456", "DateTime", array(
            "getDave" => "dave"
        ));

        $this->assertInstanceOf("DateTime", $mock);
        $this->assertEquals("dave", $mock->getDave());
    }

    /**
     * @test
     */
    public function itShouldThrowIfAttemptingToRedefineNamedMock()
    {
        $mock = Mockery::namedMock("Mockery\Dave7");
        $this->expectException(\Mockery\Exception::class);
        $this->expectExceptionMessage("The mock named 'Mockery\Dave7' has been already defined with a different mock configuration");
        $mock = Mockery::namedMock("Mockery\Dave7", "DateTime");
    }

    /** @test */
    public function itCreatesConcreteMethodImplementationWithReturnType()
    {
        $cactus = new \Nature\Plant();
        $gardener = Mockery::namedMock(
            "NewNamespace\\ClassName",
            "Gardener",
            array('water' => true)
        );
        $this->assertTrue($gardener->water($cactus));
    }

    /**
     * @test
     * @requires PHP 7.0.0
     */
    public function it_gracefully_handles_namespacing()
    {
        $animal = Mockery::namedMock(
            uniqid(Animal::class, false),
            Animal::class
        );

        $animal->shouldReceive("habitat")->andReturn(new Habitat());

        $this->assertInstanceOf(Habitat::class, $animal->habitat());
    }
}
