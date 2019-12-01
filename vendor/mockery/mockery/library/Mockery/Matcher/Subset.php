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

namespace Mockery\Matcher;

class Subset extends MatcherAbstract
{
    private $expected;
    private $strict = true;

    /**
     * @param array $expected Expected subset of data
     * @param bool $strict Whether to run a strict or loose comparison
     */
    public function __construct(array $expected, $strict = true)
    {
        $this->expected = $expected;
        $this->strict = $strict;
    }

    /**
     * @param array $expected Expected subset of data
     *
     * @return Subset
     */
    public static function strict(array $expected)
    {
        return new static($expected, true);
    }

    /**
     * @param array $expected Expected subset of data
     *
     * @return Subset
     */
    public static function loose(array $expected)
    {
        return new static($expected, false);
    }

    /**
     * Check if the actual value matches the expected.
     *
     * @param mixed $actual
     * @return bool
     */
    public function match(&$actual)
    {
        if (!is_array($actual)) {
            return false;
        }

        if ($this->strict) {
            return $actual === array_replace_recursive($actual, $this->expected);
        }

        return $actual == array_replace_recursive($actual, $this->expected);
    }

    /**
     * Return a string representation of this Matcher
     *
     * @return string
     */
    public function __toString()
    {
        $return = '<Subset[';
        $elements = array();
        foreach ($this->expected as $k=>$v) {
            $elements[] = $k . '=' . (string) $v;
        }
        $return .= implode(', ', $elements) . ']>';
        return $return;
    }
}
