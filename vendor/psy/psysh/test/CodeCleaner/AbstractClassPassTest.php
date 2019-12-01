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

use Psy\CodeCleaner\AbstractClassPass;

class AbstractClassPassTest extends CodeCleanerTestCase
{
    public function setUp()
    {
        $this->setPass(new AbstractClassPass());
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
            ['class A { abstract function a(); }'],
            ['abstract class B { abstract function b() {} }'],
            ['abstract class B { abstract function b() { echo "yep"; } }'],
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
            ['abstract class C { function c() {} }'],
            ['abstract class D { abstract function d(); }'],
        ];
    }
}
