<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Command\ListCommand;

use Symfony\Component\Console\Input\InputInterface;

/**
 * Property Enumerator class.
 */
class PropertyEnumerator extends Enumerator
{
    /**
     * {@inheritdoc}
     */
    protected function listItems(InputInterface $input, \Reflector $reflector = null, $target = null)
    {
        // only list properties when a Reflector is present.

        if ($reflector === null) {
            return;
        }

        // We can only list properties on actual class (or object) reflectors.
        if (!$reflector instanceof \ReflectionClass) {
            return;
        }

        // only list properties if we are specifically asked
        if (!$input->getOption('properties')) {
            return;
        }

        $showAll    = $input->getOption('all');
        $noInherit  = $input->getOption('no-inherit');
        $properties = $this->prepareProperties($this->getProperties($showAll, $reflector, $noInherit), $target);

        if (empty($properties)) {
            return;
        }

        $ret = [];
        $ret[$this->getKindLabel($reflector)] = $properties;

        return $ret;
    }

    /**
     * Get defined properties for the given class or object Reflector.
     *
     * @param bool       $showAll   Include private and protected properties
     * @param \Reflector $reflector
     * @param bool       $noInherit Exclude inherited properties
     *
     * @return array
     */
    protected function getProperties($showAll, \Reflector $reflector, $noInherit = false)
    {
        $className = $reflector->getName();

        $properties = [];
        foreach ($reflector->getProperties() as $property) {
            if ($noInherit && $property->getDeclaringClass()->getName() !== $className) {
                continue;
            }

            if ($showAll || $property->isPublic()) {
                $properties[$property->getName()] = $property;
            }
        }

        \ksort($properties, SORT_NATURAL | SORT_FLAG_CASE);

        return $properties;
    }

    /**
     * Prepare formatted property array.
     *
     * @param array $properties
     *
     * @return array
     */
    protected function prepareProperties(array $properties, $target = null)
    {
        // My kingdom for a generator.
        $ret = [];

        foreach ($properties as $name => $property) {
            if ($this->showItem($name)) {
                $fname = '$' . $name;
                $ret[$fname] = [
                    'name'  => $fname,
                    'style' => $this->getVisibilityStyle($property),
                    'value' => $this->presentValue($property, $target),
                ];
            }
        }

        return $ret;
    }

    /**
     * Get a label for the particular kind of "class" represented.
     *
     * @param \ReflectionClass $reflector
     *
     * @return string
     */
    protected function getKindLabel(\ReflectionClass $reflector)
    {
        if ($reflector->isInterface()) {
            return 'Interface Properties';
        } elseif (\method_exists($reflector, 'isTrait') && $reflector->isTrait()) {
            return 'Trait Properties';
        } else {
            return 'Class Properties';
        }
    }

    /**
     * Get output style for the given property's visibility.
     *
     * @param \ReflectionProperty $property
     *
     * @return string
     */
    private function getVisibilityStyle(\ReflectionProperty $property)
    {
        if ($property->isPublic()) {
            return self::IS_PUBLIC;
        } elseif ($property->isProtected()) {
            return self::IS_PROTECTED;
        } else {
            return self::IS_PRIVATE;
        }
    }

    /**
     * Present the $target's current value for a reflection property.
     *
     * @param \ReflectionProperty $property
     * @param mixed               $target
     *
     * @return string
     */
    protected function presentValue(\ReflectionProperty $property, $target)
    {
        // If $target is a class, trait or interface (try to) get the default
        // value for the property.
        if (!\is_object($target)) {
            try {
                $refl = new \ReflectionClass($target);
                $props = $refl->getDefaultProperties();
                if (\array_key_exists($property->name, $props)) {
                    $suffix = $property->isStatic() ? '' : ' <aside>(default)</aside>';

                    return $this->presentRef($props[$property->name]) . $suffix;
                }
            } catch (\Exception $e) {
                // Well, we gave it a shot.
            }

            return '';
        }

        $property->setAccessible(true);
        $value = $property->getValue($target);

        return $this->presentRef($value);
    }
}
