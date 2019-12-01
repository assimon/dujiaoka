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

use Mockery\Generator\MockConfigurationBuilder;
use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Mockery\Exception\BadMethodCallException;

class ContainerTest extends MockeryTestCase
{
    public function testSimplestMockCreation()
    {
        $m = mock();
        $m->shouldReceive('foo')->andReturn('bar');
        $this->assertEquals('bar', $m->foo());
    }

    public function testGetKeyOfDemeterMockShouldReturnKeyWhenMatchingMock()
    {
        $m = mock();
        $m->shouldReceive('foo->bar');
        $this->assertRegExp(
            '/Mockery_(\d+)__demeter_([0-9a-f]+)_foo/',
            Mockery::getContainer()->getKeyOfDemeterMockFor('foo', get_class($m))
        );
    }
    public function testGetKeyOfDemeterMockShouldReturnNullWhenNoMatchingMock()
    {
        $method = 'unknownMethod';
        $this->assertNull(Mockery::getContainer()->getKeyOfDemeterMockFor($method, 'any'));

        $m = mock();
        $m->shouldReceive('method');
        $this->assertNull(Mockery::getContainer()->getKeyOfDemeterMockFor($method, get_class($m)));

        $m->shouldReceive('foo->bar');
        $this->assertNull(Mockery::getContainer()->getKeyOfDemeterMockFor($method, get_class($m)));
    }


    public function testNamedMocksAddNameToExceptions()
    {
        $m = mock('Foo');
        $m->shouldReceive('foo')->with(1)->andReturn('bar');
        try {
            $m->foo();
        } catch (\Mockery\Exception $e) {
            $this->assertTrue((bool) preg_match("/Foo/", $e->getMessage()));
        }
    }

    public function testSimpleMockWithArrayDefs()
    {
        $m = mock(array('foo'=>1, 'bar'=>2));
        $this->assertEquals(1, $m->foo());
        $this->assertEquals(2, $m->bar());
    }

    public function testSimpleMockWithArrayDefsCanBeOverridden()
    {
        // eg. In shared test setup
        $m = mock(array('foo' => 1, 'bar' => 2));

        // and then overridden in one test
        $m->shouldReceive('foo')->with('baz')->once()->andReturn(2);
        $m->shouldReceive('bar')->with('baz')->once()->andReturn(42);

        $this->assertEquals(2, $m->foo('baz'));
        $this->assertEquals(42, $m->bar('baz'));
    }

    public function testNamedMockWithArrayDefs()
    {
        $m = mock('Foo', array('foo'=>1, 'bar'=>2));
        $this->assertEquals(1, $m->foo());
        $this->assertEquals(2, $m->bar());
        try {
            $m->f();
        } catch (BadMethodCallException $e) {
            $this->assertTrue((bool) preg_match("/Foo/", $e->getMessage()));
        }
    }

    public function testNamedMockWithArrayDefsCanBeOverridden()
    {
        // eg. In shared test setup
        $m = mock('Foo', array('foo' => 1));

        // and then overridden in one test
        $m->shouldReceive('foo')->with('bar')->once()->andReturn(2);

        $this->assertEquals(2, $m->foo('bar'));

        try {
            $m->f();
        } catch (BadMethodCallException $e) {
            $this->assertTrue((bool) preg_match("/Foo/", $e->getMessage()));
        }
    }

    public function testNamedMockMultipleInterfaces()
    {
        $m = mock('stdClass, ArrayAccess, Countable', array('foo'=>1, 'bar'=>2));
        $this->assertEquals(1, $m->foo());
        $this->assertEquals(2, $m->bar());
        try {
            $m->f();
        } catch (BadMethodCallException $e) {
            $this->assertTrue((bool) preg_match("/stdClass/", $e->getMessage()));
            $this->assertTrue((bool) preg_match("/ArrayAccess/", $e->getMessage()));
            $this->assertTrue((bool) preg_match("/Countable/", $e->getMessage()));
        }
    }

    public function testNamedMockWithConstructorArgs()
    {
        $m = mock("MockeryTest_ClassConstructor2[foo]", array($param1 = new stdClass()));
        $m->shouldReceive("foo")->andReturn(123);
        $this->assertEquals(123, $m->foo());
        $this->assertEquals($param1, $m->getParam1());
    }

    public function testNamedMockWithConstructorArgsAndArrayDefs()
    {
        $m = mock(
            "MockeryTest_ClassConstructor2[foo]",
            array($param1 = new stdClass()),
            array("foo" => 123)
        );
        $this->assertEquals(123, $m->foo());
        $this->assertEquals($param1, $m->getParam1());
    }

    public function testNamedMockWithConstructorArgsWithInternalCallToMockedMethod()
    {
        $m = mock("MockeryTest_ClassConstructor2[foo]", array($param1 = new stdClass()));
        $m->shouldReceive("foo")->andReturn(123);
        $this->assertEquals(123, $m->bar());
    }

    public function testNamedMockWithConstructorArgsButNoQuickDefsShouldLeaveConstructorIntact()
    {
        $m = mock("MockeryTest_ClassConstructor2", array($param1 = new stdClass()));
        $m->makePartial();
        $this->assertEquals($param1, $m->getParam1());
    }

    public function testNamedMockWithMakePartial()
    {
        $m = mock("MockeryTest_ClassConstructor2", array($param1 = new stdClass()));
        $m->makePartial();
        $this->assertEquals('foo', $m->bar());
        $m->shouldReceive("bar")->andReturn(123);
        $this->assertEquals(123, $m->bar());
    }

    public function testNamedMockWithMakePartialThrowsIfNotAvailable()
    {
        $m = mock("MockeryTest_ClassConstructor2", array($param1 = new stdClass()));
        $m->makePartial();
        $this->expectException(\BadMethodCallException::class);
        $m->foorbar123();
        $m->mockery_verify();
    }

    public function testMockingAKnownConcreteClassSoMockInheritsClassType()
    {
        $m = mock('stdClass');
        $m->shouldReceive('foo')->andReturn('bar');
        $this->assertEquals('bar', $m->foo());
        $this->assertInstanceOf(stdClass::class, $m);
    }

    public function testMockingAKnownUserClassSoMockInheritsClassType()
    {
        $m = mock('MockeryTest_TestInheritedType');
        $this->assertInstanceOf(MockeryTest_TestInheritedType::class, $m);
    }

    public function testMockingAConcreteObjectCreatesAPartialWithoutError()
    {
        $m = mock(new stdClass);
        $m->shouldReceive('foo')->andReturn('bar');
        $this->assertEquals('bar', $m->foo());
        $this->assertInstanceOf(stdClass::class, $m);
    }

