<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Test\TabCompletion;

use Psy\Command\ListCommand;
use Psy\Command\ShowCommand;
use Psy\Configuration;
use Psy\Context;
use Psy\ContextAware;
use Psy\TabCompletion\Matcher;

class AutoCompleterTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @param string $line
     * @param array  $mustContain
     * @param array  $mustNotContain
     * @dataProvider classesInput
     */
    public function testClassesCompletion($line, $mustContain, $mustNotContain)
    {
        $context = new Context();

        $commands = [
            new ShowCommand(),
            new ListCommand(),
        ];

        $matchers = [
            new Matcher\VariablesMatcher(),
            new Matcher\ClassNamesMatcher(),
            new Matcher\ConstantsMatcher(),
            new Matcher\FunctionsMatcher(),
            new Matcher\ObjectMethodsMatcher(),
            new Matcher\ObjectAttributesMatcher(),
            new Matcher\KeywordsMatcher(),
            new Matcher\ClassAttributesMatcher(),
            new Matcher\ClassMethodsMatcher(),
            new Matcher\CommandsMatcher($commands),
        ];

        $config = new Configuration();
        $tabCompletion = $config->getAutoCompleter();
        foreach ($matchers as $matcher) {
            if ($matcher instanceof ContextAware) {
                $matcher->setContext($context);
            }
            $tabCompletion->addMatcher($matcher);
        }

        $context->setAll(['foo' => 12, 'bar' => new \DOMDocument()]);

        $code = $tabCompletion->processCallback('', 0, [
           'line_buffer' => $line,
           'point'       => 0,
           'end'         => \strlen($line),
        ]);

        foreach ($mustContain as $mc) {
            $this->assertContains($mc, $code);
        }

        foreach ($mustNotContain as $mnc) {
            $this->assertNotContains($mnc, $code);
        }
    }

    /**
     * TODO
     * ====
     * draft, open to modifications
     * - [ ] if the variable is an array, return the square bracket for completion
     * - [ ] if the variable is a constructor or method, reflect to complete as a function call
     * - [ ] if the preceding token is a variable, call operators or keywords compatible for completion
     * - [X] a command always should be the second token after php_open_tag
     * - [X] keywords are never consecutive
     * - [X] namespacing completion should work just fine
     * - [X] after a new keyword, should always be a class constructor, never a function call or keyword, constant,
     *       or variable that does not contain a existing class name.
     * - [X] on a namespaced constructor the completion must show the classes related, not constants.
     *
     * @return array
     */
    public function classesInput()
    {
        return [
            // input, must had, must not had
            ['T_OPE', ['T_OPEN_TAG'], []],
            ['st', ['stdClass'], []],
            ['stdCla', ['stdClass'], []],
            ['new s', ['stdClass'], []],
            [
                'new ',
                ['stdClass', 'Psy\\Context', 'Psy\\Configuration'],
                ['require', 'array_search', 'T_OPEN_TAG', '$foo'],
            ],
            ['new Psy\\C', ['Context'], ['CASE_LOWER']],
            ['\s', ['stdClass'], []],
            ['array_', ['array_search', 'array_map', 'array_merge'], []],
            ['$bar->', ['load'], []],
            ['$b', ['bar'], []],
            ['6 + $b', ['bar'], []],
            ['$f', ['foo'], []],
            ['l', ['ls'], []],
            ['ls ', [], ['ls']],
            ['sho', ['show'], []],
            ['12 + clone $', ['foo'], []],
            // array(
            //   '$foo ',
            //   array('+', 'clone'),
            //   array('$foo', 'DOMDocument', 'array_map')
            // ), requires a operator matcher?
            ['$', ['foo', 'bar'], ['require', 'array_search', 'T_OPEN_TAG', 'Psy']],
            [
                'Psy\\',
                ['Context', 'TabCompletion\\Matcher\\AbstractMatcher'],
                ['require', 'array_search'],
            ],
            [
                'Psy\Test\TabCompletion\StaticSample::CO',
                ['StaticSample::CONSTANT_VALUE'],
                [],
            ],
            [
                'Psy\Test\TabCompletion\StaticSample::',
                ['StaticSample::$staticVariable'],
                [],
            ],
            [
                'Psy\Test\TabCompletion\StaticSample::',
                ['StaticSample::staticFunction'],
                [],
            ],
        ];
    }
}
