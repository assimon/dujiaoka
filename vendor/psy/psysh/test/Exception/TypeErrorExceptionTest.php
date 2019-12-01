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

use Psy\Exception\TypeErrorException;

class TypeErrorExceptionTest extends \PHPUnit\Framework\TestCase
{
    public function testException()
    {
        $e = new TypeErrorException('{{message}}', 13);

        $this->assertInstanceOf('Psy\Exception\Exception', $e);
        $this->assertInstanceOf('Psy\Exception\TypeErrorException', $e);

        $this->assertEquals('TypeError: {{message}}', $e->getMessage());
        $this->assertEquals('{{message}}', $e->getRawMessage());
        $this->assertEquals(13, $e->getCode());
    }

    public function testStripsEvalFromMessage()
    {
        $message = 'Something or other, called in line 10: eval()\'d code';
        $e = new TypeErrorException($message);
        $this->assertEquals($message, $e->getRawMessage());
        $this->assertEquals('TypeError: Something or other', $e->getMessage());
    }

    public function testFromTypeError()
    {
        if (\version_compare(PHP_VERSION, '7.0.0', '<')) {
            $this->markTestSkipped();
        }

        $previous = new \TypeError('{{message}}', 13);
        $e = TypeErrorException::fromTypeError($previous);

        $this->assertInstanceOf('Psy\Exception\TypeErrorException', $e);
        $this->assertEquals('TypeError: {{message}}', $e->getMessage());
        $this->assertEquals('{{message}}', $e->getRawMessage());
        $this->assertEquals(13, $e->getCode());
    }
}
