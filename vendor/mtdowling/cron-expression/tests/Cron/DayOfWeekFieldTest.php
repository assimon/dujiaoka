<?php

namespace Cron\Tests;

use Cron\DayOfWeekField;
use DateTime;
use PHPUnit_Framework_TestCase;

/**
 * @author Michael Dowling <mtdowling@gmail.com>
 */
class DayOfWeekFieldTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers Cron\DayOfWeekField::validate
     */
    public function testValidatesField()
    {
        $f = new DayOfWeekField();
        $this->assertTrue($f->validate('1'));
        $this->assertTrue($f->validate('*'));
        $this->assertTrue($f->validate('*/3,1,1-12'));
        $this->assertTrue($f->validate('SUN-2'));
        $this->assertFalse($f->validate('1.'));
    }

    /**
     * @covers Cron\DayOfWeekField::isSatisfiedBy
     */
    public function testChecksIfSatisfied()
    {
        $f = new DayOfWeekField();
        $this->assertTrue($f->isSatisfiedBy(new DateTime(), '?'));
    }

    /**
     * @covers Cron\DayOfWeekField::increment
     */
    public function testIncrementsDate()
    {
        $d = new DateTime('2011-03-15 11:15:00');
        $f = new DayOfWeekField();
        $f->increment($d);
        $this->assertEquals('2011-03-16 00:00:00', $d->format('Y-m-d H:i:s'));

        $d = new DateTime('2011-03-15 11:15:00');
        $f->increment($d, true);
        $this->assertEquals('2011-03-14 23:59:00', $d->format('Y-m-d H:i:s'));
    }

    /**
     * @covers Cron\DayOfWeekField::isSatisfiedBy
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage Weekday must be a value between 0 and 7. 12 given
     */
    public function testValidatesHashValueWeekday()
    {
        $f = new DayOfWeekField();
        $this->assertTrue($f->isSatisfiedBy(new DateTime(), '12#1'));
    }

    /**
     * @covers Cron\DayOfWeekField::isSatisfiedBy
     * @expectedException InvalidArgumentException
     * @expectedExceptionMessage There are never more than 5 of a given weekday in a month
     */
    public function testValidatesHashValueNth()
    {
        $f = new DayOfWeekField();
        $this->assertTrue($f->isSatisfiedBy(new DateTime(), '3#6'));
    }

    /**
     * @covers Cron\DayOfWeekField::validate
     */
    public function testValidateWeekendHash()
    {
        $f = new DayOfWeekField();
        $this->assertTrue($f->validate('MON#1'));
        $this->assertTrue($f->validate('TUE#2'));
        $this->assertTrue($f->validate('WED#3'));
        $this->assertTrue($f->validate('THU#4'));
        $this->assertTrue($f->validate('FRI#5'));
        $this->assertTrue($f->validate('SAT#1'));
        $this->assertTrue($f->validate('SUN#3'));
        $this->assertTrue($f->validate('MON#1,MON#3'));
    }

    /**
     * @covers Cron\DayOfWeekField::isSatisfiedBy
     */
    public function testHandlesZeroAndSevenDayOfTheWeekValues()
    {
        $f = new DayOfWeekField();
        $this->assertTrue($f->isSatisfiedBy(new DateTime('2011-09-04 00:00:00'), '0-2'));
        $this->assertTrue($f->isSatisfiedBy(new DateTime('2011-09-04 00:00:00'), '6-0'));

        $this->assertTrue($f->isSatisfiedBy(new DateTime('2014-04-20 00:00:00'), 'SUN'));
        $this->assertTrue($f->isSatisfiedBy(new DateTime('2014-04-20 00:00:00'), 'SUN#3'));
        $this->assertTrue($f->isSatisfiedBy(new DateTime('2014-04-20 00:00:00'), '0#3'));
        $this->assertTrue($f->isSatisfiedBy(new DateTime('2014-04-20 00:00:00'), '7#3'));
    }

    /**
     * @see https://github.com/mtdowling/cron-expression/issues/47
     */
    public function testIssue47() {
        $f = new DayOfWeekField();
        $this->assertFalse($f->validate('mon,'));
        $this->assertFalse($f->validate('mon-'));
        $this->assertFalse($f->validate('*/2,'));
        $this->assertFalse($f->validate('-mon'));
        $this->assertFalse($f->validate(',1'));
        $this->assertFalse($f->validate('*-'));
        $this->assertFalse($f->validate(',-'));
    }
}
