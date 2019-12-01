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

namespace Mockery\Generator;

/**
 * This class describes the configuration of mocks and hides away some of the
 * reflection implementation
 */
class MockConfiguration
{
    /**
     * A class that we'd like to mock
     */
    protected $targetClass;
    protected $targetClassName;

    /**
     * A number of interfaces we'd like to mock, keyed by name to attempt to
     * keep unique
     */
    protected $targetInterfaces = array();
    protected $targetInterfaceNames = array();

    /**
     * A number of traits we'd like to mock, keyed by name to attempt to
     * keep unique
     */
    protected $targetTraits = array();
    protected $targetTraitNames = array();

    /**
     * An object we'd like our mock to proxy to
     */
    protected $targetObject;

    /**
     * The class name we'd like to use for a generated mock
     */
    protected $name;

    /**
     * Methods that should specifically not be mocked
     *
     * This is currently populated with stuff we don't know how to deal with,
     * should really be somewhere else
     */
    protected $blackListedMethods = array();

    /**
     * If not empty, only these methods will be mocked
     */
    protected $whiteListedMethods = array();

    /**
     * An instance mock is where we override the original class before it's
     * autoloaded
     */
    protected $instanceMock = false;

    /**
     * Param overrides
     */
    protected $parameterOverrides = array();

    /**
     * Instance cache of all methods
     */
    protected $allMethods;

    /**
     * If true, overrides original class destructor
     */
    protected $mockOriginalDestructor = false;

    protected $constantsMap = array();

    public function __construct(
        array $targets = array(),
        array $blackListedMethods = array(),
        array $whiteListedMethods = array(),
        $name = null,
        $instanceMock = false,
        array $parameterOverrides = array(),
        $mockOriginalDestructor = false,
        array $constantsMap = array()
    ) {
        $this->addTargets($targets);
        $this->blackListedMethods = $blackListedMethods;
        $this->whiteListedMethods = $whiteListedMethods;
        $this->name = $name;
        $this->instanceMock = $instanceMock;
        $this->parameterOverrides = $parameterOverrides;
        $this->mockOriginalDestructor = $mockOriginalDestructor;
        $this->constantsMap = $constantsMap;
    }

    /**
     * Attempt to create a hash of the configuration, in order to allow caching
     *
     * @TODO workout if this will work
     *
     * @return string
     */
    public function getHash()
    {
        $vars = array(
            'targetClassName'        => $this->targetClassName,
            'targetInterfaceNames'   => $this->targetInterfaceNames,
            'targetTraitNames'       => $this->targetTraitNames,
            'name'                   => $this->name,
            'blackListedMethods'     => $this->blackListedMethods,
            'whiteListedMethod'      => $this->whiteListedMethods,
            'instanceMock'           => $this->instanceMock,
            'parameterOverrides'     => $this->parameterOverrides,
            'mockOriginalDestructor' => $this->mockOriginalDestructor
        );

        return md5(serialize($vars));
    }

    /**
     * Gets a list of methods from the classes, interfaces and objects and
     * filters them appropriately. Lot's of filtering going on, perhaps we could
     * have filter classes to iterate through
     */
    public function getMethodsToMock()
    {
        $methods = $this->getAllMethods();

        foreach ($methods as $key => $method) {
            if ($method->isFinal()) {
                unset($methods[$key]);
            }
        }

        /**
         * Whitelist trumps everything else
         */
        if (count($this->getWhiteListedMethods())) {
            $whitelist = array_map('strtolower', $this->getWhiteListedMethods());
            $methods = array_filter($methods, function ($method) use ($whitelist) {
                return $method->isAbstract() || in_array(strtolower($method->getName()), $whitelist);
            });

            return $methods;
        }

        /**
         * Remove blacklisted methods
         */
        if (count($this->getBlackListedMethods())) {
            $blacklist = array_map('strtolower', $this->getBlackListedMethods());
            $methods = array_filter($methods, function ($method) use ($blacklist) {
                return !in_array(strtolower($method->getName()), $blacklist);
            });
        }

        /**
         * Internal objects can not be instantiated with newInstanceArgs and if
         * they implement Serializable, unserialize will have to be called. As
         * such, we can't mock it and will need a pass to add a dummy
         * implementation
         */
        if ($this->getTargetClass()
            && $this->getTargetClass()->implementsInterface("Serializable")
            && $this->getTargetClass()->hasInternalAncestor()) {
            $methods = array_filter($methods, function ($method) {
                return $method->getName() !== "unserialize";
            });
        }

        return array_values($methods);
    }

    /**
     * We declare the __call method to handle undefined stuff, if the class
     * we're mocking has also defined it, we need to comply with their interface
     */
    public function requiresCallTypeHintRemoval()
    {
        foreach ($this->getAllMethods() as $method) {
            if ("__call" === $method->getName()) {
                $params = $method->getParameters();
                return !$params[1]->isArray();
            }
        }

        return false;
    }

