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

use Psy\CodeCleaner\ValidConstantPass;

class ValidConstantPassTest extends CodeCleanerTestCase
{
    public function setUp()
    {
        $this->setPass(new ValidConstantPass());
    }

    /**
     * @dataProvider getInvalidReferences
     * @expectedException \Psy\Exception\FatalErrorException
     */
    public function testProcessInvalidConstantReferences($code)
    {
        $this->parseAndTraverse($code);
    }

    public function getInvalidReferences()
    {
        return [
            ['Foo\BAR'],

            // class constant fetch
            ['Psy\Test\CodeCleaner\ValidConstantPassTest::FOO'],
            ['DateTime::BACON'],
        ];
    }

    /**
     * @dataProvider getValidReferences
     */
    public function testProcessValidConstantReferences($code)
    {
        $this->parseAndTraverse($code);
        $this->assertTrue(true);
    }

    public function getValidReferences()
    {
        return [
            ['PHP_EOL'],

            // class constant fetch
            ['NotAClass::FOO'],
            ['DateTime::ATOM'],
            ['$a = new DateTime; $a::ATOM'],
            ['DateTime::class'],
            ['$a = new DateTime; $a::class'],
        ];
    }
}