    public function testCreatingAPartialAllowsDynamicExpectationsAndPassesThroughUnexpectedMethods()
    {
        $m = mock(new MockeryTestFoo);
        $m->shouldReceive('bar')->andReturn('bar');
        $this->assertEquals('bar', $m->bar());
        $this->assertEquals('foo', $m->foo());
        $this->assertInstanceOf(MockeryTestFoo::class, $m);
    }

    public function testCreatingAPartialAllowsExpectationsToInterceptCallsToImplementedMethods()
    {
        $m = mock(new MockeryTestFoo2);
        $m->shouldReceive('bar')->andReturn('baz');
        $this->assertEquals('baz', $m->bar());
        $this->assertEquals('foo', $m->foo());
        $this->assertInstanceOf(MockeryTestFoo2::class, $m);
    }

    public function testBlockForwardingToPartialObject()
    {
        $m = mock(new MockeryTestBar1, array('foo'=>1, Mockery\Container::BLOCKS => array('method1')));
        $this->assertSame($m, $m->method1());
    }

    public function testPartialWithArrayDefs()
    {
        $m = mock(new MockeryTestBar1, array('foo'=>1, Mockery\Container::BLOCKS => array('method1')));
        $this->assertEquals(1, $m->foo());
    }

    public function testPassingClosureAsFinalParameterUsedToDefineExpectations()
    {
        $m = mock('foo', function ($m) {
            $m->shouldReceive('foo')->once()->andReturn('bar');
        });
        $this->assertEquals('bar', $m->foo());
    }

    public function testMockingAKnownConcreteFinalClassThrowsErrors_OnlyPartialMocksCanMockFinalElements()
    {
        $this->expectException(\Mockery\Exception::class);
        $m = mock('MockeryFoo3');
    }

    public function testMockingAKnownConcreteClassWithFinalMethodsThrowsNoException()
    {
        $this->assertInstanceOf(MockInterface::class, mock('MockeryFoo4'));
    }

    /**
     * @group finalclass
     */
    public function testFinalClassesCanBePartialMocks()
    {
        $m = mock(new MockeryFoo3);
        $m->shouldReceive('foo')->andReturn('baz');
        $this->assertEquals('baz', $m->foo());
        $this->assertNotInstanceOf(MockeryFoo3::class, $m);
    }

    public function testSplClassWithFinalMethodsCanBeMocked()
    {
        $m = mock('SplFileInfo');
        $m->shouldReceive('foo')->andReturn('baz');
        $this->assertEquals('baz', $m->foo());
        $this->assertInstanceOf(SplFileInfo::class, $m);
    }

    public function testSplClassWithFinalMethodsCanBeMockedMultipleTimes()
    {
        mock('SplFileInfo');
        $m = mock('SplFileInfo');
        $m->shouldReceive('foo')->andReturn('baz');
        $this->assertEquals('baz', $m->foo());
        $this->assertInstanceOf(SplFileInfo::class, $m);
    }

    public function testClassesWithFinalMethodsCanBeProxyPartialMocks()
    {
        $m = mock(new MockeryFoo4);
        $m->shouldReceive('foo')->andReturn('baz');
        $this->assertEquals('baz', $m->foo());
        $this->assertEquals('bar', $m->bar());
        $this->assertInstanceOf(MockeryFoo4::class, $m);
    }

    public function testClassesWithFinalMethodsCanBeProperPartialMocks()
    {
        $m = mock('MockeryFoo4[bar]');
        $m->shouldReceive('bar')->andReturn('baz');
        $this->assertEquals('baz', $m->foo());
        $this->assertEquals('baz', $m->bar());
        $this->assertInstanceOf(MockeryFoo4::class, $m);
    }

    public function testClassesWithFinalMethodsCanBeProperPartialMocksButFinalMethodsNotPartialed()
    {
        $m = mock('MockeryFoo4[foo]');
        $m->shouldReceive('foo')->andReturn('foo');
        $this->assertEquals('baz', $m->foo()); // partial expectation ignored - will fail callcount assertion
        $this->assertInstanceOf(MockeryFoo4::class, $m);
    }

    public function testSplfileinfoClassMockPassesUserExpectations()
    {
        $file = mock('SplFileInfo[getFilename,getPathname,getExtension,getMTime]', array(__FILE__));
        $file->shouldReceive('getFilename')->once()->andReturn('foo');
        $file->shouldReceive('getPathname')->once()->andReturn('path/to/foo');
        $file->shouldReceive('getExtension')->once()->andReturn('css');
        $file->shouldReceive('getMTime')->once()->andReturn(time());

        // not sure what this test is for, maybe something special about
        // SplFileInfo
        $this->assertEquals('foo', $file->getFilename());
        $this->assertEquals('path/to/foo', $file->getPathname());
        $this->assertEquals('css', $file->getExtension());
        $this->assertTrue(is_int($file->getMTime()));
    }

    public function testCanMockInterface()
    {
        $m = mock('MockeryTest_Interface');
        $this->assertInstanceOf(MockeryTest_Interface::class, $m);
    }

    public function testCanMockSpl()
    {
        $m = mock('\\SplFixedArray');
        $this->assertInstanceOf(SplFixedArray::class, $m);
    }

    public function testCanMockInterfaceWithAbstractMethod()
    {
        $m = mock('MockeryTest_InterfaceWithAbstractMethod');
        $this->assertInstanceOf(MockeryTest_InterfaceWithAbstractMethod::class, $m);
        $m->shouldReceive('foo')->andReturn(1);
        $this->assertEquals(1, $m->foo());
    }

    public function testCanMockAbstractWithAbstractProtectedMethod()
    {
        $m = mock('MockeryTest_AbstractWithAbstractMethod');
        $this->assertInstanceOf(MockeryTest_AbstractWithAbstractMethod::class, $m);
    }

    public function testCanMockInterfaceWithPublicStaticMethod()
    {
        $m = mock('MockeryTest_InterfaceWithPublicStaticMethod');
        $this->assertInstanceOf(MockeryTest_InterfaceWithPublicStaticMethod::class, $m);
    }

    public function testCanMockClassWithConstructor()
    {
        $m = mock('MockeryTest_ClassConstructor');
        $this->assertInstanceOf(MockeryTest_ClassConstructor::class, $m);
    }

    public function testCanMockClassWithConstructorNeedingClassArgs()
    {
        $m = mock('MockeryTest_ClassConstructor2');
        $this->assertInstanceOf(MockeryTest_ClassConstructor2::class, $m);
    }

    /**
     * @group partial
     */
    public function testCanPartiallyMockANormalClass()
    {
        $m = mock('MockeryTest_PartialNormalClass[foo]');
        $this->assertInstanceOf(MockeryTest_PartialNormalClass::class, $m);
        $m->shouldReceive('foo')->andReturn('cba');
        $this->assertEquals('abc', $m->bar());
        $this->assertEquals('cba', $m->foo());
    }

