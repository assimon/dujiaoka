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

namespace Mockery\Generator\StringManipulation\Pass;

use Mockery\Generator\MockConfiguration;
use Mockery\Generator\TargetClassInterface;
use Mockery\Generator\Method;

class MagicMethodTypeHintsPass implements Pass
{
    /**
     * @var array $mockMagicMethods
     */
    private $mockMagicMethods = array(
        '__construct',
        '__destruct',
        '__call',
        '__callStatic',
        '__get',
        '__set',
        '__isset',
        '__unset',
        '__sleep',
        '__wakeup',
        '__toString',
        '__invoke',
        '__set_state',
        '__clone',
        '__debugInfo'
    );

    /**
     * Apply implementation.
     *
     * @param string $code
     * @param MockConfiguration $config
     * @return string
     */
    public function apply($code, MockConfiguration $config)
    {
        $magicMethods = $this->getMagicMethods($config->getTargetClass());
        foreach ($config->getTargetInterfaces() as $interface) {
            $magicMethods = array_merge($magicMethods, $this->getMagicMethods($interface));
        }

        foreach ($magicMethods as $method) {
            $code = $this->applyMagicTypeHints($code, $method);
        }

        return $code;
    }

    /**
     * Returns the magic methods within the
     * passed DefinedTargetClass.
     *
     * @param TargetClassInterface $class
     * @return array
     */
    public function getMagicMethods(
        TargetClassInterface $class = null
    ) {
        if (is_null($class)) {
            return array();
        }
        return array_filter($class->getMethods(), function (Method $method) {
            return in_array($method->getName(), $this->mockMagicMethods);
        });
    }

    /**
     * Applies type hints of magic methods from
     * class to the passed code.
     *
     * @param int $code
     * @param Method $method
     * @return string
     */
    private function applyMagicTypeHints($code, Method $method)
    {
        if ($this->isMethodWithinCode($code, $method)) {
            $namedParameters = $this->getOriginalParameters(
                $code,
                $method
            );
            $code = preg_replace(
                $this->getDeclarationRegex($method->getName()),
                $this->getMethodDeclaration($method, $namedParameters),
                $code
            );
        }
        return $code;
    }

    /**
     * Checks if the method is declared withing code.
     *
     * @param int $code
     * @param Method $method
     * @return boolean
     */
    private function isMethodWithinCode($code, Method $method)
    {
        return preg_match(
            $this->getDeclarationRegex($method->getName()),
            $code
        ) == 1;
    }

    /**
     * Returns the method original parameters, as they're
     * described in the $code string.
     *
     * @param int $code
     * @param Method $method
     * @return array
     */
    private function getOriginalParameters($code, Method $method)
    {
        $matches = [];
        $parameterMatches = [];

        preg_match(
            $this->getDeclarationRegex($method->getName()),
            $code,
            $matches
        );

        if (count($matches) > 0) {
            preg_match_all(
                '/(?<=\$)(\w+)+/i',
                $matches[0],
                $parameterMatches
            );
        }

        $groupMatches = end($parameterMatches);
        $parameterNames = is_array($groupMatches) ?
            $groupMatches                         :
            array($groupMatches);

        return $parameterNames;
    }

    /**
     * Gets the declaration code, as a string, for the passed method.
     *
     * @param Method $method
     * @param array  $namedParameters
     * @return string
     */
    private function getMethodDeclaration(
        Method $method,
        array $namedParameters
    ) {
        $declaration = 'public';
        $declaration .= $method->isStatic() ? ' static' : '';
        $declaration .= ' function '.$method->getName().'(';

        foreach ($method->getParameters() as $index => $parameter) {
            $declaration .= $parameter->getTypeHintAsString().' ';
            $name = isset($namedParameters[$index]) ?
                $namedParameters[$index]            :
                $parameter->getName();
            $declaration .= '$'.$name;
            $declaration .= ',';
        }
        $declaration = rtrim($declaration, ',');
        $declaration .= ') ';

        $returnType = $method->getReturnType();
        if (!empty($returnType)) {
            $declaration .= ': '.$returnType;
        }

        return $declaration;
    }

    /**
     * Returns a regex string used to match the
     * declaration of some method.
     *
     * @param string $methodName
     * @return string
     */
    private function getDeclarationRegex($methodName)
    {
        return "/public\s+(?:static\s+)?function\s+$methodName\s*\(.*\)\s*(?=\{)/i";
    }
}
