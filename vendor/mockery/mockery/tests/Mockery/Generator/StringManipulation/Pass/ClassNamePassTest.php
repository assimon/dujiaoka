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

class ClassNamePassTest extends MockeryTestCase
{
    const CODE = "namespace Mockery; class Mock {}";

    public function mockeryTestSetUp()
    {
        $this->pass = new ClassNamePass();
    }

    /**
     * @test
     */
    public function shouldRemoveNamespaceDefinition()
    {
        $config = new MockConfiguration(array(), array(), array(), "Dave\Dave");
        $code = $this->pass->apply(static::CODE, $config);
        $this->assertTrue(\mb_strpos($code, 'namespace Mockery;') === false);
    }

    /**
     * @test
     */
    public function shouldReplaceNamespaceIfClassNameIsNamespaced()
    {
        $config = new MockConfiguration(array(), array(), array(), "Dave\Dave");
        $code = $this->pass->apply(static::CODE, $config);
        $this->assertTrue(\mb_strpos($code, 'namespace Mockery;') === false);
        $this->assertTrue(\mb_strpos($code, 'namespace Dave;') !== false);
    }

    /**
     * @test
     */
    public function shouldReplaceClassNameWithSpecifiedName()
    {
        $config = new MockConfiguration(array(), array(), array(), "Dave");
        $code = $this->pass->apply(static::CODE, $config);
        $this->assertTrue(\mb_strpos($code, 'class Dave') !== false);
    }

    /**
     * @test
     */
    public function shouldRemoveLeadingBackslashesFromNamespace()
    {
        $config = new MockConfiguration(array(), array(), array(), "\Dave\Dave");
        $code = $this->pass->apply(static::CODE, $config);
        $this->assertTrue(\mb_strpos($code, 'namespace Dave;') !== false);
    }
}
