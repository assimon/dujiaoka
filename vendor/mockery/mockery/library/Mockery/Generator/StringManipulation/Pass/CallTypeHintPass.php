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

class CallTypeHintPass implements Pass
{
    public function apply($code, MockConfiguration $config)
    {
        if ($config->requiresCallTypeHintRemoval()) {
            $code = str_replace(
                'public function __call($method, array $args)',
                'public function __call($method, $args)',
                $code
            );
        }

        if ($config->requiresCallStaticTypeHintRemoval()) {
            $code = str_replace(
                'public static function __callStatic($method, array $args)',
                'public static function __callStatic($method, $args)',
                $code
            );
        }

        return $code;
    }
}
