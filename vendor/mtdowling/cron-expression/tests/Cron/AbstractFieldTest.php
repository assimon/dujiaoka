<?php

namespace Cron\Tests;

use Cron\DayOfWeekField;
use PHPUnit_Framework_TestCase;

/**
 * @author Michael Dowling <mtdowling@gmail.com>
 */
class AbstractFieldTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers Cron\AbstractField::isRange
     */
    public function testTestsIfRange()
    {
        $f = new DayOfWeekField();
        $this->assertTrue($f->isRange('1-2'));
        $this->assertFalse($f->isRange('2'));
    }

    /**
     * @covers Cron\AbstractField::isIncrementsOfRanges
     */
    public function testTestsIfIncrementsOfRanges()
    {
        $f = new DayOfWeekField();
        $this->assertFalse($f->isIncrementsOfRanges('1-2'));
        $this->assertTrue($f->isIncrementsOfRanges('1/2'));
        $this->assertTrue($f->isIncrementsOfRanges('*/2'));
        $this->assertTrue($f->isIncrementsOfRanges('3-12/2'));
    }

    /**
     * @covers Cron\AbstractField::isInRange
     */
    public function testTestsIfInRange()
    {
        $f = new DayOfWeekField();
        $this->assertTrue($f->isInRange('1', '1-2'));
        $this->assertTrue($f->isInRange('2', '1-2'));
        $this->assertTrue($f->isInRange('5', '4-12'));
        $this->assertFalse($f->isInRange('3', '4-12'));
        $this->assertFalse($f->isInRange('13', '4-12'));
    }

    /**
     * @covers Cron\AbstractField::isInIncrementsOfRanges
     */
    public function testTestsIfInIncrementsOfRanges()
    {
        $f = new DayOfWeekField();
        $this->assertTrue($f->isInIncrementsOfRanges('3', '3-59/2'));
        $this->assertTrue($f->isInIncrementsOfRanges('13', '3-59/2'));
        $this->assertTrue($f->isInIncrementsOfRanges('15', '3-59/2'));
        $this->assertTrue($f->isInIncrementsOfRanges('14', '*/2'));
        $this->assertFalse($f->isInIncrementsOfRanges('2', '3-59/13'));
        $this->assertFalse($f->isInIncrementsOfRanges('14', '*/13'));
        $this->assertFalse($f->isInIncrementsOfRanges('14', '3-59/2'));
        $this->assertFalse($f->isInIncrementsOfRanges('3', '2-59'));
        $this->assertFalse($f->isInIncrementsOfRanges('3', '2'));
        $this->assertFalse($f->isInIncrementsOfRanges('3', '*'));
        $this->assertFalse($f->isInIncrementsOfRanges('0', '*/0'));
        $this->assertFalse($f->isInIncrementsOfRanges('1', '*/0'));

        $this->assertTrue($f->isInIncrementsOfRanges('4', '4/10'));
        $this->assertTrue($f->isInIncrementsOfRanges('14', '4/10'));
        $this->assertTrue($f->isInIncrementsOfRanges('34', '4/10'));
    }

    /**
     * @covers Cron\AbstractField::isSatisfied
     */
    public function testTestsIfSatisfied()
    {
        $f = new DayOfWeekField();
        $this->assertTrue($f->isSatisfied('12', '3-13'));
        $this->assertTrue($f->isSatisfied('15', '3-59/12'));
        $this->assertTrue($f->isSatisfied('12', '*'));
        $this->assertTrue($f->isSatisfied('12', '12'));
        $this->assertFalse($f->isSatisfied('12', '3-11'));
        $this->assertFalse($f->isSatisfied('12', '3-59/13'));
        $this->assertFalse($f->isSatisfied('12', '11'));
    }
}
