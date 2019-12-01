<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Test\CodeCleaner;

use PhpParser\Node\Stmt\Expression;
use Psy\CodeCleaner\NoReturnValue;
use Psy\Test\ParserTestCase;

class NoReturnValueTest extends ParserTestCase
{
    public function testCreate()
    {
        $stmt = NoReturnValue::create();
        if (\class_exists('PhpParser\Node\Stmt\Expression')) {
            $stmt = new Expression($stmt);
        }

        $this->assertSame(
            $this->prettyPrint($this->parse('new \\Psy\CodeCleaner\\NoReturnValue()')),
            $this->prettyPrint([$stmt])
        );
    }
}
