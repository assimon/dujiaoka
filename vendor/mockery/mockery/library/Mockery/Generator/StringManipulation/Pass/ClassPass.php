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

class ClassPass implements Pass
{
    public function apply($code, MockConfiguration $config)
    {
        $target = $config->getTargetClass();

        if (!$target) {
            return $code;
        }

        if ($target->isFinal()) {
            return $code;
        }

        $className = ltrim($target->getName(), "\\");
        if (defined('HHVM_VERSION') && preg_match('/^HH\\\\/', $className)) {
            // HH\ namespace is reserved for HHVM class and doesnt require
            // class declaration and extension.
            return $code;
        }

        if (!class_exists($className)) {
            \Mockery::declareClass($className);
        }

        $code = str_replace(
            "implements MockInterface",
            "extends \\" . $className . " implements MockInterface",
            $code
        );

        return $code;
    }
}
