<?php

namespace Cron\Tests;

use Cron\FieldFactory;
use PHPUnit_Framework_TestCase;

/**
 * @author Michael Dowling <mtdowling@gmail.com>
 */
class FieldFactoryTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers Cron\FieldFactory::getField
     */
    public function testRetrievesFieldInstances()
    {
        $mappings = array(
            0 => 'Cron\MinutesField',
            1 => 'Cron\HoursField',
            2 => 'Cron\DayOfMonthField',
            3 => 'Cron\MonthField',
            4 => 'Cron\DayOfWeekField',
            5 => 'Cron\YearField'
        );

        $f = new FieldFactory();

        foreach ($mappings as $position => $class) {
            $this->assertEquals($class, get_class($f->getField($position)));
        }
    }

    /**
     * @covers Cron\FieldFactory::getField
     * @expectedException InvalidArgumentException
     */
    public function testValidatesFieldPosition()
    {
        $f = new FieldFactory();
        $f->getField(-1);
    }
}
