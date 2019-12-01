<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Test\Exception;

use Psy\Exception\BreakException;

class BreakExceptionTest extends \PHPUnit\Framework\TestCase
{
    public function testInstance()
    {
        $e = new BreakException();

        $this->assertInstanceOf('Psy\Exception\Exception', $e);
        $this->assertInstanceOf('Psy\Exception\BreakException', $e);
    }

    public function testMessage()
    {
        $e = new BreakException('foo');

        $this->assertContains('foo', $e->getMessage());
        $this->assertSame('foo', $e->getRawMessage());
    }

    /**
     * @expectedException \Psy\Exception\BreakException
     * @expectedExceptionMessage Goodbye
     */
    public function testExitShell()
    {
        BreakException::exitShell();
    }
}
