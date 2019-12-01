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

use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\MockInterface;
use Mockery\Matcher\PHPUnitConstraint;

class PHPUnitConstraintTest extends MockeryTestCase
{
    /** @var  PHPUnitConstraint */
    protected $matcher;
    /** @var  PHPUnitConstraint */
    protected $rethrowingMatcher;
    /** @var  MockInterface */
    protected $constraint;

    public function mockeryTestSetUp()
    {
        /*
         * Revise by PHPUnit version
         */
        if (class_exists('\PHPUnit\Framework\AssertionFailedError')) {
            $this->assertionFailedError = '\PHPUnit\Framework\AssertionFailedError';
            $this->frameworkConstraint = '\PHPUnit\Framework\Constraint';
        } else {
            $this->assertionFailedError = '\PHPUnit_Framework_AssertionFailedError';
            $this->frameworkConstraint = '\PHPUnit_Framework_Constraint';
        }

        $this->constraint = \Mockery::mock($this->frameworkConstraint);
        $this->matcher = new PHPUnitConstraint($this->constraint);
        $this->rethrowingMatcher = new PHPUnitConstraint($this->constraint, true);
    }

    public function testMatches()
    {
        $value1 = 'value1';
        $value2 = 'value1';
        $value3 = 'value1';
        $this->constraint
            ->shouldReceive('evaluate')
            ->once()
            ->with($value1)
            ->getMock()
            ->shouldReceive('evaluate')
            ->once()
            ->with($value2)
            ->andThrow($this->assertionFailedError)
            ->getMock()
            ->shouldReceive('evaluate')
            ->once()
            ->with($value3)
            ->getMock()
        ;
        $this->assertTrue($this->matcher->match($value1));
        $this->assertFalse($this->matcher->match($value2));
        $this->assertTrue($this->rethrowingMatcher->match($value3));
    }

    public function testMatchesWhereNotMatchAndRethrowing()
    {
        $this->expectException($this->assertionFailedError);
        $value = 'value';
        $this->constraint
            ->shouldReceive('evaluate')
            ->once()
            ->with($value)
            ->andThrow($this->assertionFailedError)
        ;
        $this->rethrowingMatcher->match($value);
    }

    public function test__toString()
    {
        $this->assertEquals('<Constraint>', $this->matcher);
    }
}