    /**
     * @group partial
     */
    public function testCanPartiallyMockAnAbstractClass()
    {
        $m = mock('MockeryTest_PartialAbstractClass[foo]');
        $this->assertInstanceOf(MockeryTest_PartialAbstractClass::class, $m);
        $m->shouldReceive('foo')->andReturn('cba');
        $this->assertEquals('abc', $m->bar());
        $this->assertEquals('cba', $m->foo());
    }

    /**
     * @group partial
     */
    public function testCanPartiallyMockANormalClassWith2Methods()
    {
        $m = mock('MockeryTest_PartialNormalClass2[foo, baz]');
        $this->assertInstanceOf(MockeryTest_PartialNormalClass2::class, $m);
        $m->shouldReceive('foo')->andReturn('cba');
        $m->shouldReceive('baz')->andReturn('cba');
        $this->assertEquals('abc', $m->bar());
        $this->assertEquals('cba', $m->foo());
        $this->assertEquals('cba', $m->baz());
    }

    /**
     * @group partial
     */
    public function testCanPartiallyMockAnAbstractClassWith2Methods()
    {
        $m = mock('MockeryTest_PartialAbstractClass2[foo,baz]');
        $this->assertInstanceOf(MockeryTest_PartialAbstractClass2::class, $m);
        $m->shouldReceive('foo')->andReturn('cba');
        $m->shouldReceive('baz')->andReturn('cba');
        $this->assertEquals('abc', $m->bar());
        $this->assertEquals('cba', $m->foo());
        $this->assertEquals('cba', $m->baz());
    }

    /**
     * @group partial
     */
    public function testThrowsExceptionIfSettingExpectationForNonMockedMethodOfPartialMock()
    {
        $this->markTestSkipped('For now...');
        $m = mock('MockeryTest_PartialNormalClass[foo]');
        $this->assertInstanceOf(MockeryTest_PartialNormalClass::class, $m);
        $this->expectException(\Mockery\Exception::class);
        $m->shouldReceive('bar')->andReturn('cba');
    }

    /**
     * @group partial
     */
    public function testThrowsExceptionIfClassOrInterfaceForPartialMockDoesNotExist()
    {
        $this->expectException(\Mockery\Exception::class);
        $m = mock('MockeryTest_PartialNormalClassXYZ[foo]');
    }

    /**
     * @group partial
     */
    public function testCanUseExclamationToBlacklistMethod()
    {
        $m = mock('MockeryTest_PartialNormalClass2[!foo]');
        $this->assertSame('abc', $m->foo());
    }

    /**
     * @group partial
     */
    public function testCantCallMethodWhenUsingBlacklistAndNoExpectation()
    {
        $m = mock('MockeryTest_PartialNormalClass2[!foo]');
        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessageRegExp('/::bar\(\), but no expectations were specified/');
        $m->bar();
    }

    /**
     * @group partial
     */
    public function testCanUseBlacklistAndExpectionOnNonBlacklistedMethod()
    {
        $m = mock('MockeryTest_PartialNormalClass2[!foo]');
        $m->shouldReceive('bar')->andReturn('test')->once();
        $this->assertSame('test', $m->bar());
    }
    /**
     * @group partial
     */
    public function testCanUseEmptyMethodlist()
    {
        $m = mock('MockeryTest_PartialNormalClass2[]');
    }

    /**
     * @group issue/4
     */
    public function testCanMockClassContainingMagicCallMethod()
    {
        $m = mock('MockeryTest_Call1');
        $this->assertInstanceOf(MockeryTest_Call1::class, $m);
    }

    /**
     * @group issue/4
     */
    public function testCanMockClassContainingMagicCallMethodWithoutTypeHinting()
    {
        $m = mock('MockeryTest_Call2');
        $this->assertInstanceOf(MockeryTest_Call2::class, $m);
    }

    /**
     * @group issue/14
     */
    public function testCanMockClassContainingAPublicWakeupMethod()
    {
        $m = mock('MockeryTest_Wakeup1');
        $this->assertInstanceOf(MockeryTest_Wakeup1::class, $m);
    }

    /**
     * @group issue/18
     */
    public function testCanMockClassUsingMagicCallMethodsInPlaceOfNormalMethods()
    {
        $m = Mockery::mock('Gateway');
        $m->shouldReceive('iDoSomethingReallyCoolHere');
        $m->iDoSomethingReallyCoolHere();
    }

    /**
     * @group issue/18
     */
    public function testCanPartialMockObjectUsingMagicCallMethodsInPlaceOfNormalMethods()
    {
        $m = Mockery::mock(new Gateway);
        $m->shouldReceive('iDoSomethingReallyCoolHere');
        $m->iDoSomethingReallyCoolHere();
    }

    /**
     * @group issue/13
     */
    public function testCanMockClassWhereMethodHasReferencedParameter()
    {
        $this->assertInstanceOf(MockInterface::class, Mockery::mock(new MockeryTest_MethodParamRef));
    }

    /**
     * @group issue/13
     */
    public function testCanPartiallyMockObjectWhereMethodHasReferencedParameter()
    {
        $this->assertInstanceOf(MockInterface::class, Mockery::mock(new MockeryTest_MethodParamRef2));
    }

    /**
     * @group issue/11
     */
    public function testMockingAKnownConcreteClassCanBeGrantedAnArbitraryClassType()
    {
        $m = mock('alias:MyNamespace\MyClass');
        $m->shouldReceive('foo')->andReturn('bar');
        $this->assertEquals('bar', $m->foo());
        $this->assertInstanceOf(MyNamespace\MyClass::class, $m);
    }

    /**
     * @group issue/15
     */
    public function testCanMockMultipleInterfaces()
    {
        $m = mock('MockeryTest_Interface1, MockeryTest_Interface2');
        $this->assertInstanceOf(MockeryTest_Interface1::class, $m);
        $this->assertInstanceOf(MockeryTest_Interface2::class, $m);
    }

    /**
     */
    public function testCanMockMultipleInterfacesThatMayNotExist()
    {
        $m = mock('NonExistingClass, MockeryTest_Interface1, MockeryTest_Interface2, \Some\Thing\That\Doesnt\Exist');
        $this->assertInstanceOf(MockeryTest_Interface1::class, $m);
        $this->assertInstanceOf(MockeryTest_Interface2::class, $m);
        $this->assertInstanceOf(\Some\Thing\That\Doesnt\Exist::class, $m);
    }

    /**
     * @group issue/15
     */
    public function testCanMockClassAndApplyMultipleInterfaces()
    {
        $m = mock('MockeryTestFoo, MockeryTest_Interface1, MockeryTest_Interface2');
        $this->assertInstanceOf(MockeryTestFoo::class, $m);
        $this->assertInstanceOf(MockeryTest_Interface1::class, $m);
        $this->assertInstanceOf(MockeryTest_Interface2::class, $m);
    }

