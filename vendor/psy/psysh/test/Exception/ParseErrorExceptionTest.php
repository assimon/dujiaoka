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

use Psy\Exception\ParseErrorException;

class ParseErrorExceptionTest extends \PHPUnit\Framework\TestCase
{
    public function testInstance()
    {
        $e = new ParseErrorException();

        $this->assertInstanceOf('Psy\Exception\Exception', $e);
        $this->assertInstanceOf('PhpParser\Error', $e);
        $this->assertInstanceOf('Psy\Exception\ParseErrorException', $e);
    }

    public function testMessage()
    {
        $e = new ParseErrorException('{msg}', 1);

        $this->assertContains('{msg}', $e->getMessage());
        $this->assertContains('PHP Parse error:', $e->getMessage());
    }

    public function testConstructFromParseError()
    {
        $e = ParseErrorException::fromParseError(new \PhpParser\Error('{msg}'));

        $this->assertContains('{msg}', $e->getRawMessage());
        $this->assertContains('PHP Parse error:', $e->getMessage());
    }
}
