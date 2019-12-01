<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Test\Input;

use Psy\Input\FilterOptions;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\StringInput;

class FilterOptionsTest extends \PHPUnit\Framework\TestCase
{
    public function testGetOptions()
    {
        $opts = FilterOptions::getOptions();
        $this->assertCount(3, $opts);
    }

    /**
     * @dataProvider validInputs
     */
    public function testBindValidInput($input, $hasFilter = true)
    {
        $input = $this->getInput($input);
        $filterOptions = new FilterOptions();
        $filterOptions->bind($input);

        $this->assertEquals($hasFilter, $filterOptions->hasFilter());
    }

    public function validInputs()
    {
        return [
            ['--grep="bar"'],
            ['--grep="bar" --invert'],
            ['--grep="bar" --insensitive'],
            ['--grep="bar" --invert --insensitive'],
            ['', false],
        ];
    }

    /**
     * @dataProvider invalidInputs
     * @expectedException \Psy\Exception\RuntimeException
     */
    public function testBindInvalidInput($input)
    {
        $input = $this->getInput($input);
        $filterOptions = new FilterOptions();
        $filterOptions->bind($input);
    }

    public function invalidInputs()
    {
        return [
            ['--invert'],
            ['--insensitive'],
            ['--invert --insensitive'],

            // invalid because regex
            ['--grep /*/'],
        ];
    }

    /**
     * @dataProvider matchData
     */
    public function testMatch($input, $str, $matches)
    {
        $input = $this->getInput($input);
        $filterOptions = new FilterOptions();
        $filterOptions->bind($input);

        $this->assertEquals($matches, $filterOptions->match($str));
    }

    public function matchData()
    {
        return [
            ['', 'whatever', true],
            ['--grep FOO', 'foo', false],
            ['--grep foo', 'foo', true],
            ['--grep foo', 'food', true],
            ['--grep oo', 'Food', true],
            ['--grep oo -i', 'FOOD', true],
            ['--grep foo -v', 'food', false],
            ['--grep foo -v', 'whatever', true],
        ];
    }

    private function getInput($input)
    {
        $input = new StringInput($input);
        $input->bind(new InputDefinition(FilterOptions::getOptions()));

        return $input;
    }
}