    /**
     * @group issue/7
     *
     * Noted: We could complicate internally, but a blind class is better built
     * with a real class noted up front (stdClass is a perfect choice it is
     * behaviourless). Fine, it's a muddle - but we need to draw a line somewhere.
     */
    public function testCanMockStaticMethods()
    {
        $m = mock('alias:MyNamespace\MyClass2');
        $m->shouldReceive('staticFoo')->andReturn('bar');
        $this->assertEquals('bar', \MyNameSpace\MyClass2::staticFoo());
    }

    /**
     * @group issue/7
     */
    public function testMockedStaticMethodsObeyMethodCounting()
    {
        $m = mock('alias:MyNamespace\MyClass3');
        $m->shouldReceive('staticFoo')->once()->andReturn('bar');
        $this->expectException(\Mockery\CountValidator\Exception::class);
        Mockery::close();
    }

    /**
     */
    public function testMockedStaticThrowsExceptionWhenMethodDoesNotExist()
    {
        $m = mock('alias:MyNamespace\StaticNoMethod');
        try {
            MyNameSpace\StaticNoMethod::staticFoo();
        } catch (BadMethodCallException $e) {
            // Mockery + PHPUnit has a fail safe for tests swallowing our
            // exceptions
            $e->dismiss();
            return;
        }

        $this->fail('Exception was not thrown');
    }

    /**
     * @group issue/17
     */
    public function testMockingAllowsPublicPropertyStubbingOnRealClass()
    {
        $m = mock('MockeryTestFoo');
        $m->foo = 'bar';
        $this->assertEquals('bar', $m->foo);
        //$this->assertArrayHasKey('foo', $m->mockery_getMockableProperties());
    }

    /**
     * @group issue/17
     */
    public function testMockingAllowsPublicPropertyStubbingOnNamedMock()
    {
        $m = mock('Foo');
        $m->foo = 'bar';
        $this->assertEquals('bar', $m->foo);
        //$this->assertArrayHasKey('foo', $m->mockery_getMockableProperties());
    }

    /**
     * @group issue/17
     */
    public function testMockingAllowsPublicPropertyStubbingOnPartials()
    {
        $m = mock(new stdClass);
        $m->foo = 'bar';
        $this->assertEquals('bar', $m->foo);
        //$this->assertArrayHasKey('foo', $m->mockery_getMockableProperties());
    }

    /**
     * @group issue/17
     */
    public function testMockingDoesNotStubNonStubbedPropertiesOnPartials()
    {
        $m = mock(new MockeryTest_ExistingProperty);
        $this->assertEquals('bar', $m->foo);
        $this->assertArrayNotHasKey('foo', $m->mockery_getMockableProperties());
    }

    public function testCreationOfInstanceMock()
    {
        $m = mock('overload:MyNamespace\MyClass4');
        $this->assertInstanceOf(MyNamespace\MyClass4::class, $m);
    }

    public function testInstantiationOfInstanceMock()
    {
        $m = mock('overload:MyNamespace\MyClass5');
        $instance = new MyNamespace\MyClass5;
        $this->assertInstanceOf(MyNamespace\MyClass5::class, $instance);
    }

    public function testInstantiationOfInstanceMockImportsExpectations()
    {
        $m = mock('overload:MyNamespace\MyClass6');
        $m->shouldReceive('foo')->andReturn('bar');
        $instance = new MyNamespace\MyClass6;
        $this->assertEquals('bar', $instance->foo());
    }

    public function testInstantiationOfInstanceMockImportsDefaultExpectations()
    {
        $m = mock('overload:MyNamespace\MyClass6');
        $m->shouldReceive('foo')->andReturn('bar')->byDefault();
        $instance = new MyNamespace\MyClass6;

        $this->assertEquals('bar', $instance->foo());
    }

    public function testInstantiationOfInstanceMockImportsDefaultExpectationsInTheCorrectOrder()
    {
        $m = mock('overload:MyNamespace\MyClass6');
        $m->shouldReceive('foo')->andReturn(1)->byDefault();
        $m->shouldReceive('foo')->andReturn(2)->byDefault();
        $m->shouldReceive('foo')->andReturn(3)->byDefault();
        $instance = new MyNamespace\MyClass6;

        $this->assertEquals(3, $instance->foo());
    }

    public function testInstantiationOfInstanceMocksIgnoresVerificationOfOriginMock()
    {
        $m = mock('overload:MyNamespace\MyClass7');
        $m->shouldReceive('foo')->once()->andReturn('bar');
    }

    public function testInstantiationOfInstanceMocksAddsThemToContainerForVerification()
    {
        $m = mock('overload:MyNamespace\MyClass8');
        $m->shouldReceive('foo')->once();
        $instance = new MyNamespace\MyClass8;
        $this->expectException(\Mockery\CountValidator\Exception::class);
        Mockery::close();
    }

    public function testInstantiationOfInstanceMocksDoesNotHaveCountValidatorCrossover()
    {
        $m = mock('overload:MyNamespace\MyClass9');
        $m->shouldReceive('foo')->once();
        $instance1 = new MyNamespace\MyClass9;
        $instance2 = new MyNamespace\MyClass9;
        $instance1->foo();
        $instance2->foo();
    }

    public function testInstantiationOfInstanceMocksDoesNotHaveCountValidatorCrossover2()
    {
        $m = mock('overload:MyNamespace\MyClass10');
        $m->shouldReceive('foo')->once();
        $instance1 = new MyNamespace\MyClass10;
        $instance2 = new MyNamespace\MyClass10;
        $instance1->foo();
        $this->expectException(\Mockery\CountValidator\Exception::class);
        Mockery::close();
    }

    public function testCreationOfInstanceMockWithFullyQualifiedName()
    {
        $m = mock('overload:\MyNamespace\MyClass11');
        $this->assertInstanceOf(MyNamespace\MyClass11::class, $m);
    }

    public function testInstanceMocksShouldIgnoreMissing()
    {
        $m = mock('overload:MyNamespace\MyClass12');
        $m->shouldIgnoreMissing();

        $instance = new MyNamespace\MyClass12();
        $this->assertNull($instance->foo());
    }

    /**
     * @group issue/451
     */
    public function testSettingPropertyOnInstanceMockWillSetItOnActualInstance()
    {
        $m = mock('overload:MyNamespace\MyClass13');
        $m->shouldReceive('foo')->andSet('bar', 'baz');
        $instance = new MyNamespace\MyClass13;
        $instance->foo();
        $this->assertEquals('baz', $m->bar);
        $this->assertEquals('baz', $instance->bar);
    }

    public function testInstantiationOfInstanceMockWithConstructorParameterValidation()
    {
        $m = mock('overload:MyNamespace\MyClass14');
        $params = [
            'value1' => uniqid('test_')
        ];
        $m->shouldReceive('__construct')->with($params);

        new MyNamespace\MyClass14($params);
    }

