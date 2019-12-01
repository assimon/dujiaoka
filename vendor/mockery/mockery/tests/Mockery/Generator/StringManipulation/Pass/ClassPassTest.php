<?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

namespace Mockery\Generator\StringManipulation\Pass;

use Mockery\Adapter\Phpunit\MockeryTestCase;
use Mockery\Generator\MockConfiguration;

class ClassPassTest extends MockeryTestCase
{
    const CODE = "class Mock implements MockInterface {}";

    public function mockeryTestSetUp()
    {
        $this->pass = new ClassPass();
    }

    /**
     * @test
     */
    public function shouldDeclareUnknownClass()
    {
        $config = new MockConfiguration(array("Testing\TestClass"), array(), array(), "Dave\Dave");
        $code = $this->pass->apply(static::CODE, $config);
        $this->assertTrue(\mb_strpos($code, 'class Mock extends \Testing\TestClass implements MockInterface') !== false);
    }

    /**
     * @test
     */
    public function shouldNotExtendHHVMClass()
    {
        $config = new MockConfiguration(array("\HH\\this"), array(), array(), "Dave\Dave");
        $code = $this->pass->apply(static::CODE, $config);
        if (\defined('HHVM_VERSION')) {
            $this->assertNotContains('extends \HH\this', $code);
        } else {
            $this->assertSame('class Mock extends \HH\this implements MockInterface {}', $code);
        }
    }
}
