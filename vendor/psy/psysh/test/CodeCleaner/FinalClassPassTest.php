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

use Psy\CodeCleaner\FinalClassPass;

class FinalClassPassTest extends CodeCleanerTestCase
{
    public function setUp()
    {
        $this->setPass(new FinalClassPass());
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
        $data = [
            ['final class A {} class B extends A {}'],
            ['class A {} final class B extends A {} class C extends B {}'],
            // array('namespace A { final class B {} } namespace C { class D extends \\A\\B {} }'),
        ];

        if (!\defined('HHVM_VERSION')) {
            // For some reason Closure isn't final in HHVM?
            $data[] = ['class A extends \\Closure {}'];
        }

        return $data;
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
            ['class A extends \\stdClass {}'],
            ['final class A extends \\stdClass {}'],
            ['class A {} class B extends A {}'],
        ];
    }
}