    /**
     * We declare the __callStatic method to handle undefined stuff, if the class
     * we're mocking has also defined it, we need to comply with their interface
     */
    public function requiresCallStaticTypeHintRemoval()
    {
        foreach ($this->getAllMethods() as $method) {
            if ("__callStatic" === $method->getName()) {
                $params = $method->getParameters();
                return !$params[1]->isArray();
            }
        }

        return false;
    }

    public function rename($className)
    {
        $targets = array();

        if ($this->targetClassName) {
            $targets[] = $this->targetClassName;
        }

        if ($this->targetInterfaceNames) {
            $targets = array_merge($targets, $this->targetInterfaceNames);
        }

        if ($this->targetTraitNames) {
            $targets = array_merge($targets, $this->targetTraitNames);
        }

        if ($this->targetObject) {
            $targets[] = $this->targetObject;
        }

        return new self(
            $targets,
            $this->blackListedMethods,
            $this->whiteListedMethods,
            $className,
            $this->instanceMock,
            $this->parameterOverrides,
            $this->mockOriginalDestructor,
            $this->constantsMap
        );
    }

    protected function addTarget($target)
    {
        if (is_object($target)) {
            $this->setTargetObject($target);
            $this->setTargetClassName(get_class($target));
            return $this;
        }

        if ($target[0] !== "\\") {
            $target = "\\" . $target;
        }

        if (class_exists($target)) {
            $this->setTargetClassName($target);
            return $this;
        }

        if (interface_exists($target)) {
            $this->addTargetInterfaceName($target);
            return $this;
        }

        if (trait_exists($target)) {
            $this->addTargetTraitName($target);
            return $this;
        }

        /**
         * Default is to set as class, or interface if class already set
         *
         * Don't like this condition, can't remember what the default
         * targetClass is for
         */
        if ($this->getTargetClassName()) {
            $this->addTargetInterfaceName($target);
            return $this;
        }

        $this->setTargetClassName($target);
    }

    protected function addTargets($interfaces)
    {
        foreach ($interfaces as $interface) {
            $this->addTarget($interface);
        }
    }

    public function getTargetClassName()
    {
        return $this->targetClassName;
    }

    public function getTargetClass()
    {
        if ($this->targetClass) {
            return $this->targetClass;
        }

        if (!$this->targetClassName) {
            return null;
        }

        if (class_exists($this->targetClassName)) {
            $dtc = DefinedTargetClass::factory($this->targetClassName);

            if ($this->getTargetObject() == false && $dtc->isFinal()) {
                throw new \Mockery\Exception(
                    'The class ' . $this->targetClassName . ' is marked final and its methods'
                    . ' cannot be replaced. Classes marked final can be passed in'
                    . ' to \Mockery::mock() as instantiated objects to create a'
                    . ' partial mock, but only if the mock is not subject to type'
                    . ' hinting checks.'
                );
            }

            $this->targetClass = $dtc;
        } else {
            $this->targetClass = UndefinedTargetClass::factory($this->targetClassName);
        }

        return $this->targetClass;
    }

    public function getTargetTraits()
    {
        if (!empty($this->targetTraits)) {
            return $this->targetTraits;
        }

        foreach ($this->targetTraitNames as $targetTrait) {
            $this->targetTraits[] = DefinedTargetClass::factory($targetTrait);
        }

        $this->targetTraits = array_unique($this->targetTraits); // just in case
        return $this->targetTraits;
    }

    public function getTargetInterfaces()
    {
        if (!empty($this->targetInterfaces)) {
            return $this->targetInterfaces;
        }

        foreach ($this->targetInterfaceNames as $targetInterface) {
            if (!interface_exists($targetInterface)) {
                $this->targetInterfaces[] = UndefinedTargetClass::factory($targetInterface);
                continue;
            }

            $dtc = DefinedTargetClass::factory($targetInterface);
            $extendedInterfaces = array_keys($dtc->getInterfaces());
            $extendedInterfaces[] = $targetInterface;

            $traversableFound = false;
            $iteratorShiftedToFront = false;
            foreach ($extendedInterfaces as $interface) {
                if (!$traversableFound && preg_match("/^\\?Iterator(|Aggregate)$/i", $interface)) {
                    break;
                }

                if (preg_match("/^\\\\?IteratorAggregate$/i", $interface)) {
                    $this->targetInterfaces[] = DefinedTargetClass::factory("\\IteratorAggregate");
                    $iteratorShiftedToFront = true;
                } elseif (preg_match("/^\\\\?Iterator$/i", $interface)) {
                    $this->targetInterfaces[] = DefinedTargetClass::factory("\\Iterator");
                    $iteratorShiftedToFront = true;
                } elseif (preg_match("/^\\\\?Traversable$/i", $interface)) {
                    $traversableFound = true;
                }
            }

            if ($traversableFound && !$iteratorShiftedToFront) {
                $this->targetInterfaces[] = DefinedTargetClass::factory("\\IteratorAggregate");
            }

            /**
             * We never straight up implement Traversable
             */
            if (!preg_match("/^\\\\?Traversable$/i", $targetInterface)) {
                $this->targetInterfaces[] = $dtc;
            }
        }
        $this->targetInterfaces = array_unique($this->targetInterfaces); // just in case
        return $this->targetInterfaces;
    }

