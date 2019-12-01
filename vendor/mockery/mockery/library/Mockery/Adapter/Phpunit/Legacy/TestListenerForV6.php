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

use PHPUnit\Framework\BaseTestListener;
use PHPUnit\Framework\Test;
use PHPUnit\Framework\TestSuite;

class TestListenerForV6 extends BaseTestListener
{
    private $trait;

    public function __construct()
    {
        $this->trait = new TestListenerTrait();
    }

    /**
     * {@inheritdoc}
     */
    public function endTest(Test $test, $time)
    {
        $this->trait->endTest($test, $time);
    }

    /**
     * {@inheritdoc}
     */
    public function startTestSuite(TestSuite $suite)
    {
        $this->trait->startTestSuite();
    }
}
