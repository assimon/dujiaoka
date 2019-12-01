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

namespace Mockery\Generator\StringManipulation\Pass;

use Mockery\Generator\MockConfiguration;

/**
 * Internal classes can not be instantiated with the newInstanceWithoutArgs
 * reflection method, so need the serialization hack. If the class also
 * implements Serializable, we need to replace the standard unserialize method
 * definition with a dummy
 */
class RemoveUnserializeForInternalSerializableClassesPass
{
    const DUMMY_METHOD_DEFINITION = 'public function unserialize($string) {} ';

    public function apply($code, MockConfiguration $config)
    {
        $target = $config->getTargetClass();

        if (!$target) {
            return $code;
        }

        if (!$target->hasInternalAncestor() || !$target->implementsInterface("Serializable")) {
            return $code;
        }

        $code = $this->appendToClass($code, self::DUMMY_METHOD_DEFINITION);

        return $code;
    }

    protected function appendToClass($class, $code)
    {
        $lastBrace = strrpos($class, "}");
        $class = substr($class, 0, $lastBrace) . $code . "\n    }\n";
        return $class;
    }
}
