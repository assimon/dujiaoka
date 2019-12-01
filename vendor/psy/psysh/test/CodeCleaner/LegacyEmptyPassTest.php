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

use Psy\CodeCleaner\LegacyEmptyPass;

class LegacyEmptyPassTest extends CodeCleanerTestCase
{
    public function setUp()
    {
        $this->setPass(new LegacyEmptyPass());
    }

    /**
     * @dataProvider invalidStatements
     * @expectedException \Psy\Exception\ParseErrorException
     */
    public function testProcessInvalidStatement($code)
    {
        $this->parseAndTraverse($code);
    }

    public function invalidStatements()
    {
        if (\version_compare(PHP_VERSION, '5.5', '>=')) {
            return [
                ['empty()'],
            ];
        }

        return [
            ['empty()'],
            ['empty(null)'],
            ['empty(PHP_EOL)'],
            ['empty("wat")'],
            ['empty(1.1)'],
            ['empty(Foo::$bar)'],
        ];
    }

    /**
     * @dataProvider validStatements
     */
    public function testProcessValidStatement($code)
    {
        $this->parseAndTraverse($code);
        $this->assertTrue(true);
    }

    public function validStatements()
    {
        if (\version_compare(PHP_VERSION, '5.5', '<')) {
            return [
                ['empty($foo)'],
            ];
        }

        return [
            ['empty($foo)'],
            ['empty(null)'],
            ['empty(PHP_EOL)'],
            ['empty("wat")'],
            ['empty(1.1)'],
            ['empty(Foo::$bar)'],
        ];
    }
}
