<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy;

/**
 * Helpers for bypassing visibility restrictions, mostly used in code generated
 * by the `sudo` command.
 */
class Sudo
{
    /**
     * Fetch a property of an object, bypassing visibility restrictions.
     *
     * @param object $object
     * @param string $property property name
     *
     * @return mixed Value of $object->property
     */
    public static function fetchProperty($object, $property)
    {
        $refl = new \ReflectionObject($object);
        $prop = $refl->getProperty($property);
        $prop->setAccessible(true);

        return $prop->getValue($object);
    }

    /**
     * Assign the value of a property of an object, bypassing visibility restrictions.
     *
     * @param object $object
     * @param string $property property name
     * @param mixed  $value
     *
     * @return mixed Value of $object->property
     */
    public static function assignProperty($object, $property, $value)
    {
        $refl = new \ReflectionObject($object);
        $prop = $refl->getProperty($property);
        $prop->setAccessible(true);
        $prop->setValue($object, $value);

        return $value;
    }

    /**
     * Call a method on an object, bypassing visibility restrictions.
     *
     * @param object $object
     * @param string $method  method name
     * @param mixed  $args...
     *
     * @return mixed
     */
    public static function callMethod($object, $method, $args = null)
    {
        $args   = \func_get_args();
        $object = \array_shift($args);
        $method = \array_shift($args);

        $refl = new \ReflectionObject($object);
        $reflMethod = $refl->getMethod($method);
        $reflMethod->setAccessible(true);

        return $reflMethod->invokeArgs($object, $args);
    }

    /**
     * Fetch a property of a class, bypassing visibility restrictions.
     *
     * @param string|object $class    class name or instance
     * @param string        $property property name
     *
     * @return mixed Value of $class::$property
     */
    public static function fetchStaticProperty($class, $property)
    {
        $refl = new \ReflectionClass($class);
        $prop = $refl->getProperty($property);
        $prop->setAccessible(true);

        return $prop->getValue();
    }

    /**
     * Assign the value of a static property of a class, bypassing visibility restrictions.
     *
     * @param string|object $class    class name or instance
     * @param string        $property property name
     * @param mixed         $value
     *
     * @return mixed Value of $class::$property
     */
    public static function assignStaticProperty($class, $property, $value)
    {
        $refl = new \ReflectionClass($class);
        $prop = $refl->getProperty($property);
        $prop->setAccessible(true);
        $prop->setValue($value);

        return $value;
    }

    /**
     * Call a static method on a class, bypassing visibility restrictions.
     *
     * @param string|object $class   class name or instance
     * @param string        $method  method name
     * @param mixed         $args...
     *
     * @return mixed
     */
    public static function callStatic($class, $method, $args = null)
    {
        $args   = \func_get_args();
        $class  = \array_shift($args);
        $method = \array_shift($args);

        $refl = new \ReflectionClass($class);
        $reflMethod = $refl->getMethod($method);
        $reflMethod->setAccessible(true);

        return $reflMethod->invokeArgs(null, $args);
    }

    /**
     * Fetch a class constant, bypassing visibility restrictions.
     *
     * @param string|object $class class name or instance
     * @param string        $const constant name
     *
     * @return mixed
     */
    public static function fetchClassConst($class, $const)
    {
        $refl = new \ReflectionClass($class);

        return $refl->getConstant($const);
    }
}
