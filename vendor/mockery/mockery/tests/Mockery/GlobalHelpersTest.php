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
 * @copyright  Copyright (c) 2016 Dave Marshall
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

use Mockery\Adapter\Phpunit\MockeryTestCase;

class GlobalHelpersTest extends MockeryTestCase
{
    public function mockeryTestSetUp()
    {
        \Mockery::globalHelpers();
    }

    public function mockeryTestTearDown()
    {
        \Mockery::close();
    }

    /** @test */
    public function mock_creates_a_mock()
    {
        $double = mock();

        $this->assertInstanceOf(\Mockery\MockInterface::class, $double);
        $this->expectException(\Exception::class);
        $double->foo();
    }

    /** @test */
    public function spy_creates_a_spy()
    {
        $double = spy();

        $this->assertInstanceOf(\Mockery\MockInterface::class, $double);
        $double->foo();
    }

    /** @test */
    public function named_mock_creates_a_named_mock()
    {
        $className = "Class".uniqid();
        $double = namedMock($className);

        $this->assertInstanceOf(\Mockery\MockInterface::class, $double);
        $this->assertInstanceOf($className, $double);
    }
}
