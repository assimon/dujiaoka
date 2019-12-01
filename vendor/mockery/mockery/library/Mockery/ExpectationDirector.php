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

namespace Mockery;

class ExpectationDirector
{
    /**
     * Method name the director is directing
     *
     * @var string
     */
    protected $_name = null;

    /**
     * Mock object the director is attached to
     *
     * @var \Mockery\MockInterface|\Mockery\LegacyMockInterface
     */
    protected $_mock = null;

    /**
     * Stores an array of all expectations for this mock
     *
     * @var array
     */
    protected $_expectations = array();

    /**
     * The expected order of next call
     *
     * @var int
     */
    protected $_expectedOrder = null;

    /**
     * Stores an array of all default expectations for this mock
     *
     * @var array
     */
    protected $_defaults = array();

    /**
     * Constructor
     *
     * @param string $name
     * @param \Mockery\LegacyMockInterface $mock
     */
    public function __construct($name, \Mockery\LegacyMockInterface $mock)
    {
        $this->_name = $name;
        $this->_mock = $mock;
    }

    /**
     * Add a new expectation to the director
     *
     * @param \Mockery\Expectation $expectation
     */
    public function addExpectation(\Mockery\Expectation $expectation)
    {
        $this->_expectations[] = $expectation;
    }

    /**
     * Handle a method call being directed by this instance
     *
     * @param array $args
     * @return mixed
     */
    public function call(array $args)
    {
        $expectation = $this->findExpectation($args);
        if (is_null($expectation)) {
            throw new \Mockery\Exception\NoMatchingExpectationException(
                $this->_mock,
                $this->_name,
                $args,
                $this->getExpectations()
            );
        }
        return $expectation->verifyCall($args);
    }

    /**
     * Verify all expectations of the director
     *
     * @throws \Mockery\CountValidator\Exception
     * @return void
     */
    public function verify()
    {
        if (!empty($this->_expectations)) {
            foreach ($this->_expectations as $exp) {
                $exp->verify();
            }
        } else {
            foreach ($this->_defaults as $exp) {
                $exp->verify();
            }
        }
    }

    /**
     * Attempt to locate an expectation matching the provided args
     *
     * @param array $args
     * @return mixed
     */
    public function findExpectation(array $args)
    {
        $expectation = null;

        if (!empty($this->_expectations)) {
            $expectation = $this->_findExpectationIn($this->_expectations, $args);
        }

        if ($expectation === null && !empty($this->_defaults)) {
            $expectation = $this->_findExpectationIn($this->_defaults, $args);
        }

        return $expectation;
    }

    /**
     * Make the given expectation a default for all others assuming it was
     * correctly created last
     *
     * @param \Mockery\Expectation $expectation
     */
    public function makeExpectationDefault(\Mockery\Expectation $expectation)
    {
        $last = end($this->_expectations);
        if ($last === $expectation) {
            array_pop($this->_expectations);
            array_unshift($this->_defaults, $expectation);
        } else {
            throw new \Mockery\Exception(
                'Cannot turn a previously defined expectation into a default'
            );
        }
    }

    /**
     * Search current array of expectations for a match
     *
     * @param array $expectations
     * @param array $args
     * @return mixed
     */
    protected function _findExpectationIn(array $expectations, array $args)
    {
        foreach ($expectations as $exp) {
            if ($exp->isEligible() && $exp->matchArgs($args)) {
                return $exp;
            }
        }
        foreach ($expectations as $exp) {
            if ($exp->matchArgs($args)) {
                return $exp;
            }
        }
    }

    /**
     * Return all expectations assigned to this director
     *
     * @return array
     */
    public function getExpectations()
    {
        return $this->_expectations;
    }

    /**
     * Return all expectations assigned to this director
     *
     * @return array
     */
    public function getDefaultExpectations()
    {
        return $this->_defaults;
    }

    /**
     * Return the number of expectations assigned to this director.
     *
     * @return int
     */
    public function getExpectationCount()
    {
        return count($this->getExpectations()) ?: count($this->getDefaultExpectations());
    }
}
