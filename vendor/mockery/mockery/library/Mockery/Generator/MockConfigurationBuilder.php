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

class MockConfigurationBuilder
{
    protected $name;
    protected $blackListedMethods = array(
        '__call',
        '__callStatic',
        '__clone',
        '__wakeup',
        '__set',
        '__get',
        '__toString',
        '__isset',
        '__destruct',
        '__debugInfo', ## mocking this makes it difficult to debug with xdebug

        // below are reserved words in PHP
        "__halt_compiler", "abstract", "and", "array", "as",
        "break", "callable", "case", "catch", "class",
        "clone", "const", "continue", "declare", "default",
        "die", "do", "echo", "else", "elseif",
        "empty", "enddeclare", "endfor", "endforeach", "endif",
        "endswitch", "endwhile", "eval", "exit", "extends",
        "final", "for", "foreach", "function", "global",
        "goto", "if", "implements", "include", "include_once",
        "instanceof", "insteadof", "interface", "isset", "list",
        "namespace", "new", "or", "print", "private",
        "protected", "public", "require", "require_once", "return",
        "static", "switch", "throw", "trait", "try",
        "unset", "use", "var", "while", "xor"
    );

    protected $php7SemiReservedKeywords = [
        "callable", "class", "trait", "extends", "implements", "static", "abstract", "final",
        "public", "protected", "private", "const", "enddeclare", "endfor", "endforeach", "endif",
        "endwhile", "and", "global", "goto", "instanceof", "insteadof", "interface", "namespace", "new",
        "or", "xor", "try", "use", "var", "exit", "list", "clone", "include", "include_once", "throw",
        "array", "print", "echo", "require", "require_once", "return", "else", "elseif", "default",
        "break", "continue", "switch", "yield", "function", "if", "endswitch", "finally", "for", "foreach",
        "declare", "case", "do", "while", "as", "catch", "die", "self", "parent",
    ];

    protected $whiteListedMethods = array();
    protected $instanceMock = false;
    protected $parameterOverrides = array();

    protected $mockOriginalDestructor = false;
    protected $targets = array();

    protected $constantsMap = array();

    public function __construct()
    {
        if (version_compare(PHP_VERSION, '7.0.0') >= 0) {
            $this->blackListedMethods = array_diff($this->blackListedMethods, $this->php7SemiReservedKeywords);
        }
    }

    public function addTarget($target)
    {
        $this->targets[] = $target;

        return $this;
    }

    public function addTargets($targets)
    {
        foreach ($targets as $target) {
            $this->addTarget($target);
        }

        return $this;
    }

    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    public function addBlackListedMethod($blackListedMethod)
    {
        $this->blackListedMethods[] = $blackListedMethod;
        return $this;
    }

    public function addBlackListedMethods(array $blackListedMethods)
    {
        foreach ($blackListedMethods as $method) {
            $this->addBlackListedMethod($method);
        }
        return $this;
    }

    public function setBlackListedMethods(array $blackListedMethods)
    {
        $this->blackListedMethods = $blackListedMethods;
        return $this;
    }

    public function addWhiteListedMethod($whiteListedMethod)
    {
        $this->whiteListedMethods[] = $whiteListedMethod;
        return $this;
    }

    public function addWhiteListedMethods(array $whiteListedMethods)
    {
        foreach ($whiteListedMethods as $method) {
            $this->addWhiteListedMethod($method);
        }
        return $this;
    }

    public function setWhiteListedMethods(array $whiteListedMethods)
    {
        $this->whiteListedMethods = $whiteListedMethods;
        return $this;
    }

    public function setInstanceMock($instanceMock)
    {
        $this->instanceMock = (bool) $instanceMock;
    }

    public function setParameterOverrides(array $overrides)
    {
        $this->parameterOverrides = $overrides;
    }

    public function setMockOriginalDestructor($mockDestructor)
    {
        $this->mockOriginalDestructor = $mockDestructor;
        return $this;
    }

    public function setConstantsMap(array $map)
    {
        $this->constantsMap = $map;
    }

    public function getMockConfiguration()
    {
        return new MockConfiguration(
            $this->targets,
            $this->blackListedMethods,
            $this->whiteListedMethods,
            $this->name,
            $this->instanceMock,
            $this->parameterOverrides,
            $this->mockOriginalDestructor,
            $this->constantsMap
        );
    }
}
