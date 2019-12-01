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

use Mockery\HigherOrderMessage;
use Mockery\MockInterface;
use Mockery\LegacyMockInterface;
use Mockery\ExpectsHigherOrderMessage;
use Mockery\Exception\BadMethodCallException;

class Mock implements MockInterface
{
    /**
     * Stores an array of all expectation directors for this mock
     *
     * @var array
     */
    protected $_mockery_expectations = array();

    /**
     * Stores an inital number of expectations that can be manipulated
     * while using the getter method.
     *
     * @var int
     */
    protected $_mockery_expectations_count = 0;

    /**
     * Flag to indicate whether we can ignore method calls missing from our
     * expectations
     *
     * @var bool
     */
    protected $_mockery_ignoreMissing = false;

    /**
     * Flag to indicate whether we can defer method calls missing from our
     * expectations
     *
     * @var bool
     */
    protected $_mockery_deferMissing = false;

    /**
     * Flag to indicate whether this mock was verified
     *
     * @var bool
     */
    protected $_mockery_verified = false;

    /**
     * Given name of the mock
     *
     * @var string
     */
    protected $_mockery_name = null;

    /**
     * Order number of allocation
     *
     * @var int
     */
    protected $_mockery_allocatedOrder = 0;

    /**
     * Current ordered number
     *
     * @var int
     */
    protected $_mockery_currentOrder = 0;

    /**
     * Ordered groups
     *
     * @var array
     */
    protected $_mockery_groups = array();

    /**
     * Mock container containing this mock object
     *
     * @var \Mockery\Container
     */
    protected $_mockery_container = null;

    /**
     * Instance of a core object on which methods are called in the event
     * it has been set, and an expectation for one of the object's methods
     * does not exist. This implements a simple partial mock proxy system.
     *
     * @var object
     */
    protected $_mockery_partial = null;

    /**
     * Flag to indicate we should ignore all expectations temporarily. Used
     * mainly to prevent expectation matching when in the middle of a mock
     * object recording session.
     *
     * @var bool
     */
    protected $_mockery_disableExpectationMatching = false;

    /**
     * Stores all stubbed public methods separate from any on-object public
     * properties that may exist.
     *
     * @var array
     */
    protected $_mockery_mockableProperties = array();

    /**
     * @var array
     */
    protected $_mockery_mockableMethods = array();

    /**
     * Just a local cache for this mock's target's methods
     *
     * @var \ReflectionMethod[]
     */
    protected static $_mockery_methods;

    protected $_mockery_allowMockingProtectedMethods = false;

    protected $_mockery_receivedMethodCalls;

    /**
     * If shouldIgnoreMissing is called, this value will be returned on all calls to missing methods
     * @var mixed
     */
    protected $_mockery_defaultReturnValue = null;

    /**
     * Tracks internally all the bad method call exceptions that happened during runtime
     *
     * @var array
     */
    protected $_mockery_thrownExceptions = [];

    protected $_mockery_instanceMock = true;

    /**
     * We want to avoid constructors since class is copied to Generator.php
     * for inclusion on extending class definitions.
     *
     * @param \Mockery\Container $container
     * @param object $partialObject
     * @param bool $instanceMock
     * @return void
     */
    public function mockery_init(\Mockery\Container $container = null, $partialObject = null, $instanceMock = true)
    {
        if (is_null($container)) {
            $container = new \Mockery\Container;
        }
        $this->_mockery_container = $container;
        if (!is_null($partialObject)) {
            $this->_mockery_partial = $partialObject;
        }

        if (!\Mockery::getConfiguration()->mockingNonExistentMethodsAllowed()) {
            foreach ($this->mockery_getMethods() as $method) {
                if ($method->isPublic()) {
                    $this->_mockery_mockableMethods[] = $method->getName();
                }
            }
        }

        $this->_mockery_instanceMock = $instanceMock;
    }

