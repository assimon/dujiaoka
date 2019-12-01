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

use Psy\CodeCleaner\LeavePsyshAlonePass;

class LeavePsyshAlonePassTest extends CodeCleanerTestCase
{
    public function setUp()
    {
        $this->setPass(new LeavePsyshAlonePass());
    }

    public function testPassesInlineHtmlThroughJustFine()
    {
        $inline = $this->parse('not php at all!', '');
        $this->traverse($inline);
        $this->assertTrue(true);
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
            ['array_merge()'],
            ['__psysh__()'],
            ['$this'],
            ['$psysh'],
            ['$__psysh'],
            ['$banana'],
        ];
    }

    /**
     * @dataProvider invalidStatements
     * @expectedException \Psy\Exception\RuntimeException
     */
    public function testProcessStatementFails($code)
    {
        $this->parseAndTraverse($code);
    }

    public function invalidStatements()
    {
        return [
            ['$__psysh__'],
            ['var_dump($__psysh__)'],
            ['$__psysh__ = "your mom"'],
            ['$__psysh__->fakeFunctionCall()'],
        ];
    }
}
