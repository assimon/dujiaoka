<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Formatter;

use Psy\Reflection\ReflectionClassConstant;
use Psy\Reflection\ReflectionConstant_;
use Psy\Reflection\ReflectionLanguageConstruct;
use Psy\Util\Json;
use Symfony\Component\Console\Formatter\OutputFormatter;

/**
 * An abstract representation of a function, class or property signature.
 */
class SignatureFormatter implements Formatter
{
    /**
     * Format a signature for the given reflector.
     *
     * Defers to subclasses to do the actual formatting.
     *
     * @param \Reflector $reflector
     *
     * @return string Formatted signature
     */
    public static function format(\Reflector $reflector)
    {
        switch (true) {
            case $reflector instanceof \ReflectionFunction:
            case $reflector instanceof ReflectionLanguageConstruct:
                return self::formatFunction($reflector);

            // this case also covers \ReflectionObject:
            case $reflector instanceof \ReflectionClass:
                return self::formatClass($reflector);

            case $reflector instanceof ReflectionClassConstant:
            case $reflector instanceof \ReflectionClassConstant:
                return self::formatClassConstant($reflector);

            case $reflector instanceof \ReflectionMethod:
                return self::formatMethod($reflector);

            case $reflector instanceof \ReflectionProperty:
                return self::formatProperty($reflector);

            case $reflector instanceof ReflectionConstant_:
                return self::formatConstant($reflector);

            default:
                throw new \InvalidArgumentException('Unexpected Reflector class: ' . \get_class($reflector));
        }
    }

    /**
     * Print the signature name.
     *
     * @param \Reflector $reflector
     *
     * @return string Formatted name
     */
    public static function formatName(\Reflector $reflector)
    {
        return $reflector->getName();
    }

    /**
     * Print the method, property or class modifiers.
     *
     * @param \Reflector $reflector
     *
     * @return string Formatted modifiers
     */
    private static function formatModifiers(\Reflector $reflector)
    {
        if ($reflector instanceof \ReflectionClass && $reflector->isTrait()) {
            // For some reason, PHP 5.x returns `abstract public` modifiers for
            // traits. Let's just ignore that business entirely.
            if (\version_compare(PHP_VERSION, '7.0.0', '<')) {
                return [];
            }
        }

        return \implode(' ', \array_map(function ($modifier) {
            return \sprintf('<keyword>%s</keyword>', $modifier);
        }, \Reflection::getModifierNames($reflector->getModifiers())));
    }

    /**
     * Format a class signature.
     *
     * @param \ReflectionClass $reflector
     *
     * @return string Formatted signature
     */
    private static function formatClass(\ReflectionClass $reflector)
    {
        $chunks = [];

        if ($modifiers = self::formatModifiers($reflector)) {
            $chunks[] = $modifiers;
        }

        if ($reflector->isTrait()) {
            $chunks[] = 'trait';
        } else {
            $chunks[] = $reflector->isInterface() ? 'interface' : 'class';
        }

        $chunks[] = \sprintf('<class>%s</class>', self::formatName($reflector));

        if ($parent = $reflector->getParentClass()) {
            $chunks[] = 'extends';
            $chunks[] = \sprintf('<class>%s</class>', $parent->getName());
        }

        $interfaces = $reflector->getInterfaceNames();
        if (!empty($interfaces)) {
            \sort($interfaces);

            $chunks[] = 'implements';
            $chunks[] = \implode(', ', \array_map(function ($name) {
                return \sprintf('<class>%s</class>', $name);
            }, $interfaces));
        }

        return \implode(' ', $chunks);
    }

    /**
     * Format a constant signature.
     *
     * @param ReflectionClassConstant|\ReflectionClassConstant $reflector
     *
     * @return string Formatted signature
     */
    private static function formatClassConstant($reflector)
    {
        $value = $reflector->getValue();
        $style = self::getTypeStyle($value);

        return \sprintf(
            '<keyword>const</keyword> <const>%s</const> = <%s>%s</%s>',
            self::formatName($reflector),
            $style,
            OutputFormatter::escape(Json::encode($value)),
            $style
        );
    }