    /**
     * Set expected method calls
     *
     * @param mixed ...$methodNames one or many methods that are expected to be called in this mock
     *
     * @return \Mockery\ExpectationInterface|\Mockery\Expectation|\Mockery\HigherOrderMessage
     */
    public function shouldReceive(...$methodNames)
    {
        if (count($methodNames) === 0) {
            return new HigherOrderMessage($this, "shouldReceive");
        }

        foreach ($methodNames as $method) {
            if ("" == $method) {
                throw new \InvalidArgumentException("Received empty method name");
            }
        }

        $self = $this;
        $allowMockingProtectedMethods = $this->_mockery_allowMockingProtectedMethods;

        $lastExpectation = \Mockery::parseShouldReturnArgs(
            $this, $methodNames, function ($method) use ($self, $allowMockingProtectedMethods) {
                $rm = $self->mockery_getMethod($method);
                if ($rm) {
                    if ($rm->isPrivate()) {
                        throw new \InvalidArgumentException("$method() cannot be mocked as it is a private method");
                    }
                    if (!$allowMockingProtectedMethods && $rm->isProtected()) {
                        throw new \InvalidArgumentException("$method() cannot be mocked as it is a protected method and mocking protected methods is not enabled for the currently used mock object. Use shouldAllowMockingProtectedMethods() to enable mocking of protected methods.");
                    }
                }

                $director = $self->mockery_getExpectationsFor($method);
                if (!$director) {
                    $director = new \Mockery\ExpectationDirector($method, $self);
                    $self->mockery_setExpectationsFor($method, $director);
                }
                $expectation = new \Mockery\Expectation($self, $method);
                $director->addExpectation($expectation);
                return $expectation;
            }
        );
        return $lastExpectation;
    }

    // start method allows
    /**
     * @param mixed $something  String method name or map of method => return
     * @return self|\Mockery\ExpectationInterface|\Mockery\Expectation|\Mockery\HigherOrderMessage
     */
    public function allows($something = [])
    {
        if (is_string($something)) {
            return $this->shouldReceive($something);
        }

        if (empty($something)) {
            return $this->shouldReceive();
        }

        foreach ($something as $method => $returnValue) {
            $this->shouldReceive($method)->andReturn($returnValue);
        }

        return $this;
    }
    // end method allows

    // start method expects
    /**
    /**
     * @param mixed $something  String method name (optional)
     * @return \Mockery\ExpectationInterface|\Mockery\Expectation|ExpectsHigherOrderMessage
     */
    public function expects($something = null)
    {
        if (is_string($something)) {
            return $this->shouldReceive($something)->once();
        }

        return new ExpectsHigherOrderMessage($this);
    }
    // end method expects

    /**
     * Shortcut method for setting an expectation that a method should not be called.
     *
     * @param array ...$methodNames one or many methods that are expected not to be called in this mock
     * @return \Mockery\ExpectationInterface|\Mockery\Expectation|\Mockery\HigherOrderMessage
     */
    public function shouldNotReceive(...$methodNames)
    {
        if (count($methodNames) === 0) {
            return new HigherOrderMessage($this, "shouldNotReceive");
        }

        $expectation = call_user_func_array(array($this, 'shouldReceive'), $methodNames);
        $expectation->never();
        return $expectation;
    }

    /**
     * Allows additional methods to be mocked that do not explicitly exist on mocked class
     * @param String $method name of the method to be mocked
     * @return Mock
     */
    public function shouldAllowMockingMethod($method)
    {
        $this->_mockery_mockableMethods[] = $method;
        return $this;
    }

    /**
     * Set mock to ignore unexpected methods and return Undefined class
     * @param mixed $returnValue the default return value for calls to missing functions on this mock
     * @return Mock
     */
    public function shouldIgnoreMissing($returnValue = null)
    {
        $this->_mockery_ignoreMissing = true;
        $this->_mockery_defaultReturnValue = $returnValue;
        return $this;
    }

    public function asUndefined()
    {
        $this->_mockery_ignoreMissing = true;
        $this->_mockery_defaultReturnValue = new \Mockery\Undefined;
        return $this;
    }

