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

use Psy\CodeCleaner\AssignThisVariablePass;

class AssignThisVariablePassTest extends CodeCleanerTestCase
{
    public function setUp()
    {
        $this->setPass(new AssignThisVariablePass());
    }

    /**
     * @dataProvider invalidStatements
     * @expectedException \Psy\Exception\FatalErrorException
     */
    public function testProcessStatementFails($code)
    {
        $this->parseAndTraverse($code);
    }

    public function invalidStatements()
    {
        return [
            ['$this = 3'],
            ['strtolower($this = "this")'],
        ];
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
            ['$this'],
            ['$a = $this'],
            ['$a = "this"; $$a = 3'],
            ['$$this = "b"'],
        ];
    }
}
