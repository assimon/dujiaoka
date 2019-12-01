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
 * @copyright  Copyright (c) 2017 Dave Marshall https://github.com/davedevelopment
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

namespace test\Mockery;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\Exception\InvalidCountException;

class CallableSpyTest extends MockeryTestCase
{
    /** @test */
    public function it_verifies_the_closure_was_called()
    {
        $spy = spy(function() {});

        $spy();

        $spy->shouldHaveBeenCalled();
    }

    /** @test */
    public function it_throws_if_the_callable_was_not_called_at_all()
    {
        $spy = spy(function() {});

        $this->expectException(InvalidCountException::class);
        $spy->shouldHaveBeenCalled();
    }

    /** @test */
    public function it_throws_if_there_were_no_arguments_but_we_expected_some()
    {
        $spy = spy(function() {});

        $spy();

        $this->expectException(InvalidCountException::class);
        $spy->shouldHaveBeenCalled()->with(123, 546);
    }

    /** @test */
    public function it_throws_if_the_arguments_do_not_match()
    {
        $spy = spy(function() {});

        $spy(123);

        $this->expectException(InvalidCountException::class);
        $spy->shouldHaveBeenCalled()->with(123, 546);
    }

    /** @test */
    public function it_verifies_the_closure_was_not_called()
    {
        $spy = spy(function () {});

        $spy->shouldNotHaveBeenCalled();
    }

    /** @test */
    public function it_throws_if_it_was_called_when_we_expected_it_to_not_have_been_called()
    {
        $spy = spy(function () {});

        $spy();

        $this->expectException(InvalidCountException::class);
        $spy->shouldNotHaveBeenCalled();
    }

    /** @test */
    public function it_verifies_it_was_not_called_with_some_particular_arguments_when_called_with_no_args()
    {
        $spy = spy(function () {});

        $spy();

        $spy->shouldNotHaveBeenCalled([123]);
    }

    /** @test */
    public function it_verifies_it_was_not_called_with_some_particular_arguments_when_called_with_different_args()
    {
        $spy = spy(function () {});

        $spy(456);

        $spy->shouldNotHaveBeenCalled([123]);
    }

    /** @test */
    public function it_throws_if_it_was_called_with_the_args_we_were_not_expecting()
    {
        $spy = spy(function () {});

        $spy(123);

        $this->expectException(InvalidCountException::class);
        $spy->shouldNotHaveBeenCalled([123]);
    }

    /** @test */
    public function it_can_verify_it_was_called_a_number_of_times()
    {
        $spy = spy(function () {});

        $spy();
        $spy();

        $spy->shouldHaveBeenCalled()->twice();
    }

    /** @test */
    public function it_can_verify_it_was_called_a_number_of_times_with_particular_arguments()
    {
        $spy = spy(function () {});

        $spy(123);
        $spy(123);

        $spy->shouldHaveBeenCalled()->with(123)->twice();
    }

    /** @test */
    public function it_throws_if_it_was_called_less_than_the_number_of_times_we_expected()
    {
        $spy = spy(function () {});

        $spy();

        $this->expectException(InvalidCountException::class);
        $spy->shouldHaveBeenCalled()->twice();
    }

    /** @test */
    public function it_throws_if_it_was_called_less_than_the_number_of_times_we_expected_with_particular_arguments()
    {
        $spy = spy(function () {});

        $spy();
        $spy(123);

        $this->expectException(InvalidCountException::class);
        $spy->shouldHaveBeenCalled()->with(123)->twice();
    }

    /** @test */
    public function it_throws_if_it_was_called_more_than_the_number_of_times_we_expected()
    {
        $spy = spy(function () {});

        $spy();
        $spy();
        $spy();

        $this->expectException(InvalidCountException::class);
        $spy->shouldHaveBeenCalled()->twice();
    }

    /** @test */
    public function it_throws_if_it_was_called_more_than_the_number_of_times_we_expected_with_particular_arguments()
    {
        $spy = spy(function () {});

        $spy(123);
        $spy(123);
        $spy(123);

        $this->expectException(InvalidCountException::class);
        $spy->shouldHaveBeenCalled()->with(123)->twice();
    }

    /** @test */
    public function it_acts_as_partial()
    {
        $spy = spy(function ($number) { return $number + 1;});

        $this->assertEquals(124, $spy(123));
        $spy->shouldHaveBeenCalled();
    }
}