    /**
     * @return Mock
     */
    public function shouldAllowMockingProtectedMethods()
    {
        if (!\Mockery::getConfiguration()->mockingNonExistentMethodsAllowed()) {
            foreach ($this->mockery_getMethods() as $method) {
                if ($method->isProtected()) {
                    $this->_mockery_mockableMethods[] = $method->getName();
                }
            }
        }

        $this->_mockery_allowMockingProtectedMethods = true;
        return $this;
    }


    /**
     * Set mock to defer unexpected methods to it's parent
     *
     * This is particularly useless for this class, as it doesn't have a parent,
     * but included for completeness
     *
     * @deprecated 2.0.0 Please use makePartial() instead
     *
     * @return Mock
     */
    public function shouldDeferMissing()
    {
        return $this->makePartial();
    }

    /**
     * Set mock to defer unexpected methods to it's parent
     *
     * It was an alias for shouldDeferMissing(), which will be removed
     * in 2.0.0.
     *
     * @return Mock
     */
    public function makePartial()
    {
        $this->_mockery_deferMissing = true;
        return $this;
    }

    /**
     * In the event shouldReceive() accepting one or more methods/returns,
     * this method will switch them from normal expectations to default
     * expectations
     *
     * @return self
     */
    public function byDefault()
    {
        foreach ($this->_mockery_expectations as $director) {
            $exps = $director->getExpectations();
            foreach ($exps as $exp) {
                $exp->byDefault();
            }
        }
        return $this;
    }

    /**
     * Capture calls to this mock
     */
    public function __call($method, array $args)
    {
        return $this->_mockery_handleMethodCall($method, $args);
    }

    public static function __callStatic($method, array $args)
    {
        return self::_mockery_handleStaticMethodCall($method, $args);
    }

    /**
     * Forward calls to this magic method to the __call method
     */
    public function __toString()
    {
        return $this->__call('__toString', array());
    }

    /**
     * Iterate across all expectation directors and validate each
     *
     * @throws \Mockery\CountValidator\Exception
     * @return void
     */
    public function mockery_verify()
    {
        if ($this->_mockery_verified) {
            return;
        }
        if (isset($this->_mockery_ignoreVerification)
            && $this->_mockery_ignoreVerification == true) {
            return;
        }
        $this->_mockery_verified = true;
        foreach ($this->_mockery_expectations as $director) {
            $director->verify();
        }
    }

    /**
     * Gets a list of exceptions thrown by this mock
     *
     * @return array
     */
    public function mockery_thrownExceptions()
    {
        return $this->_mockery_thrownExceptions;
    }

    /**
     * Tear down tasks for this mock
     *
     * @return void
     */
    public function mockery_teardown()
    {
    }

    /**
     * Fetch the next available allocation order number
     *
     * @return int
     */
    public function mockery_allocateOrder()
    {
        $this->_mockery_allocatedOrder += 1;
        return $this->_mockery_allocatedOrder;
    }

    /**
     * Set ordering for a group
     *
     * @param mixed $group
     * @param int $order
     */
    public function mockery_setGroup($group, $order)
    {
        $this->_mockery_groups[$group] = $order;
    }

    /**
     * Fetch array of ordered groups
     *
     * @return array
     */
    public function mockery_getGroups()
    {
        return $this->_mockery_groups;
    }

    /**
     * Set current ordered number
     *
     * @param int $order
     */
    public function mockery_setCurrentOrder($order)
    {
        $this->_mockery_currentOrder = $order;
        return $this->_mockery_currentOrder;
    }

    /**
     * Get current ordered number
     *
     * @return int
     */
    public function mockery_getCurrentOrder()
    {
        return $this->_mockery_currentOrder;
    }

    /**
     * Validate the current mock's ordering
     *
     * @param string $method
     * @param int $order
     * @throws \Mockery\Exception
     * @return void
     */
    public function mockery_validateOrder($method, $order)
    {
        if ($order < $this->_mockery_currentOrder) {
            $exception = new \Mockery\Exception\InvalidOrderException(
                'Method ' . __CLASS__ . '::' . $method . '()'
                . ' called out of order: expected order '
                . $order . ', was ' . $this->_mockery_currentOrder
            );
            $exception->setMock($this)
                ->setMethodName($method)
                ->setExpectedOrder($order)
                ->setActualOrder($this->_mockery_currentOrder);
            throw $exception;
        }
        $this->mockery_setCurrentOrder($order);
    }

