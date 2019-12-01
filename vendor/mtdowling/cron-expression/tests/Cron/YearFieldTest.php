<?php

namespace Cron\Tests;

use Cron\YearField;
use DateTime;
use PHPUnit_Framework_TestCase;

/**
 * @author Michael Dowling <mtdowling@gmail.com>
 */
class YearFieldTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers Cron\YearField::validate
     */
    public function testValidatesField()
    {
        $f = new YearField();
        $this->assertTrue($f->validate('2011'));
        $this->assertTrue($f->validate('*'));
        $this->assertTrue($f->validate('*/10,2012,1-12'));
    }

    /**
     * @covers Cron\YearField::increment
     */
    public function testIncrementsDate()
    {
        $d = new DateTime('2011-03-15 11:15:00');
        $f = new YearField();
        $f->increment($d);
        $this->assertEquals('2012-01-01 00:00:00', $d->format('Y-m-d H:i:s'));
        $f->increment($d, true);
        $this->assertEquals('2011-12-31 23:59:00', $d->format('Y-m-d H:i:s'));
    }
}
