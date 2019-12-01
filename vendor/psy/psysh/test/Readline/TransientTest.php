<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Test\Readline;

use Psy\Readline\Transient;

class TransientTest extends \PHPUnit\Framework\TestCase
{
    public function testHistory()
    {
        $readline = new Transient();
        $this->assertEmpty($readline->listHistory());
        $readline->addHistory('foo');
        $this->assertSame(['foo'], $readline->listHistory());
        $readline->addHistory('bar');
        $this->assertSame(['foo', 'bar'], $readline->listHistory());
        $readline->addHistory('baz');
        $this->assertSame(['foo', 'bar', 'baz'], $readline->listHistory());
        $readline->clearHistory();
        $this->assertEmpty($readline->listHistory());
    }

    /**
     * @depends testHistory
     */
    public function testHistorySize()
    {
        $readline = new Transient(null, 2);
        $this->assertEmpty($readline->listHistory());
        $readline->addHistory('foo');
        $readline->addHistory('bar');
        $this->assertSame(['foo', 'bar'], $readline->listHistory());
        $readline->addHistory('baz');
        $this->assertSame(['bar', 'baz'], $readline->listHistory());
        $readline->addHistory('w00t');
        $this->assertSame(['baz', 'w00t'], $readline->listHistory());
        $readline->clearHistory();
        $this->assertEmpty($readline->listHistory());
    }

    /**
     * @depends testHistory
     */
    public function testHistoryEraseDups()
    {
        $readline = new Transient(null, 0, true);
        $this->assertEmpty($readline->listHistory());
        $readline->addHistory('foo');
        $readline->addHistory('bar');
        $readline->addHistory('foo');
        $this->assertSame(['bar', 'foo'], $readline->listHistory());
        $readline->addHistory('baz');
        $readline->addHistory('w00t');
        $readline->addHistory('baz');
        $this->assertSame(['bar', 'foo', 'w00t', 'baz'], $readline->listHistory());
        $readline->clearHistory();
        $this->assertEmpty($readline->listHistory());
    }

    public function testSomeThingsAreAlwaysTrue()
    {
        $readline = new Transient();
        $this->assertTrue(Transient::isSupported());
        $this->assertTrue($readline->readHistory());
        $this->assertTrue($readline->writeHistory());
    }
}
