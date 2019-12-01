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
 * @category  Mockery
 * @package   Mockery
 * @copyright Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license   http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

namespace Mockery\Adapter\Phpunit\Legacy;

if (class_exists('PHPUnit_Framework_TestCase') && ! class_exists('PHPUnit\Util\Blacklist')) {
    class_alias('PHPUnit_Framework_ExpectationFailedException', 'PHPUnit\Framework\ExpectationFailedException');
    class_alias('PHPUnit_Framework_Test', 'PHPUnit\Framework\Test');
    class_alias('PHPUnit_Framework_TestCase', 'PHPUnit\Framework\TestCase');
    class_alias('PHPUnit_Util_Blacklist', 'PHPUnit\Util\Blacklist');
    class_alias('PHPUnit_Runner_BaseTestRunner', 'PHPUnit\Runner\BaseTestRunner');
}

use PHPUnit\Framework\ExpectationFailedException;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestCase;
use PHPUnit\Util\Blacklist;
use PHPUnit\Runner\BaseTestRunner;

class TestListenerTrait
{
    /**
     * endTest is called after each test and checks if \Mockery::close() has
     * been called, and will let the test fail if it hasn't.
     *
     * @param Test  $test
     * @param float $time
     */
    public function endTest(Test $test, $time)
    {
        if (!$test instanceof TestCase) {
            // We need the getTestResultObject and getStatus methods which are
            // not part of the interface.
            return;
        }

        if ($test->getStatus() !== BaseTestRunner::STATUS_PASSED) {
            // If the test didn't pass there is no guarantee that
            // verifyMockObjects and assertPostConditions have been called.
            // And even if it did, the point here is to prevent false
            // negatives, not to make failing tests fail for more reasons.
            return;
        }

        try {
            // The self() call is used as a sentinel. Anything that throws if
            // the container is closed already will do.
            \Mockery::self();
        } catch (\LogicException $_) {
            return;
        }

        $e = new ExpectationFailedException(
            \sprintf(
                "Mockery's expectations have not been verified. Make sure that \Mockery::close() is called at the end of the test. Consider using %s\MockeryPHPUnitIntegration or extending %s\MockeryTestCase.",
                __NAMESPACE__,
                __NAMESPACE__
            )
        );

        /** @var \PHPUnit\Framework\TestResult $result */
        $result = $test->getTestResultObject();

        if ($result !== null) {
            $result->addFailure($test, $e, $time);
        }
    }

    public function startTestSuite()
    {
        Blacklist::$blacklistedClassNames[\Mockery::class] = 1;
    }
}