    /**
     * Format a constant signature.
     *
     * @param ReflectionConstant_ $reflector
     *
     * @return string Formatted signature
     */
    private static function formatConstant($reflector)
    {
        $value = $reflector->getValue();
        $style = self::getTypeStyle($value);

        return \sprintf(
            '<keyword>define</keyword>(<string>%s</string>, <%s>%s</%s>)',
            OutputFormatter::escape(Json::encode($reflector->getName())),
            $style,
            OutputFormatter::escape(Json::encode($value)),
            $style
        );
    }

    /**
     * Helper for getting output style for a given value's type.
     *
     * @param mixed $value
     *
     * @return string
     */
    private static function getTypeStyle($value)
    {
        if (\is_int($value) || \is_float($value)) {
            return 'number';
        } elseif (\is_string($value)) {
            return 'string';
        } elseif (\is_bool($value) || \is_null($value)) {
            return 'bool';
        } else {
            return 'strong'; // @codeCoverageIgnore
        }
    }

    /**
     * Format a property signature.
     *
     * @param \ReflectionProperty $reflector
     *
     * @return string Formatted signature
     */
    private static function formatProperty(\ReflectionProperty $reflector)
    {
        return \sprintf(
            '%s <strong>$%s</strong>',
            self::formatModifiers($reflector),
            $reflector->getName()
        );
    }

    /**
     * Format a function signature.
     *
     * @param \ReflectionFunction $reflector
     *
     * @return string Formatted signature
     */
    private static function formatFunction(\ReflectionFunctionAbstract $reflector)
    {
        return \sprintf(
            '<keyword>function</keyword> %s<function>%s</function>(%s)',
            $reflector->returnsReference() ? '&' : '',
            self::formatName($reflector),
            \implode(', ', self::formatFunctionParams($reflector))
        );
    }

    /**
     * Format a method signature.
     *
     * @param \ReflectionMethod $reflector
     *
     * @return string Formatted signature
     */
    private static function formatMethod(\ReflectionMethod $reflector)
    {
        return \sprintf(
            '%s %s',
            self::formatModifiers($reflector),
            self::formatFunction($reflector)
        );
    }

    /**
     * Print the function params.
     *
     * @param \ReflectionFunctionAbstract $reflector
     *
     * @return array
     */
    private static function formatFunctionParams(\ReflectionFunctionAbstract $reflector)
    {
        $params = [];
        foreach ($reflector->getParameters() as $param) {
            $hint = '';
            try {
                if ($param->isArray()) {
                    $hint = '<keyword>array</keyword> ';
                } elseif ($class = $param->getClass()) {
                    $hint = \sprintf('<class>%s</class> ', $class->getName());
                }
            } catch (\Exception $e) {
                // sometimes we just don't know...
                // bad class names, or autoloaded classes that haven't been loaded yet, or whathaveyou.
                // come to think of it, the only time I've seen this is with the intl extension.

                // Hax: we'll try to extract it :P

                // @codeCoverageIgnoreStart
                $chunks = \explode('$' . $param->getName(), (string) $param);
                $chunks = \explode(' ', \trim($chunks[0]));
                $guess  = \end($chunks);

                $hint = \sprintf('<urgent>%s</urgent> ', $guess);
                // @codeCoverageIgnoreEnd
            }

            if ($param->isOptional()) {
                if (!$param->isDefaultValueAvailable()) {
                    $value     = 'unknown';
                    $typeStyle = 'urgent';
                } else {
                    $value     = $param->getDefaultValue();
                    $typeStyle = self::getTypeStyle($value);
                    $value     = \is_array($value) ? 'array()' : \is_null($value) ? 'null' : \var_export($value, true);
                }
                $default = \sprintf(' = <%s>%s</%s>', $typeStyle, OutputFormatter::escape($value), $typeStyle);
            } else {
                $default = '';
            }

            $params[] = \sprintf(
                '%s%s<strong>$%s</strong>%s',
                $param->isPassedByReference() ? '&' : '',
                $hint,
                $param->getName(),
                $default
            );
        }

        return $params;
    }
}
