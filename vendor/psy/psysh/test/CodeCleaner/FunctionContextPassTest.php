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

use Psy\CodeCleaner\FunctionContextPass;

class FunctionContextPassTest extends CodeCleanerTestCase
{
    public function setUp()
    {
        $this->setPass(new FunctionContextPass());
    }

    /**
     * @dataProvider validStatements
     */
    public function testProcessStatementPasses($code)
    {
        $this->parseAndTraverse($code);
        $this->assertTrue(true);
    }

    public function validStatements()
    {
        return [
            ['function foo() { yield; }'],
            ['if (function(){ yield; })'],
        ];
    }

    /**
     * @dataProvider invalidYieldStatements
     * @expectedException \Psy\Exception\FatalErrorException
     */
    public function testInvalidYield($code)
    {
        $this->parseAndTraverse($code);
    }

    public function invalidYieldStatements()
    {
        return [
            ['yield'],
            ['if (yield)'],
        ];
    }
}