    public function testInstantiationOfInstanceMockWithConstructorParameterValidationNegative()
    {
        $m = mock('overload:MyNamespace\MyClass15');
        $params = [
            'value1' => uniqid('test_')
        ];
        $m->shouldReceive('__construct')->with($params);

        $this->expectException(\Mockery\Exception\NoMatchingExpectationException::class);
        new MyNamespace\MyClass15([]);
    }

    public function testInstantiationOfInstanceMockWithConstructorParameterValidationException()
    {
        $m = mock('overload:MyNamespace\MyClass16');
        $m->shouldReceive('__construct')
            ->andThrow(new \Exception('instanceMock '.rand(100, 999)));

        $this->expectException(\Exception::class);
        $this->expectExceptionMessageRegExp('/^instanceMock \d{3}$/');
        new MyNamespace\MyClass16();
    }

    public function testMethodParamsPassedByReferenceHaveReferencePreserved()
    {
        $m = mock('MockeryTestRef1');
        $m->shouldReceive('foo')->with(
            Mockery::on(function (&$a) {
                $a += 1;
                return true;
            }),
            Mockery::any()
        );
        $a = 1;
        $b = 1;
        $m->foo($a, $b);
        $this->assertEquals(2, $a);
        $this->assertEquals(1, $b);
    }

    public function testMethodParamsPassedByReferenceThroughWithArgsHaveReferencePreserved()
    {
        $m = mock('MockeryTestRef1');
        $m->shouldReceive('foo')->withArgs(function (&$a, $b) {
            $a += 1;
            $b += 1;
            return true;
        });
        $a = 1;
        $b = 1;
        $m->foo($a, $b);
        $this->assertEquals(2, $a);
        $this->assertEquals(1, $b);
    }

    /**
     * Meant to test the same logic as
     * testCanOverrideExpectedParametersOfExtensionPHPClassesToPreserveRefs,
     * but:
     * - doesn't require an extension
     * - isn't actually known to be used
     */
    public function testCanOverrideExpectedParametersOfInternalPHPClassesToPreserveRefs()
    {
        Mockery::getConfiguration()->setInternalClassMethodParamMap(
            'DateTime', 'modify', array('&$string')
        );
        // @ used to avoid E_STRICT for incompatible signature
        @$m = mock('DateTime');
        $this->assertInstanceOf("Mockery\MockInterface", $m, "Mocking failed, remove @ error suppresion to debug");
        $m->shouldReceive('modify')->with(
            Mockery::on(function (&$string) {
                $string = 'foo';
                return true;
            })
        );
        $data ='bar';
        $m->modify($data);
        $this->assertEquals('foo', $data);
        Mockery::getConfiguration()->resetInternalClassMethodParamMaps();
    }

    /**
     * Real world version of
     * testCanOverrideExpectedParametersOfInternalPHPClassesToPreserveRefs
     */
    public function testCanOverrideExpectedParametersOfExtensionPHPClassesToPreserveRefs()
    {
        if (!class_exists('MongoCollection', false)) {
            $this->markTestSkipped('ext/mongo not installed');
        }
        Mockery::getConfiguration()->setInternalClassMethodParamMap(
            'MongoCollection', 'insert', array('&$data', '$options')
        );
        // @ used to avoid E_STRICT for incompatible signature
        @$m = mock('MongoCollection');
        $this->assertInstanceOf("Mockery\MockInterface", $m, "Mocking failed, remove @ error suppresion to debug");
        $m->shouldReceive('insert')->with(
            Mockery::on(function (&$data) {
                $data['_id'] = 123;
                return true;
            }),
            Mockery::type('array')
        );
        $data = array('a'=>1,'b'=>2);
        $m->insert($data, array());
        $this->assertArrayHasKey('_id', $data);
        $this->assertEquals(123, $data['_id']);
        Mockery::getConfiguration()->resetInternalClassMethodParamMaps();
    }

    public function testCanCreateNonOverridenInstanceOfPreviouslyOverridenInternalClasses()
    {
        Mockery::getConfiguration()->setInternalClassMethodParamMap(
            'DateTime', 'modify', array('&$string')
        );
        // @ used to avoid E_STRICT for incompatible signature
        @$m = mock('DateTime');
        $this->assertInstanceOf("Mockery\MockInterface", $m, "Mocking failed, remove @ error suppresion to debug");
        $rc = new ReflectionClass($m);
        $rm = $rc->getMethod('modify');
        $params = $rm->getParameters();
        $this->assertTrue($params[0]->isPassedByReference());

        Mockery::getConfiguration()->resetInternalClassMethodParamMaps();

        $m = mock('DateTime');
        $this->assertInstanceOf("Mockery\MockInterface", $m, "Mocking failed");
        $rc = new ReflectionClass($m);
        $rm = $rc->getMethod('modify');
        $params = $rm->getParameters();
        $this->assertFalse($params[0]->isPassedByReference());

        Mockery::getConfiguration()->resetInternalClassMethodParamMaps();
    }

    /**
     * @group abstract
     */
    public function testCanMockAbstractClassWithAbstractPublicMethod()
    {
        $m = mock('MockeryTest_AbstractWithAbstractPublicMethod');
        $this->assertInstanceOf(MockeryTest_AbstractWithAbstractPublicMethod::class, $m);
    }

    /**
     * @issue issue/21
     */
    public function testClassDeclaringIssetDoesNotThrowException()
    {
        $this->assertInstanceOf(MockInterface::class, mock('MockeryTest_IssetMethod'));
    }

    /**
     * @issue issue/21
     */
    public function testClassDeclaringUnsetDoesNotThrowException()
    {
        $this->assertInstanceOf(MockInterface::class, mock('MockeryTest_UnsetMethod'));
    }

    /**
     * @issue issue/35
     */
    public function testCallingSelfOnlyReturnsLastMockCreatedOrCurrentMockBeingProgrammedSinceTheyAreOneAndTheSame()
    {
        $m = mock('MockeryTestFoo');
        $this->assertNotInstanceOf(MockeryTestFoo2::class, Mockery::self());
        //$m = mock('MockeryTestFoo2');
        //$this->assertInstanceOf(MockeryTestFoo2::class, self());
        //$m = mock('MockeryTestFoo');
        //$this->assertNotInstanceOf(MockeryTestFoo2::class, Mockery::self());
        //$this->assertInstanceOf(MockeryTestFoo::class, Mockery::self());
    }

    /**
     * @issue issue/89
     */
    public function testCreatingMockOfClassWithExistingToStringMethodDoesntCreateClassWithTwoToStringMethods()
    {
        $m = mock('MockeryTest_WithToString'); // this would fatal
        $m->shouldReceive("__toString")->andReturn('dave');
        $this->assertEquals("dave", "$m");
    }

    public function testGetExpectationCount_freshContainer()
    {
        $this->assertEquals(0, Mockery::getContainer()->mockery_getExpectationCount());
    }