    /**
     * Gets the count of expectations for this mock
     *
     * @return int
     */
    public function mockery_getExpectationCount()
    {
        $count = $this->_mockery_expectations_count;
        foreach ($this->_mockery_expectations as $director) {
            $count += $director->getExpectationCount();
        }
        return $count;
    }

    /**
     * Return the expectations director for the given method
     *
     * @var string $method
     * @return \Mockery\ExpectationDirector|null
     */
    public function mockery_setExpectationsFor($method, \Mockery\ExpectationDirector $director)
    {
        $this->_mockery_expectations[$method] = $director;
    }

    /**
     * Return the expectations director for the given method
     *
     * @var string $method
     * @return \Mockery\ExpectationDirector|null
     */
    public function mockery_getExpectationsFor($method)
    {
        if (isset($this->_mockery_expectations[$method])) {
            return $this->_mockery_expectations[$method];
        }
    }

    /**
     * Find an expectation matching the given method and arguments
     *
     * @var string $method
     * @var array $args
     * @return \Mockery\Expectation|null
     */
    public function mockery_findExpectation($method, array $args)
    {
        if (!isset($this->_mockery_expectations[$method])) {
            return null;
        }
        $director = $this->_mockery_expectations[$method];

        return $director->findExpectation($args);
    }

    /**
     * Return the container for this mock
     *
     * @return \Mockery\Container
     */
    public function mockery_getContainer()
    {
        return $this->_mockery_container;
    }

    /**
     * Return the name for this mock
     *
     * @return string
     */
    public function mockery_getName()
    {
        return __CLASS__;
    }

    /**
     * @return array
     */
    public function mockery_getMockableProperties()
    {
        return $this->_mockery_mockableProperties;
    }

    public function __isset($name)
    {
        if (false === stripos($name, '_mockery_') && method_exists(get_parent_class($this), '__isset')) {
            return call_user_func('parent::__isset', $name);
        }

        return false;
    }

    public function mockery_getExpectations()
    {
        return $this->_mockery_expectations;
    }

    /**
     * Calls a parent class method and returns the result. Used in a passthru
     * expectation where a real return value is required while still taking
     * advantage of expectation matching and call count verification.
     *
     * @param string $name
     * @param array $args
     * @return mixed
     */
    public function mockery_callSubjectMethod($name, array $args)
    {
        if (!method_exists($this, $name) && method_exists(get_parent_class($this), '__call')) {
            return call_user_func('parent::__call', $name, $args);
        }
        return call_user_func_array('parent::' . $name, $args);
    }

    /**
     * @return string[]
     */
    public function mockery_getMockableMethods()
    {
        return $this->_mockery_mockableMethods;
    }

    /**
     * @return bool
     */
    public function mockery_isAnonymous()
    {
        $rfc = new \ReflectionClass($this);

        // HHVM has a Stringish interface
        $interfaces = array_filter($rfc->getInterfaces(), function ($i) {
            return $i->getName() !== "Stringish";
        });
        $onlyImplementsMock = 2 == count($interfaces);

        return (false === $rfc->getParentClass()) && $onlyImplementsMock;
    }

    public function mockery_isInstance()
    {
        return $this->_mockery_instanceMock;
    }

    public function __wakeup()
    {
        /**
         * This does not add __wakeup method support. It's a blind method and any
         * expected __wakeup work will NOT be performed. It merely cuts off
         * annoying errors where a __wakeup exists but is not essential when
         * mocking
         */
    }

    public function __destruct()
    {
        /**
         * Overrides real class destructor in case if class was created without original constructor
         */
    }

    public function mockery_getMethod($name)
    {
        foreach ($this->mockery_getMethods() as $method) {
            if ($method->getName() == $name) {
                return $method;
            }
        }

        return null;
    }

