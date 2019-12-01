<?php
/*
 * This file is part of sebastian/global-state.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace SebastianBergmann\GlobalState;

use ReflectionClass;

/**
 * A blacklist for global state elements that should not be snapshotted.
 */
class Blacklist
{
    /**
     * @var array
     */
    private $globalVariables = [];

    /**
     * @var string[]
     */
    private $classes = [];

    /**
     * @var string[]
     */
    private $classNamePrefixes = [];

    /**
     * @var string[]
     */
    private $parentClasses = [];

    /**
     * @var string[]
     */
    private $interfaces = [];

    /**
     * @var array
     */
    private $staticAttributes = [];

    public function addGlobalVariable(string $variableName)
    {
        $this->globalVariables[$variableName] = true;
    }

    public function addClass(string $className)
    {
        $this->classes[] = $className;
    }

    public function addSubclassesOf(string $className)
    {
        $this->parentClasses[] = $className;
    }

    public function addImplementorsOf(string $interfaceName)
    {
        $this->interfaces[] = $interfaceName;
    }

    public function addClassNamePrefix(string $classNamePrefix)
    {
        $this->classNamePrefixes[] = $classNamePrefix;
    }

    public function addStaticAttribute(string $className, string $attributeName)
    {
        if (!isset($this->staticAttributes[$className])) {
            $this->staticAttributes[$className] = [];
        }

        $this->staticAttributes[$className][$attributeName] = true;
    }

    public function isGlobalVariableBlacklisted(string $variableName): bool
    {
        return isset($this->globalVariables[$variableName]);
    }

    public function isStaticAttributeBlacklisted(string $className, string $attributeName): bool
    {
        if (\in_array($className, $this->classes)) {
            return true;
        }

        foreach ($this->classNamePrefixes as $prefix) {
            if (\strpos($className, $prefix) === 0) {
                return true;
            }
        }

        $class = new ReflectionClass($className);

        foreach ($this->parentClasses as $type) {
            if ($class->isSubclassOf($type)) {
                return true;
            }
        }

        foreach ($this->interfaces as $type) {
            if ($class->implementsInterface($type)) {
                return true;
            }
        }

        if (isset($this->staticAttributes[$className][$attributeName])) {
            return true;
        }

        return false;
    }
}
