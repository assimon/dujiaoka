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

namespace Mockery\Exception;

use Hamcrest\Util;
use Mockery;
use SebastianBergmann\Comparator\ComparisonFailure;
use SebastianBergmann\Comparator\Factory;

class NoMatchingExpectationException extends Mockery\Exception
{
    /**
     * @var string
     */
    protected $method;

    /**
     * @var array
     */
    protected $actual;

    /**
     * @var Mockery\MockInterface
     */
    protected $mockObject;

    /**
     * @param string $methodName
     * @param array $actualArguments
     * @param array $expectations
     */
    public function __construct(
        Mockery\MockInterface $mock,
        $methodName,
        $actualArguments,
        $expectations
    ) {
        $this->setMock($mock);
        $this->setMethodName($methodName);
        $this->setActualArguments($actualArguments);

        $diffs = [];
        foreach ($expectations as $expectation) {
            $expectedArguments = $expectation->getExpectedArgs();

            $diff = $this->diff(
                $this->normalizeForDiff($expectedArguments),
                $this->normalizeForDiff($actualArguments)
            );
            if (null === $diff) {
                // If we reach this, it means that the exception has not been
                // raised by a non-strict equality. So the diff is null.
                // We do the comparison again but this time comparing references
                // of objects.
                $diff = $this->diff(
                    $this->normalizeForStrictDiff($expectedArguments),
                    $this->normalizeForStrictDiff($actualArguments)
                );
            }

            $diffs[] = sprintf(
                "\n%s::%s with arguments%s",
                $expectation->getMock()->mockery_getName(),
                $expectation->getName(),
                null !== $diff ? $diff : "\n### No diff ###"
            );
        }

        $message = 'No matching expectation found for '
            . $this->getMockName() . '::'
            . \Mockery::formatArgs($methodName, $actualArguments)
            . '. Either the method was unexpected or its arguments matched'
            . ' no expected argument list for this method.'
            . PHP_EOL . PHP_EOL
            . 'Here is the list of available expectations and their diff with actual input:'
            . PHP_EOL
            . implode('', $diffs);

        parent::__construct($message, 0, null);
    }

    /**
     * @return $this
     */
    private function setMock(Mockery\MockInterface $mock)
    {
        $this->mockObject = $mock;
        return $this;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    private function setMethodName($name)
    {
        $this->method = $name;
        return $this;
    }

    /**
     * @param array $count
     *
     * @return $this
     */
    private function setActualArguments($count)
    {
        $this->actual = $count;
        return $this;
    }

    /**
     * @return Mockery\MockInterface
     */
    private function getMock()
    {
        return $this->mockObject;
    }

    /**
     * @return string
     */
    private function getMockName()
    {
        return $this->getMock()->mockery_getName();
    }

    /**
     * @param array $expectedArguments
     * @param array $actualArguments
     *
     * @return string|null
     */
    private function diff($expectedArguments, $actualArguments)
    {
        $comparatorFactory = new Factory();
        $comparator = $comparatorFactory->getComparatorFor(
            $expectedArguments,
            $actualArguments
        );
        try {
            $comparator->assertEquals($expectedArguments, $actualArguments);
        } catch (ComparisonFailure $e) {
            return $e->getDiff();
        }

        return null;
    }

    /**
     * @param array $args
     *
     * @return array
     */
    private function normalizeForDiff($args)
    {
        // Wraps items with an IsEqual matcher if it isn't a matcher already
        // in order to be sure to compare same nature objects.
        return Util::createMatcherArray($args);
    }

    /**
     * @param array $args
     *
     * @return array
     */
    private function normalizeForStrictDiff($args)
    {
        $normalized = [];
        foreach ($args as $arg) {
            if (!is_object($arg)) {
                $normalizedArg = Util::createMatcherArray([$arg]);
                $normalized[] = reset($normalizedArg);
                continue;
            }

            $objectRef = function_exists('spl_object_id')
                ? spl_object_id($arg)
                : spl_object_hash($arg);

            $normalized[] = get_class($arg).'#ref_'.$objectRef;
        }

        return $normalized;
    }
}