    /**
     * @param string $name Method name.
     *
     * @return mixed Generated return value based on the declared return value of the named method.
     */
    public function mockery_returnValueForMethod($name)
    {
        if (version_compare(PHP_VERSION, '7.0.0-dev') < 0) {
            return;
        }

        $rm = $this->mockery_getMethod($name);
        if (!$rm || !$rm->hasReturnType()) {
            return;
        }

        $returnType = $rm->getReturnType();

        // Default return value for methods with nullable type is null
        if ($returnType->allowsNull()) {
            return null;
        }

        $type = PHP_VERSION_ID >= 70100 ? $returnType->getName() : (string) $returnType;
        switch ($type) {
            case '':       return;
            case 'string': return '';
            case 'int':    return 0;
            case 'float':  return 0.0;
            case 'bool':   return false;
            case 'array':  return [];

            case 'callable':
            case 'Closure':
                return function () {
                };

            case 'Traversable':
            case 'Generator':
                // Remove eval() when minimum version >=5.5
                $generator = eval('return function () { yield; };');
                return $generator();

            case 'self':
                return \Mockery::mock($rm->getDeclaringClass()->getName());

            case 'void':
                return null;

            case 'object':
                if (version_compare(PHP_VERSION, '7.2.0-dev') >= 0) {
                    return \Mockery::mock();
                }

            default:
                return \Mockery::mock($type);
        }
    }

    public function shouldHaveReceived($method = null, $args = null)
    {
        if ($method === null) {
            return new HigherOrderMessage($this, "shouldHaveReceived");
        }

        $expectation = new \Mockery\VerificationExpectation($this, $method);
        if (null !== $args) {
            $expectation->withArgs($args);
        }
        $expectation->atLeast()->once();
        $director = new \Mockery\VerificationDirector($this->_mockery_getReceivedMethodCalls(), $expectation);
        $this->_mockery_expectations_count++;
        $director->verify();
        return $director;
    }

    public function shouldHaveBeenCalled()
    {
        return $this->shouldHaveReceived("__invoke");
    }

    public function shouldNotHaveReceived($method = null, $args = null)
    {
        if ($method === null) {
            return new HigherOrderMessage($this, "shouldNotHaveReceived");
        }

        $expectation = new \Mockery\VerificationExpectation($this, $method);
        if (null !== $args) {
            $expectation->withArgs($args);
        }
        $expectation->never();
        $director = new \Mockery\VerificationDirector($this->_mockery_getReceivedMethodCalls(), $expectation);
        $this->_mockery_expectations_count++;
        $director->verify();
        return null;
    }

    public function shouldNotHaveBeenCalled(array $args = null)
    {
        return $this->shouldNotHaveReceived("__invoke", $args);
    }

    protected static function _mockery_handleStaticMethodCall($method, array $args)
    {
        $associatedRealObject = \Mockery::fetchMock(__CLASS__);
        try {
            return $associatedRealObject->__call($method, $args);
        } catch (BadMethodCallException $e) {
            throw new BadMethodCallException(
                'Static method ' . $associatedRealObject->mockery_getName() . '::' . $method
                . '() does not exist on this mock object',
                null,
                $e
            );
        }
    }

    protected function _mockery_getReceivedMethodCalls()
    {
        return $this->_mockery_receivedMethodCalls ?: $this->_mockery_receivedMethodCalls = new \Mockery\ReceivedMethodCalls();
    }

    /**
     * Called when an instance Mock was created and its constructor is getting called
     *
     * @see \Mockery\Generator\StringManipulation\Pass\InstanceMockPass
     * @param array $args
     */
    protected function _mockery_constructorCalled(array $args)
    {
        if (!isset($this->_mockery_expectations['__construct']) /* _mockery_handleMethodCall runs the other checks */) {
            return;
        }
        $this->_mockery_handleMethodCall('__construct', $args);
    }

    protected function _mockery_findExpectedMethodHandler($method)
    {
        if (isset($this->_mockery_expectations[$method])) {
            return $this->_mockery_expectations[$method];
        }

        $lowerCasedMockeryExpectations = array_change_key_case($this->_mockery_expectations, CASE_LOWER);
        $lowerCasedMethod = strtolower($method);

        if (isset($lowerCasedMockeryExpectations[$lowerCasedMethod])) {
            return $lowerCasedMockeryExpectations[$lowerCasedMethod];
        }

        return null;
    }

