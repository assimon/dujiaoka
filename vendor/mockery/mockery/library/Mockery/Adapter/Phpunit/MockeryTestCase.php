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
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

namespace Mockery\Adapter\Phpunit;

if (class_exists('PHPUnit_Framework_TestCase') || version_compare(\PHPUnit\Runner\Version::id(), '8.0.0', '<')) {
    class_alias(MockeryTestCaseSetUpForV7AndPrevious::class, MockeryTestCaseSetUp::class);
} else {
    class_alias(MockeryTestCaseSetUpForV8::class, MockeryTestCaseSetUp::class);
}
abstract class MockeryTestCase extends \PHPUnit\Framework\TestCase
{
    use MockeryPHPUnitIntegration, MockeryTestCaseSetUp;

    protected function mockeryTestSetUp()
    {
    }

    protected function mockeryTestTearDown()
    {
    }
}
