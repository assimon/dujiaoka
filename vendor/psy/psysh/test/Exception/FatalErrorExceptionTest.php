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

use Psy\Exception\FatalErrorException;

class FatalErrorExceptionTest extends \PHPUnit\Framework\TestCase
{
    public function testInstance()
    {
        $e = new FatalErrorException();

        $this->assertInstanceOf('Psy\Exception\Exception', $e);
        $this->assertInstanceOf('ErrorException', $e);
        $this->assertInstanceOf('Psy\Exception\FatalErrorException', $e);
    }

    public function testMessage()
    {
        $e = new FatalErrorException('{msg}', 0, 0, '{filename}', 13);

        $this->assertSame('{msg}', $e->getRawMessage());
        $this->assertContains('{msg}', $e->getMessage());
        $this->assertContains('{filename}', $e->getMessage());
        $this->assertContains('line 13', $e->getMessage());
    }

    public function testMessageWithNoFilename()
    {
        $e = new FatalErrorException('{msg}');

        $this->assertSame('{msg}', $e->getRawMessage());
        $this->assertContains('{msg}', $e->getMessage());
        $this->assertContains('eval()\'d code', $e->getMessage());
    }

    public function testNegativeOneLineNumberIgnored()
    {
        $e = new FatalErrorException('{msg}', 0, 1, null, -1);
        $this->assertEquals(0, $e->getLine());
    }
}
