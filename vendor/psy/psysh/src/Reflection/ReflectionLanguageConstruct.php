<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Reflection;

/**
 * A fake ReflectionFunction but for language constructs.
 */
class ReflectionLanguageConstruct extends \ReflectionFunctionAbstract
{
    public $keyword;

    /**
     * Language construct parameter definitions.
     */
    private static $languageConstructs = [
        'isset' => [
            'var' => [],
            '...' => [
                'isOptional'   => true,
                'defaultValue' => null,
            ],
        ],

        'unset' => [
            'var' => [],
            '...' => [
                'isOptional'   => true,
                'defaultValue' => null,
            ],
        ],

        'empty' => [
            'var' => [],
        ],

        'echo' => [
            'arg1' => [],
            '...'  => [
                'isOptional'   => true,
                'defaultValue' => null,
            ],
        ],

        'print' => [
            'arg' => [],
        ],

        'die' => [
            'status' => [
                'isOptional'   => true,
                'defaultValue' => 0,
            ],
        ],

        'exit' => [
            'status' => [
                'isOptional'   => true,
                'defaultValue' => 0,
            ],
        ],
    ];

    /**
     * Construct a ReflectionLanguageConstruct object.
     *
     * @param string $keyword
     */
    public function __construct($keyword)
    {
        if (!self::isLanguageConstruct($keyword)) {
            throw new \InvalidArgumentException('Unknown language construct: ' . $keyword);
        }

        $this->keyword = $keyword;
    }

    /**
     * This can't (and shouldn't) do anything :).
     *
     * @throws \RuntimeException
     */
    public static function export($name)
    {
        throw new \RuntimeException('Not yet implemented because it\'s unclear what I should do here :)');
    }

    /**
     * Get language construct name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->keyword;
    }

    /**
     * None of these return references.
     *
     * @return bool
     */
    public function returnsReference()
    {
        return false;
    }

    /**
     * Get language construct params.
     *
     * @return array
     */
    public function getParameters()
    {
        $params = [];
        foreach (self::$languageConstructs[$this->keyword] as $parameter => $opts) {
            \array_push($params, new ReflectionLanguageConstructParameter($this->keyword, $parameter, $opts));
        }

        return $params;
    }

    /**
     * Gets the file name from a language construct.
     *
     * (Hint: it always returns false)
     *
     * @return bool false
     */
    public function getFileName()
    {
        return false;
    }

    /**
     * To string.
     *
     * @return string
     */
    public function __toString()
    {
        return $this->getName();
    }

    /**
     * Check whether keyword is a (known) language construct.
     *
     * @param string $keyword
     *
     * @return bool
     */
    public static function isLanguageConstruct($keyword)
    {
        return \array_key_exists($keyword, self::$languageConstructs);
    }
}
