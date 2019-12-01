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

use Psy\Readline\HoaConsole;

class HoaConsoleTest extends \PHPUnit\Framework\TestCase
{
    public function testHistory()
    {
        $readline = new HoaConsole();
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
}
