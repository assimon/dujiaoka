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

namespace Mockery\CountValidator;

use Mockery;

class Exact extends CountValidatorAbstract
{
    /**
     * Validate the call count against this validator
     *
     * @param int $n
     * @return bool
     */
    public function validate($n)
    {
        if ($this->_limit !== $n) {
            $because = $this->_expectation->getExceptionMessage();

            $exception = new Mockery\Exception\InvalidCountException(
                'Method ' . (string) $this->_expectation
                . ' from ' . $this->_expectation->getMock()->mockery_getName()
                . ' should be called' . PHP_EOL
                . ' exactly ' . $this->_limit . ' times but called ' . $n
                . ' times.'
                . ($because ? ' Because ' . $this->_expectation->getExceptionMessage() : '')
            );
            $exception->setMock($this->_expectation->getMock())
                ->setMethodName((string) $this->_expectation)
                ->setExpectedCountComparative('=')
                ->setExpectedCount($this->_limit)
                ->setActualCount($n);
            throw $exception;
        }
    }
}
