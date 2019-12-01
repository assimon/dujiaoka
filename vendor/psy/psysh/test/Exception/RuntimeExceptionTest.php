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

use Psy\Exception\RuntimeException;

class RuntimeExceptionTest extends \PHPUnit\Framework\TestCase
{
    public function testException()
    {
        $msg = 'bananas';
        $e   = new RuntimeException($msg);

        $this->assertInstanceOf('Psy\Exception\Exception', $e);
        $this->assertInstanceOf('RuntimeException', $e);
        $this->assertInstanceOf('Psy\Exception\RuntimeException', $e);

        $this->assertSame($msg, $e->getMessage());
        $this->assertSame($msg, $e->getRawMessage());
    }
}
