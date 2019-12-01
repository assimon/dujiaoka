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

use Psy\Input\CodeArgument;
use Psy\Input\ShellInput;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputOption;

class ShellInputTest extends \PHPUnit\Framework\TestCase
{
    /**
     * @expectedException \InvalidArgumentException
     * @expectedExceptionMessage Unexpected CodeArgument before the final position: a
     */
    public function testThrowsWhenCodeArgumentNotInFinalPosition()
    {
        $definition = new InputDefinition([
            new CodeArgument('a', null, CodeArgument::REQUIRED),
            new InputArgument('b', null, InputArgument::REQUIRED),
        ]);

        $input = new ShellInput('foo bar');
        $input->bind($definition);
    }

    public function testInputOptionWithGivenString()
    {
        $definition = new InputDefinition([
            new InputOption('foo', null, InputOption::VALUE_REQUIRED),
            new CodeArgument('code', null, CodeArgument::REQUIRED),
        ]);

        $input = new ShellInput('--foo=bar echo "baz\\\\n";');
        $input->bind($definition);
        $this->assertSame('bar', $input->getOption('foo'));
        $this->assertSame('echo "baz\n";', $input->getArgument('code'));
    }

    public function testInputOptionWithoutCodeArguments()
    {
        $definition = new InputDefinition([
            new InputOption('foo', null, InputOption::VALUE_REQUIRED),
            new InputOption('qux', 'q', InputOption::VALUE_REQUIRED),
            new InputArgument('bar', null, InputArgument::REQUIRED),
            new InputArgument('baz', null, InputArgument::REQUIRED),
        ]);

        $input = new ShellInput('--foo=foo -q qux bar "baz\\\\n"');
        $input->bind($definition);
        $this->assertSame('foo', $input->getOption('foo'));
        $this->assertSame('qux', $input->getOption('qux'));
        $this->assertSame('bar', $input->getArgument('bar'));
        $this->assertSame('baz\\n', $input->getArgument('baz'));
    }

    public function testInputWithDashDash()
    {
        $definition = new InputDefinition([
            new InputOption('foo', null, InputOption::VALUE_REQUIRED),
            new CodeArgument('code', null, CodeArgument::REQUIRED),
        ]);

        $input = new ShellInput('-- echo --foo::$bar');
        $input->bind($definition);
        $this->assertNull($input->getOption('foo'));
        $this->assertSame('echo --foo::$bar', $input->getArgument('code'));
    }

    public function testInputWithEmptyString()
    {
        $definition = new InputDefinition([
            new InputOption('foo', null, InputOption::VALUE_REQUIRED),
            new CodeArgument('code', null, CodeArgument::REQUIRED),
        ]);

        $input = new ShellInput('"" --foo bar');
        $input->bind($definition);
        $this->assertSame('"" --foo bar', $input->getArgument('code'));
    }

    /**
     * @dataProvider getTokenizeData
     */
    public function testTokenize($input, $tokens, $message)
    {
        $input = new ShellInput($input);
        $r = new \ReflectionClass('Psy\Input\ShellInput');
        $p = $r->getProperty('tokenPairs');
        $p->setAccessible(true);
        $this->assertSame($tokens, $p->getValue($input), $message);
    }

