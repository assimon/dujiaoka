<?php

namespace Cron\Tests;

use Cron\HoursField;
use DateTime;
use PHPUnit_Framework_TestCase;

/**
 * @author Michael Dowling <mtdowling@gmail.com>
 */
class HoursFieldTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers Cron\HoursField::validate
     */
    public function testValidatesField()
    {
        $f = new HoursField();
        $this->assertTrue($f->validate('1'));
        $this->assertTrue($f->validate('*'));
        $this->assertTrue($f->validate('*/3,1,1-12'));
     }

    /**
     * @covers Cron\HoursField::increment
     */
    public function testIncrementsDate()
    {
        $d = new DateTime('2011-03-15 11:15:00');
        $f = new HoursField();
        $f->increment($d);
        $this->assertEquals('2011-03-15 12:00:00', $d->format('Y-m-d H:i:s'));

        $d->setTime(11, 15, 0);
        $f->increment($d, true);
        $this->assertEquals('2011-03-15 10:59:00', $d->format('Y-m-d H:i:s'));
    }

    /**
     * @covers Cron\HoursField::increment
     */
    public function testIncrementsDateWithThirtyMinuteOffsetTimezone()
    {
        $tz = date_default_timezone_get();
        date_default_timezone_set('America/St_Johns');
        $d = new DateTime('2011-03-15 11:15:00');
        $f = new HoursField();
        $f->increment($d);
        $this->assertEquals('2011-03-15 12:00:00', $d->format('Y-m-d H:i:s'));

        $d->setTime(11, 15, 0);
        $f->increment($d, true);
        $this->assertEquals('2011-03-15 10:59:00', $d->format('Y-m-d H:i:s'));
        date_default_timezone_set($tz);
    }

    /**
     * @covers Cron\HoursField::increment
     */
    public function testIncrementDateWithFifteenMinuteOffsetTimezone()
    {
        $tz = date_default_timezone_get();
        date_default_timezone_set('Asia/Kathmandu');
        $d = new DateTime('2011-03-15 11:15:00');
        $f = new HoursField();
        $f->increment($d);
        $this->assertEquals('2011-03-15 12:00:00', $d->format('Y-m-d H:i:s'));

        $d->setTime(11, 15, 0);
        $f->increment($d, true);
        $this->assertEquals('2011-03-15 10:59:00', $d->format('Y-m-d H:i:s'));
        date_default_timezone_set($tz);
    }
}
