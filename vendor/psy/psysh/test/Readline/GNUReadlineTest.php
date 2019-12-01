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

use Psy\Readline\GNUReadline;

class GNUReadlineTest extends \PHPUnit\Framework\TestCase
{
    private $historyFile;

    public function setUp()
    {
        if (!GNUReadline::isSupported()) {
            $this->markTestSkipped('GNUReadline not enabled');
        }

        $this->historyFile = \tempnam(\sys_get_temp_dir(), 'psysh_test_history');
        \file_put_contents($this->historyFile, "_HiStOrY_V2_\n");
    }

    public function testHistory()
    {
        $readline = new GNUReadline($this->historyFile);
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
        $readline = new GNUReadline($this->historyFile, 2);
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
        $readline = new GNUReadline($this->historyFile, 0, true);
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
}