    public function testGetExpectationCount_simplestMock()
    {
        $m = mock();
        $m->shouldReceive('foo')->andReturn('bar');
        $this->assertEquals(1, Mockery::getContainer()->mockery_getExpectationCount());
    }

    public function testMethodsReturningParamsByReferenceDoesNotErrorOut()
    {
        mock('MockeryTest_ReturnByRef');
        $mock = mock('MockeryTest_ReturnByRef');
        $mock->shouldReceive("get")->andReturn($var = 123);
        $this->assertSame($var, $mock->get());
    }


    public function testMockCallableTypeHint()
    {
        $this->assertInstanceOf(MockInterface::class, mock('MockeryTest_MockCallableTypeHint'));
    }

    public function testCanMockClassWithReservedWordMethod()
    {
        if (!extension_loaded("redis")) {
            $this->markTestSkipped("phpredis not installed");
        }

        mock("Redis");
    }

    public function testUndeclaredClassIsDeclared()
    {
        $this->assertFalse(class_exists("BlahBlah"));
        $mock = mock("BlahBlah");
        $this->assertInstanceOf("BlahBlah", $mock);
    }

    public function testUndeclaredClassWithNamespaceIsDeclared()
    {
        $this->assertFalse(class_exists("MyClasses\Blah\BlahBlah"));
        $mock = mock("MyClasses\Blah\BlahBlah");
        $this->assertInstanceOf("MyClasses\Blah\BlahBlah", $mock);
    }

    public function testUndeclaredClassWithNamespaceIncludingLeadingOperatorIsDeclared()
    {
        $this->assertFalse(class_exists("\MyClasses\DaveBlah\BlahBlah"));
        $mock = mock("\MyClasses\DaveBlah\BlahBlah");
        $this->assertInstanceOf("\MyClasses\DaveBlah\BlahBlah", $mock);
    }

    public function testMockingPhpredisExtensionClassWorks()
    {
        if (!class_exists('Redis')) {
            $this->markTestSkipped('PHPRedis extension required for this test');
        }
        $m = mock('Redis');
    }

    public function testIssetMappingUsingProxiedPartials_CheckNoExceptionThrown()
    {
        $var = mock(new MockeryTestIsset_Bar());
        $mock = mock(new MockeryTestIsset_Foo($var));
        $mock->shouldReceive('bar')->once();
        $mock->bar();
        Mockery::close();

        $this->assertTrue(true);
    }

    /**
     * @group traversable1
     */
    public function testCanMockInterfacesExtendingTraversable()
    {
        $mock = mock('MockeryTest_InterfaceWithTraversable');
        $this->assertInstanceOf('MockeryTest_InterfaceWithTraversable', $mock);
        $this->assertInstanceOf('ArrayAccess', $mock);
        $this->assertInstanceOf('Countable', $mock);
        $this->assertInstanceOf('Traversable', $mock);
    }

    /**
     * @group traversable2
     */
    public function testCanMockInterfacesAlongsideTraversable()
    {
        $mock = mock('stdClass, ArrayAccess, Countable, Traversable');
        $this->assertInstanceOf('stdClass', $mock);
        $this->assertInstanceOf('ArrayAccess', $mock);
        $this->assertInstanceOf('Countable', $mock);
        $this->assertInstanceOf('Traversable', $mock);
    }

    public function testInterfacesCanHaveAssertions()
    {
        $m = mock('stdClass, ArrayAccess, Countable, Traversable');
        $m->shouldReceive('foo')->once();
        $m->foo();
    }

    public function testMockingIteratorAggregateDoesNotImplementIterator()
    {
        $mock = mock('MockeryTest_ImplementsIteratorAggregate');
        $this->assertInstanceOf('IteratorAggregate', $mock);
        $this->assertInstanceOf('Traversable', $mock);
        $this->assertNotInstanceOf('Iterator', $mock);
    }

    public function testMockingInterfaceThatExtendsIteratorDoesNotImplementIterator()
    {
        $mock = mock('MockeryTest_InterfaceThatExtendsIterator');
        $this->assertInstanceOf('Iterator', $mock);
        $this->assertInstanceOf('Traversable', $mock);
    }

    public function testMockingInterfaceThatExtendsIteratorAggregateDoesNotImplementIterator()
    {
        $mock = mock('MockeryTest_InterfaceThatExtendsIteratorAggregate');
        $this->assertInstanceOf('IteratorAggregate', $mock);
        $this->assertInstanceOf('Traversable', $mock);
        $this->assertNotInstanceOf('Iterator', $mock);
    }

    public function testMockingIteratorAggregateDoesNotImplementIteratorAlongside()
    {
        $mock = mock('IteratorAggregate');
        $this->assertInstanceOf('IteratorAggregate', $mock);
        $this->assertInstanceOf('Traversable', $mock);
        $this->assertNotInstanceOf('Iterator', $mock);
    }

    public function testMockingIteratorDoesNotImplementIteratorAlongside()
    {
        $mock = mock('Iterator');
        $this->assertInstanceOf('Iterator', $mock);
        $this->assertInstanceOf('Traversable', $mock);
    }

    public function testMockingIteratorDoesNotImplementIterator()
    {
        $mock = mock('MockeryTest_ImplementsIterator');
        $this->assertInstanceOf('Iterator', $mock);
        $this->assertInstanceOf('Traversable', $mock);
    }

    public function testMockeryCloseForIllegalIssetFileInclude()
    {
        $m = Mockery::mock('StdClass')
            ->shouldReceive('get')
            ->andReturn(false)
            ->getMock();
        $m->get();
        Mockery::close();

        // no idea what this test does, adding this as an assertion...
        $this->assertTrue(true);
    }

    public function testMockeryShouldDistinguishBetweenConstructorParamsAndClosures()
    {
        $obj = new MockeryTestFoo();
        $this->assertInstanceOf(MockInterface::class, mock('MockeryTest_ClassMultipleConstructorParams[dave]', [
            &$obj, 'foo'
        ]));
    }

    /** @group nette */
    public function testMockeryShouldNotMockCallstaticMagicMethod()
    {
        $this->assertInstanceOf(MockInterface::class, mock('MockeryTest_CallStatic'));
    }

    /** @group issue/144 */
    public function testMockeryShouldInterpretEmptyArrayAsConstructorArgs()
    {
        $mock = mock("EmptyConstructorTest", array());
        $this->assertSame(0, $mock->numberOfConstructorArgs);
    }

    /** @group issue/144 */
    public function testMockeryShouldCallConstructorByDefaultWhenRequestingPartials()
    {
        $mock = mock("EmptyConstructorTest[foo]");
        $this->assertSame(0, $mock->numberOfConstructorArgs);
    }

    /** @group issue/158 */
    public function testMockeryShouldRespectInterfaceWithMethodParamSelf()
    {
        $this->assertInstanceOf(MockInterface::class, mock('MockeryTest_InterfaceWithMethodParamSelf'));
    }

