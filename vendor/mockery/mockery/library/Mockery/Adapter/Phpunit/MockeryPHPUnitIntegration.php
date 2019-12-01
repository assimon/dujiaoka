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

use Mockery;

if (class_exists('PHPUnit_Framework_TestCase') || version_compare(\PHPUnit\Runner\Version::id(), '8.0.0', '<')) {
    class_alias(MockeryPHPUnitIntegrationAssertPostConditionsForV7AndPrevious::class, MockeryPHPUnitIntegrationAssertPostConditions::class);
} else {
    class_alias(MockeryPHPUnitIntegrationAssertPostConditionsForV8::class, MockeryPHPUnitIntegrationAssertPostConditions::class);
}

/**
 * Integrates Mockery into PHPUnit. Ensures Mockery expectations are verified
 * for each test and are included by the assertion counter.
 */
trait MockeryPHPUnitIntegration
{
    use MockeryPHPUnitIntegrationAssertPostConditions;

    protected $mockeryOpen;

    /**
     * Performs assertions shared by all tests of a test case. This method is
     * called before execution of a test ends and before the tearDown method.
     */
    protected function mockeryAssertPostConditions()
    {
        $this->addMockeryExpectationsToAssertionCount();
        $this->checkMockeryExceptions();
        $this->closeMockery();

        parent::assertPostConditions();
    }

    protected function addMockeryExpectationsToAssertionCount()
    {
        $this->addToAssertionCount(Mockery::getContainer()->mockery_getExpectationCount());
    }

    protected function checkMockeryExceptions()
    {
        if (!method_exists($this, "markAsRisky")) {
            return;
        }

        foreach (Mockery::getContainer()->mockery_thrownExceptions() as $e) {
            if (!$e->dismissed()) {
                $this->markAsRisky();
            }
        }
    }

    protected function closeMockery()
    {
        Mockery::close();
        $this->mockeryOpen = false;
    }

    /**
     * @before
     */
    protected function startMockery()
    {
        $this->mockeryOpen = true;
    }

    /**
     * @after
     */
    protected function purgeMockeryContainer()
    {
        if ($this->mockeryOpen) {
            // post conditions wasn't called, so test probably failed
            Mockery::close();
        }
    }
}