    protected function _mockery_handleMethodCall($method, array $args)
    {
        $this->_mockery_getReceivedMethodCalls()->push(new \Mockery\MethodCall($method, $args));

        $rm = $this->mockery_getMethod($method);
        if ($rm && $rm->isProtected() && !$this->_mockery_allowMockingProtectedMethods) {
            if ($rm->isAbstract()) {
                return;
            }

            try {
                $prototype = $rm->getPrototype();
                if ($prototype->isAbstract()) {
                    return;
                }
            } catch (\ReflectionException $re) {
                // noop - there is no hasPrototype method
            }

            return call_user_func_array("parent::$method", $args);
        }

        $handler = $this->_mockery_findExpectedMethodHandler($method);

        if ($handler !== null && !$this->_mockery_disableExpectationMatching) {
            try {
                return $handler->call($args);
            } catch (\Mockery\Exception\NoMatchingExpectationException $e) {
                if (!$this->_mockery_ignoreMissing && !$this->_mockery_deferMissing) {
                    throw $e;
                }
            }
        }

        if (!is_null($this->_mockery_partial) &&
            (method_exists($this->_mockery_partial, $method) || method_exists($this->_mockery_partial, '__call'))
        ) {
            return call_user_func_array(array($this->_mockery_partial, $method), $args);
        } elseif ($this->_mockery_deferMissing && is_callable("parent::$method")
            && (!$this->hasMethodOverloadingInParentClass() || method_exists(get_parent_class($this), $method))) {
            return call_user_func_array("parent::$method", $args);
        } elseif ($this->_mockery_deferMissing && method_exists(get_parent_class($this), '__call')) {
            return call_user_func('parent::__call', $method, $args);
        } elseif ($method == '__toString') {
            // __toString is special because we force its addition to the class API regardless of the
            // original implementation.  Thus, we should always return a string rather than honor
            // _mockery_ignoreMissing and break the API with an error.
            return sprintf("%s#%s", __CLASS__, spl_object_hash($this));
        } elseif ($this->_mockery_ignoreMissing) {
            if (\Mockery::getConfiguration()->mockingNonExistentMethodsAllowed() || (method_exists($this->_mockery_partial, $method) || is_callable("parent::$method"))) {
                if ($this->_mockery_defaultReturnValue instanceof \Mockery\Undefined) {
                    return call_user_func_array(array($this->_mockery_defaultReturnValue, $method), $args);
                } elseif (null === $this->_mockery_defaultReturnValue) {
                    return $this->mockery_returnValueForMethod($method);
                }

                return $this->_mockery_defaultReturnValue;
            }
        }

        $message = 'Method ' . __CLASS__ . '::' . $method .
            '() does not exist on this mock object';

        if (!is_null($rm)) {
            $message = 'Received ' . __CLASS__ .
                '::' . $method . '(), but no expectations were specified';
        }

        $bmce = new BadMethodCallException($message);
        $this->_mockery_thrownExceptions[] = $bmce;
        throw $bmce;
    }

    /**
     * Uses reflection to get the list of all
     * methods within the current mock object
     *
     * @return array
     */
    protected function mockery_getMethods()
    {
        if (static::$_mockery_methods && \Mockery::getConfiguration()->reflectionCacheEnabled()) {
            return static::$_mockery_methods;
        }

        if (isset($this->_mockery_partial)) {
            $reflected = new \ReflectionObject($this->_mockery_partial);
        } else {
            $reflected = new \ReflectionClass($this);
        }

        return static::$_mockery_methods = $reflected->getMethods();
    }

    private function hasMethodOverloadingInParentClass()
    {
        // if there's __call any name would be callable
        return is_callable('parent::aFunctionNameThatNoOneWouldEverUseInRealLife12345');
    }

    /**
     * @return array
     */
    private function getNonPublicMethods()
    {
        return array_map(
            function ($method) {
                return $method->getName();
            },
            array_filter($this->mockery_getMethods(), function ($method) {
                return !$method->isPublic();
            })
        );
    }
}
