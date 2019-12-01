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

abstract class MatcherAbstract
{
    /**
     * The expected value (or part thereof)
     *
     * @var mixed
     */
    protected $_expected = null;

    /**
     * Set the expected value
     *
     * @param mixed $expected
     */
    public function __construct($expected = null)
    {
        $this->_expected = $expected;
    }

    /**
     * Check if the actual value matches the expected.
     * Actual passed by reference to preserve reference trail (where applicable)
     * back to the original method parameter.
     *
     * @param mixed $actual
     * @return bool
     */
    abstract public function match(&$actual);

    /**
     * Return a string representation of this Matcher
     *
     * @return string
     */
    abstract public function __toString();
}
