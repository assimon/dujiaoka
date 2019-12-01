<?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/blob/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @copyright  Copyright (c) 2017 Dave Marshall
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

namespace tests\Mockery\Matcher;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\Matcher\Subset;

class SubsetTest extends MockeryTestCase
{
    /** @test */
    public function it_matches_a_shallow_subset()
    {
        $matcher = Subset::strict(['dave' => 123]);

        $actual = [
            'foo' => 'bar',
            'dave' => 123,
            'bar' => 'baz',
        ];

        $this->assertTrue($matcher->match($actual));
    }

    /** @test */
    public function it_recursively_matches()
    {
        $matcher = Subset::strict(['foo' => ['bar' => ['baz' => 123]]]);

        $actual = [
            'foo' => [
                'bar' => [
                    'baz' => 123,
                ]
            ],
            'dave' => 123,
            'bar' => 'baz',
        ];

        $this->assertTrue($matcher->match($actual));
    }

    /** @test */
    public function it_is_strict_by_default()
    {
        $matcher = new Subset(['dave' => 123]);

        $actual = [
            'foo' => 'bar',
            'dave' => 123.0,
            'bar' => 'baz',
        ];

        $this->assertFalse($matcher->match($actual));
    }

    /** @test */
    public function it_can_run_a_loose_comparison()
    {
        $matcher = Subset::loose(['dave' => 123]);

        $actual = [
            'foo' => 'bar',
            'dave' => 123.0,
            'bar' => 'baz',
        ];

        $this->assertTrue($matcher->match($actual));
    }

    /** @test */
    public function it_returns_false_if_actual_is_not_an_array()
    {
        $matcher = new Subset(['dave' => 123]);

        $actual = null;

        $this->assertFalse($matcher->match($actual));
    }
}