    public function getTargetObject()
    {
        return $this->targetObject;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * Generate a suitable name based on the config
     */
    public function generateName()
    {
        $nameBuilder = new MockNameBuilder();

        if ($this->getTargetObject()) {
            $nameBuilder->addPart(get_class($this->getTargetObject()));
        }

        if ($this->getTargetClass()) {
            $nameBuilder->addPart($this->getTargetClass()->getName());
        }

        foreach ($this->getTargetInterfaces() as $targetInterface) {
            $nameBuilder->addPart($targetInterface->getName());
        }

        return $nameBuilder->build();
    }

    public function getShortName()
    {
        $parts = explode("\\", $this->getName());
        return array_pop($parts);
    }

    public function getNamespaceName()
    {
        $parts = explode("\\", $this->getName());
        array_pop($parts);

        if (count($parts)) {
            return implode("\\", $parts);
        }

        return "";
    }

    public function getBlackListedMethods()
    {
        return $this->blackListedMethods;
    }

    public function getWhiteListedMethods()
    {
        return $this->whiteListedMethods;
    }

    public function isInstanceMock()
    {
        return $this->instanceMock;
    }

    public function getParameterOverrides()
    {
        return $this->parameterOverrides;
    }

    public function isMockOriginalDestructor()
    {
        return $this->mockOriginalDestructor;
    }

    protected function setTargetClassName($targetClassName)
    {
        $this->targetClassName = $targetClassName;
    }

    protected function getAllMethods()
    {
        if ($this->allMethods) {
            return $this->allMethods;
        }

        $classes = $this->getTargetInterfaces();

        if ($this->getTargetClass()) {
            $classes[] = $this->getTargetClass();
        }

        $methods = array();
        foreach ($classes as $class) {
            $methods = array_merge($methods, $class->getMethods());
        }

        foreach ($this->getTargetTraits() as $trait) {
            foreach ($trait->getMethods() as $method) {
                if ($method->isAbstract()) {
                    $methods[] = $method;
                }
            }
        }

        $names = array();
        $methods = array_filter($methods, function ($method) use (&$names) {
            if (in_array($method->getName(), $names)) {
                return false;
            }

            $names[] = $method->getName();
            return true;
        });

        // In HHVM, class methods can be annotated with the built-in
        // <<__Memoize>> attribute (similar to a Python decorator),
        // which builds an LRU cache of method arguments and their
        // return values.
        // https://docs.hhvm.com/hack/attributes/special#__memoize
        //
        // HHVM implements this behavior by inserting a private helper
        // method into the class at runtime which is named as the
        // method to be memoized, suffixed by `$memoize_impl`.
        // https://github.com/facebook/hhvm/blob/6aa46f1e8c2351b97d65e67b73e26f274a7c3f2e/hphp/runtime/vm/func.cpp#L364
        //
        // Ordinarily, PHP does not all allow the `$` token in method
        // names, but since the memoization helper is inserted at
        // runtime (and not in userland), HHVM allows it.
        //
        // We use code generation and eval() for some types of mocks,
        // so to avoid syntax errors from these memoization helpers,
        // we must filter them from our list of class methods.
        //
        // This effectively disables the memoization behavior in HHVM,
        // but that's preferable to failing catastrophically when
        // attempting to mock a class using the attribute.
        if (defined('HHVM_VERSION')) {
            $methods = array_filter($methods, function ($method) {
                return strpos($method->getName(), '$memoize_impl') === false;
            });
        }

        return $this->allMethods = $methods;
    }

    /**
     * If we attempt to implement Traversable, we must ensure we are also
     * implementing either Iterator or IteratorAggregate, and that whichever one
     * it is comes before Traversable in the list of implements.
     */
    protected function addTargetInterfaceName($targetInterface)
    {
        $this->targetInterfaceNames[] = $targetInterface;
    }

    protected function addTargetTraitName($targetTraitName)
    {
        $this->targetTraitNames[] = $targetTraitName;
    }

    protected function setTargetObject($object)
    {
        $this->targetObject = $object;
    }

    public function getConstantsMap()
    {
        return $this->constantsMap;
    }
}
