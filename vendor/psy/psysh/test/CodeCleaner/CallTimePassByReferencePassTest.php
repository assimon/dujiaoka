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

use Psy\CodeCleaner\CallTimePassByReferencePass;

class CallTimePassByReferencePassTest extends CodeCleanerTestCase
{
    public function setUp()
    {
        $this->setPass(new CallTimePassByReferencePass());
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
            ['f(&$arg)'],
            ['$object->method($first, &$arg)'],
            ['$closure($first, &$arg, $last)'],
            ['A::b(&$arg)'],
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
            ['array(&$var)'],
            ['$a = &$b'],
            ['f(array(&$b))'],
        ];
    }
}