    /** @group issue/162 */
    public function testMockeryDoesntTryAndMockLowercaseToString()
    {
        $this->assertInstanceOf(MockInterface::class, mock('MockeryTest_Lowercase_ToString'));
    }

    /** @group issue/175 */
    public function testExistingStaticMethodMocking()
    {
        $mock = mock('MockeryTest_PartialStatic[mockMe]');

        $mock->shouldReceive('mockMe')->with(5)->andReturn(10);

        $this->assertEquals(10, $mock::mockMe(5));
        $this->assertEquals(3, $mock::keepMe(3));
    }

    /**
     * @group issue/154
     */
    public function testShouldThrowIfAttemptingToStubProtectedMethod()
    {
        $mock = mock('MockeryTest_WithProtectedAndPrivate');

        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('protectedMethod() cannot be mocked as it is a protected method and mocking protected methods is not enabled for the currently used mock object.');
        $mock->shouldReceive("protectedMethod");
    }

    /**
     * @group issue/154
     */
    public function testShouldThrowIfAttemptingToStubPrivateMethod()
    {
        $mock = mock('MockeryTest_WithProtectedAndPrivate');
        $this->expectException(\InvalidArgumentException::class);
        $this->expectExceptionMessage('privateMethod() cannot be mocked as it is a private method');
        $mock->shouldReceive("privateMethod");
    }

    public function testWakeupMagicIsNotMockedToAllowSerialisationInstanceHack()
    {
        $this->assertInstanceOf(\DateTime::class, mock('DateTime'));
    }

    /**
     * @group issue/154
     */
    public function testCanMockMethodsWithRequiredParamsThatHaveDefaultValues()
    {
        $mock = mock('MockeryTest_MethodWithRequiredParamWithDefaultValue');
        $mock->shouldIgnoreMissing();
        $this->assertNull($mock->foo(null, 123));
    }

    /**
     * @test
     * @group issue/294
     */
    public function testThrowsWhenNamedMockClassExistsAndIsNotMockery()
    {
        $builder = new MockConfigurationBuilder();
        $builder->setName("DateTime");
        $this->expectException(\Mockery\Exception\RuntimeException::class);
        $this->expectExceptionMessage('Could not load mock DateTime, class already exists');
        $mock = mock($builder);
    }

    public function testHandlesMethodWithArgumentExpectationWhenCalledWithResource()
    {
        $mock = mock('MyTestClass');
        $mock->shouldReceive('foo')->with(array('yourself' => 21));

        $this->expectException(\Mockery\Exception\NoMatchingExpectationException::class);
        $this->expectExceptionMessage("0 => Hamcrest\Core\IsEqual Object (...)");
        $mock->foo(fopen('php://memory', 'r'));
    }

    public function testHandlesMethodWithArgumentExpectationWhenCalledWithCircularArray()
    {
        $testArray = array();
        $testArray['myself'] =& $testArray;

        $mock = mock('MyTestClass');
        $mock->shouldReceive('foo')->with(array('yourself' => 21));

        $this->expectException(\Mockery\Exception\NoMatchingExpectationException::class);
        $this->expectExceptionMessage("'myself' => Hamcrest\Core\IsEqual Object (...)");
        $mock->foo($testArray);
    }

    public function testHandlesMethodWithArgumentExpectationWhenCalledWithNestedArray()
    {
        $testArray = array();
        $testArray['a_scalar'] = 2;
        $testArray['an_array'] = array(1, 2, 3);

        $mock = mock('MyTestClass');
        $mock->shouldReceive('foo')->with(array('yourself' => 21));

        $this->expectException(\Mockery\Exception\NoMatchingExpectationException::class);
        $this->expectExceptionMessage("MyTestClass::foo(['a_scalar' => 2, 'an_array' => [...]])");
        $mock->foo($testArray);
    }

    public function testHandlesMethodWithArgumentExpectationWhenCalledWithNestedObject()
    {
        $testArray = array();
        $testArray['a_scalar'] = 2;
        $testArray['an_object'] = new stdClass();

        $mock = mock('MyTestClass');
        $mock->shouldReceive('foo')->with(array('yourself' => 21));

        $this->expectException(\Mockery\Exception\NoMatchingExpectationException::class);
        $this->expectExceptionMessage("MyTestClass::foo(['a_scalar' => 2, 'an_object' => object(stdClass)])");
        $mock->foo($testArray);
    }

    public function testHandlesMethodWithArgumentExpectationWhenCalledWithNestedClosure()
    {
        $testArray = array();
        $testArray['a_scalar'] = 2;
        $testArray['a_closure'] = function () {
        };

        $mock = mock('MyTestClass');
        $mock->shouldReceive('foo')->with(array('yourself' => 21));

        $this->expectException(\Mockery\Exception\NoMatchingExpectationException::class);
        $this->expectExceptionMessage("MyTestClass::foo(['a_scalar' => 2, 'a_closure' => object(Closure");
        $mock->foo($testArray);
    }

    public function testHandlesMethodWithArgumentExpectationWhenCalledWithNestedResource()
    {
        $testArray = array();
        $testArray['a_scalar'] = 2;
        $testArray['a_resource'] = fopen('php://memory', 'r');

        $mock = mock('MyTestClass');
        $mock->shouldReceive('foo')->with(array('yourself' => 21));

        $this->expectException(\Mockery\Exception\NoMatchingExpectationException::class);
        $this->expectExceptionMessage("MyTestClass::foo(['a_scalar' => 2, 'a_resource' => resource(...)])");
        $mock->foo($testArray);
    }

    public function testExceptionOutputMakesBooleansLookLikeBooleans()
    {
        $mock = mock('MyTestClass');
        $mock->shouldReceive("foo")->with(123);

        $this->expectException(
            "Mockery\Exception\NoMatchingExpectationException",
            "MyTestClass::foo(true, false, [0 => true, 1 => false])"
        );

        $mock->foo(true, false, [true, false]);
    }

    /**
     * @test
     * @group issue/339
     */
    public function canMockClassesThatDescendFromInternalClasses()
    {
        $mock = mock("MockeryTest_ClassThatDescendsFromInternalClass");
        $this->assertInstanceOf("DateTime", $mock);
    }

    /**
     * @test
     * @group issue/339
     */
    public function canMockClassesThatImplementSerializable()
    {
        $mock = mock("MockeryTest_ClassThatImplementsSerializable");
        $this->assertInstanceOf("Serializable", $mock);
    }

    /**
     * @test
     * @group issue/346
     */
    public function canMockInternalClassesThatImplementSerializable()
    {
        $mock = mock("ArrayObject");
        $this->assertInstanceOf("Serializable", $mock);
    }

    /**
     * @dataProvider classNameProvider
     */
    public function testIsValidClassName($expected, $className)
    {
        $container = new \Mockery\Container;
        $this->assertSame($expected, $container->isValidClassName($className));
    }

