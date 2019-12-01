<?php

/*
 Copyright (c) 2009 hamcrest.org
 */

class FactoryParameter
{
    /**
     * @var FactoryMethod
     */
    private $method;

    /**
     * @var ReflectionParameter
     */
    private $reflector;

    public function __construct(FactoryMethod $method, ReflectionParameter $reflector)
    {
        $this->method = $method;
        $this->reflector = $reflector;
    }

    public function getDeclaration()
    {
        if ($this->reflector->isArray()) {
            $code = 'array ';
        } else {
            $class = $this->reflector->getClass();
            if ($class !== null) {
                $code = '\\' . $class->name . ' ';
            } else {
                $code = '';
            }
        }
        $code .= '$' . $this->reflector->name;
        if ($this->reflector->isOptional()) {
            $default = $this->reflector->getDefaultValue();
            if (is_null($default)) {
                $default = 'null';
            } elseif (is_bool($default)) {
                $default = $default ? 'true' : 'false';
            } elseif (is_string($default)) {
                $default = "'" . $default . "'";
            } elseif (is_numeric($default)) {
                $default = strval($default);
            } elseif (is_array($default)) {
                $default = 'array()';
            } else {
                echo 'Warning: unknown default type for ' . $this->getMethod()->getFullName() . PHP_EOL;
                var_dump($default);
                $default = 'null';
            }
            $code .= ' = ' . $default;
        }
        return $code;
    }

    public function getInvocation()
    {
        return '$' . $this->reflector->name;
    }

    public function getMethod()
    {
        return $this->method;
    }
}