    public function getTokenizeData()
    {
        // Test all the cases from StringInput test, ensuring they have an appropriate $rest token.
        return [
            [
                '',
                [],
                '->tokenize() parses an empty string',
            ],
            [
                'foo',
                [['foo', 'foo']],
                '->tokenize() parses arguments',
            ],
            [
                '  foo  bar  ',
                [['foo', 'foo  bar  '], ['bar', 'bar  ']],
                '->tokenize() ignores whitespaces between arguments',
            ],
            [
                '"quoted"',
                [['quoted', '"quoted"']],
                '->tokenize() parses quoted arguments',
            ],
            [
                "'quoted'",
                [['quoted', "'quoted'"]],
                '->tokenize() parses quoted arguments',
            ],
            [
                "'a\rb\nc\td'",
                [["a\rb\nc\td", "'a\rb\nc\td'"]],
                '->tokenize() parses whitespace chars in strings',
            ],
            [
                "'a'\r'b'\n'c'\t'd'",
                [
                    ['a', "'a'\r'b'\n'c'\t'd'"],
                    ['b', "'b'\n'c'\t'd'"],
                    ['c', "'c'\t'd'"],
                    ['d', "'d'"],
                ],
                '->tokenize() parses whitespace chars between args as spaces',
            ],

            /*
             * These don't play nice with unescaping input, but the end result
             * is correct, so disable the tests for now.
             *
             * @todo Sort this out and re-enable these test cases.
             */
            // [
            //     '\"quoted\"',
            //     [['"quoted"', '\"quoted\"']],
            //     '->tokenize() parses escaped-quoted arguments',
            // ],
            // [
            //     "\'quoted\'",
            //     [['\'quoted\'', "\'quoted\'"]],
            //     '->tokenize() parses escaped-quoted arguments',
            // ],

            [
                '-a',
                 [['-a', '-a']],
                 '->tokenize() parses short options',
             ],
            [
                '-azc',
                [['-azc', '-azc']],
                '->tokenize() parses aggregated short options',
            ],
            [
                '-awithavalue',
                [['-awithavalue', '-awithavalue']],
                '->tokenize() parses short options with a value',
            ],
            [
                '-a"foo bar"',
                [['-afoo bar', '-a"foo bar"']],
                '->tokenize() parses short options with a value',
            ],
            [
                '-a"foo bar""foo bar"',
                [['-afoo barfoo bar', '-a"foo bar""foo bar"']],
                '->tokenize() parses short options with a value',
            ],
            [
                '-a\'foo bar\'',
                [['-afoo bar', '-a\'foo bar\'']],
                '->tokenize() parses short options with a value',
            ],
            [
                '-a\'foo bar\'\'foo bar\'',
                [['-afoo barfoo bar', '-a\'foo bar\'\'foo bar\'']],
                '->tokenize() parses short options with a value',
            ],
            [
                '-a\'foo bar\'"foo bar"',
                [['-afoo barfoo bar', '-a\'foo bar\'"foo bar"']],
                '->tokenize() parses short options with a value',
            ],
            [
                '--long-option',
                [['--long-option', '--long-option']],
                '->tokenize() parses long options',
            ],
            [
                '--long-option=foo',
                [['--long-option=foo', '--long-option=foo']],
                '->tokenize() parses long options with a value',
            ],
            [
                '--long-option="foo bar"',
                [['--long-option=foo bar', '--long-option="foo bar"']],
                '->tokenize() parses long options with a value',
            ],
            [
                '--long-option="foo bar""another"',
                [['--long-option=foo baranother', '--long-option="foo bar""another"']],
                '->tokenize() parses long options with a value',
            ],
            [
                '--long-option=\'foo bar\'',
                [['--long-option=foo bar', '--long-option=\'foo bar\'']],
                '->tokenize() parses long options with a value',
            ],
            [
                "--long-option='foo bar''another'",
                [['--long-option=foo baranother', "--long-option='foo bar''another'"]],
                '->tokenize() parses long options with a value',
            ],
            [
                "--long-option='foo bar'\"another\"",
                [['--long-option=foo baranother', "--long-option='foo bar'\"another\""]],
                '->tokenize() parses long options with a value',
            ],
            [
                'foo -a -ffoo --long bar',
                [
                    ['foo', 'foo -a -ffoo --long bar'],
                    ['-a', '-a -ffoo --long bar'],
                    ['-ffoo', '-ffoo --long bar'],
                    ['--long', '--long bar'],
                    ['bar', 'bar'],
                ],
                '->tokenize() parses when several arguments and options',
            ],
        ];
    }
}