    public function classNameProvider()
    {
        return array(
            array(false, ' '), // just a space
            array(false, 'ClassName.WithDot'),
            array(false, '\\\\TooManyBackSlashes'),
            array(true,  'Foo'),
            array(true,  '\\Foo\\Bar'),
        );
    }
}

class MockeryTest_CallStatic
{
    public static function __callStatic($method, $args)
    {
    }
}

class MockeryTest_ClassMultipleConstructorParams
{
    public function __construct($a, $b)
    {
    }

    public function dave()
    {
    }
}

interface MockeryTest_InterfaceWithTraversable extends ArrayAccess, Traversable, Countable
{
    public function self();
}

class MockeryTestIsset_Bar
{
    public function doSomething()
    {
    }
}

class MockeryTestIsset_Foo
{
    private $var;

    public function __construct($var)
    {
        $this->var = $var;
    }

    public function __get($name)
    {
        $this->var->doSomething();
    }

    public function __isset($name)
    {
        return (bool) strlen($this->__get($name));
    }
}

class MockeryTest_IssetMethod
{
    protected $_properties = array();

    public function __construct()
    {
    }

    public function __isset($property)
    {
        return isset($this->_properties[$property]);
    }
}

class MockeryTest_UnsetMethod
{
    protected $_properties = array();

    public function __construct()
    {
    }

    public function __unset($property)
    {
        unset($this->_properties[$property]);
    }
}

class MockeryTestFoo
{
    public function foo()
    {
        return 'foo';
    }
}

class MockeryTestFoo2
{
    public function foo()
    {
        return 'foo';
    }

    public function bar()
    {
        return 'bar';
    }
}

final class MockeryFoo3
{
    public function foo()
    {
        return 'baz';
    }
}

class MockeryFoo4
{
    final public function foo()
    {
        return 'baz';
    }

    public function bar()
    {
        return 'bar';
    }
}

interface MockeryTest_Interface
{
}
interface MockeryTest_Interface1
{
}
interface MockeryTest_Interface2
{
}

interface MockeryTest_InterfaceWithAbstractMethod
{
    public function set();
}

interface MockeryTest_InterfaceWithPublicStaticMethod
{
    public static function self();
}

abstract class MockeryTest_AbstractWithAbstractMethod
{
    abstract protected function set();
}

class MockeryTest_WithProtectedAndPrivate
{
    protected function protectedMethod()
    {
    }

    private function privateMethod()
    {
    }
}

class MockeryTest_ClassConstructor
{
    public function __construct($param1)
    {
    }
}

class MockeryTest_ClassConstructor2
{
    protected $param1;

    public function __construct(stdClass $param1)
    {
        $this->param1 = $param1;
    }

    public function getParam1()
    {
        return $this->param1;
    }

    public function foo()
    {
        return 'foo';
    }

    public function bar()
    {
        return $this->foo();
    }
}

class MockeryTest_Call1
{
    public function __call($method, array $params)
    {
    }
}

class MockeryTest_Call2
{
    public function __call($method, $params)
    {
    }
}

class MockeryTest_Wakeup1
{
    public function __construct()
    {
    }

    public function __wakeup()
    {
    }
}

class MockeryTest_ExistingProperty
{
    public $foo = 'bar';
}

abstract class MockeryTest_AbstractWithAbstractPublicMethod
{
    abstract public function foo($a, $b);
}

// issue/18
class SoCool
{
    public function iDoSomethingReallyCoolHere()
    {
        return 3;
    }
}

class Gateway
{
    public function __call($method, $args)
    {
        $m = new SoCool();
        return call_user_func_array(array($m, $method), $args);
    }
}

class MockeryTestBar1
{
    public function method1()
    {
        return $this;
    }
}

class MockeryTest_ReturnByRef
{
    public $i = 0;

    public function &get()
    {
        return $this->$i;
    }
}

class MockeryTest_MethodParamRef
{
    public function method1(&$foo)
    {
        return true;
    }
}
class MockeryTest_MethodParamRef2
{
    public function method1(&$foo)
    {
        return true;
    }
}
class MockeryTestRef1
{
    public function foo(&$a, $b)
    {
    }
}

class MockeryTest_PartialNormalClass
{
    public function foo()
    {
        return 'abc';
    }

    public function bar()
    {
        return 'abc';
    }
}

abstract class MockeryTest_PartialAbstractClass
{
    abstract public function foo();

    public function bar()
    {
        return 'abc';
    }
}

class MockeryTest_PartialNormalClass2
{
    public function foo()
    {
        return 'abc';
    }

    public function bar()
    {
        return 'abc';
    }

    public function baz()
    {
        return 'abc';
    }
}

abstract class MockeryTest_PartialAbstractClass2
{
    abstract public function foo();

    public function bar()
    {
        return 'abc';
    }

    abstract public function baz();
}

class MockeryTest_TestInheritedType
{
}

if (PHP_VERSION_ID >= 50400) {
    class MockeryTest_MockCallableTypeHint
    {
        public function foo(callable $baz)
        {
            $baz();
        }

        public function bar(callable $callback = null)
        {
            $callback();
        }
    }
}

class MockeryTest_WithToString
{
    public function __toString()
    {
    }
}

class MockeryTest_ImplementsIteratorAggregate implements IteratorAggregate
{
    public function getIterator()
    {
        return new ArrayIterator(array());
    }
}

class MockeryTest_ImplementsIterator implements Iterator
{
    public function rewind()
    {
    }

    public function current()
    {
    }

    public function key()
    {
    }

    public function next()
    {
    }

    public function valid()
    {
    }
}

class EmptyConstructorTest
{
    public $numberOfConstructorArgs;

    public function __construct(...$args)
    {
        $this->numberOfConstructorArgs = count($args);
    }

    public function foo()
    {
    }
}

interface MockeryTest_InterfaceWithMethodParamSelf
{
    public function foo(self $bar);
}

class MockeryTest_Lowercase_ToString
{
    public function __tostring()
    {
    }
}

class MockeryTest_PartialStatic
{
    public static function mockMe($a)
    {
        return $a;
    }

    public static function keepMe($b)
    {
        return $b;
    }
}

class MockeryTest_MethodWithRequiredParamWithDefaultValue
{
    public function foo(DateTime $bar = null, $baz)
    {
    }
}

interface MockeryTest_InterfaceThatExtendsIterator extends Iterator
{
    public function foo();
}

interface MockeryTest_InterfaceThatExtendsIteratorAggregate extends IteratorAggregate
{
    public function foo();
}

class MockeryTest_ClassThatDescendsFromInternalClass extends DateTime
{
}

class MockeryTest_ClassThatImplementsSerializable implements Serializable
{
    public function serialize()
    {
    }

    public function unserialize($serialized)
    {
    }
}
