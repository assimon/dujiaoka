<?php

declare(strict_types=1);

/**
 * This file is part of phpDocumentor.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * @link      http://phpdoc.org
 */

namespace phpDocumentor\Reflection;

use ArrayIterator;
use InvalidArgumentException;
use phpDocumentor\Reflection\Types\Array_;
use phpDocumentor\Reflection\Types\Collection;
use phpDocumentor\Reflection\Types\Compound;
use phpDocumentor\Reflection\Types\Context;
use phpDocumentor\Reflection\Types\Integer;
use phpDocumentor\Reflection\Types\Iterable_;
use phpDocumentor\Reflection\Types\Nullable;
use phpDocumentor\Reflection\Types\Object_;
use phpDocumentor\Reflection\Types\String_;
use RuntimeException;
use const PREG_SPLIT_DELIM_CAPTURE;
use const PREG_SPLIT_NO_EMPTY;
use function array_keys;
use function array_pop;
use function class_exists;
use function class_implements;
use function count;
use function in_array;
use function preg_split;
use function strlen;
use function strpos;
use function strtolower;
use function substr;
use function trim;

final class TypeResolver
{
    /** @var string Definition of the ARRAY operator for types */
    private const OPERATOR_ARRAY = '[]';

    /** @var string Definition of the NAMESPACE operator in PHP */
    private const OPERATOR_NAMESPACE = '\\';

    /** @var int the iterator parser is inside a compound context */
    private const PARSER_IN_COMPOUND = 0;

    /** @var int the iterator parser is inside a nullable expression context */
    private const PARSER_IN_NULLABLE = 1;

    /** @var int the iterator parser is inside an array expression context */
    private const PARSER_IN_ARRAY_EXPRESSION = 2;

    /** @var int the iterator parser is inside a collection expression context */
    private const PARSER_IN_COLLECTION_EXPRESSION = 3;

    /**
     * @var array<string, string> List of recognized keywords and unto which Value Object they map
     * @psalm-var array<string, class-string<Type>>
     */
    private $keywords = [
        'string' => Types\String_::class,
        'int' => Types\Integer::class,
        'integer' => Types\Integer::class,
        'bool' => Types\Boolean::class,
        'boolean' => Types\Boolean::class,
        'real' => Types\Float_::class,
        'float' => Types\Float_::class,
        'double' => Types\Float_::class,
        'object' => Object_::class,
        'mixed' => Types\Mixed_::class,
        'array' => Array_::class,
        'resource' => Types\Resource_::class,
        'void' => Types\Void_::class,
        'null' => Types\Null_::class,
        'scalar' => Types\Scalar::class,
        'callback' => Types\Callable_::class,
        'callable' => Types\Callable_::class,
        'false' => Types\Boolean::class,
        'true' => Types\Boolean::class,
        'self' => Types\Self_::class,
        '$this' => Types\This::class,
        'static' => Types\Static_::class,
        'parent' => Types\Parent_::class,
        'iterable' => Iterable_::class,
    ];

    /** @var FqsenResolver */
    private $fqsenResolver;

    /**
     * Initializes this TypeResolver with the means to create and resolve Fqsen objects.
     */
    public function __construct(?FqsenResolver $fqsenResolver = null)
    {
        $this->fqsenResolver = $fqsenResolver ?: new FqsenResolver();
    }

    /**
     * Analyzes the given type and returns the FQCN variant.
     *
     * When a type is provided this method checks whether it is not a keyword or
     * Fully Qualified Class Name. If so it will use the given namespace and
     * aliases to expand the type to a FQCN representation.
     *
     * This method only works as expected if the namespace and aliases are set;
     * no dynamic reflection is being performed here.
     *
     * @uses Context::getNamespaceAliases() to check whether the first part of the relative type name should not be
     * replaced with another namespace.
     * @uses Context::getNamespace()        to determine with what to prefix the type name.
     *
     * @param string $type The relative or absolute type.
     */
    public function resolve(string $type, ?Context $context = null) : Type
    {
        $type = trim($type);
        if (!$type) {
            throw new InvalidArgumentException('Attempted to resolve "' . $type . '" but it appears to be empty');
        }

        if ($context === null) {
            $context = new Context('');
        }

        // split the type string into tokens `|`, `?`, `<`, `>`, `,`, `(`, `)[]`, '<', '>' and type names
        $tokens = preg_split(
            '/(\\||\\?|<|>|, ?|\\(|\\)(?:\\[\\])+)/',
            $type,
            -1,
            PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE
        );

        if ($tokens === false) {
            throw new InvalidArgumentException('Unable to split the type string "' . $type . '" into tokens');
        }

        $tokenIterator = new ArrayIterator($tokens);

        return $this->parseTypes($tokenIterator, $context, self::PARSER_IN_COMPOUND);
    }

    /**
     * Analyse each tokens and creates types
     *
     * @param ArrayIterator $tokens        the iterator on tokens
     * @param int           $parserContext on of self::PARSER_* constants, indicating
     * the context where we are in the parsing
     */
    private function parseTypes(ArrayIterator $tokens, Context $context, int $parserContext) : Type
    {
        $types = [];
        $token = '';
        while ($tokens->valid()) {
            $token = $tokens->current();

            if ($token === '|') {
                if (count($types) === 0) {
                    throw new RuntimeException(
                        'A type is missing before a type separator'
                    );
                }

                if ($parserContext !== self::PARSER_IN_COMPOUND
                    && $parserContext !== self::PARSER_IN_ARRAY_EXPRESSION
                    && $parserContext !== self::PARSER_IN_COLLECTION_EXPRESSION
                ) {
                    throw new RuntimeException(
                        'Unexpected type separator'
                    );
                }

                $tokens->next();
            } elseif ($token === '?') {
                if ($parserContext !== self::PARSER_IN_COMPOUND
                    && $parserContext !== self::PARSER_IN_ARRAY_EXPRESSION
                    && $parserContext !== self::PARSER_IN_COLLECTION_EXPRESSION
                ) {
                    throw new RuntimeException(
                        'Unexpected nullable character'
                    );
                }

                $tokens->next();
                $type    = $this->parseTypes($tokens, $context, self::PARSER_IN_NULLABLE);
                $types[] = new Nullable($type);
            } elseif ($token === '(') {
                $tokens->next();
                $type = $this->parseTypes($tokens, $context, self::PARSER_IN_ARRAY_EXPRESSION);

                $resolvedType = new Array_($type);

                $token = $tokens->current();
                // Someone did not properly close their array expression ..
                if ($token === null) {
                    break;
                }

                // we generate arrays corresponding to the number of '[]' after the ')'
                $numberOfArrays = (strlen($token) - 1) / 2;
                for ($i = 0; $i < $numberOfArrays - 1; ++$i) {
                    $resolvedType = new Array_($resolvedType);
                }

                $types[] = $resolvedType;
                $tokens->next();
            } elseif ($parserContext === self::PARSER_IN_ARRAY_EXPRESSION && $token[0] === ')') {
                break;
            } elseif ($token === '<') {
                if (count($types) === 0) {
                    throw new RuntimeException(
                        'Unexpected collection operator "<", class name is missing'
                    );
                }

                $classType = array_pop($types);
                if ($classType !== null) {
                    $types[] = $this->resolveCollection($tokens, $classType, $context);
                }

                $tokens->next();
            } elseif ($parserContext === self::PARSER_IN_COLLECTION_EXPRESSION
                && ($token === '>' || trim($token) === ',')
            ) {
                break;
            } else {
                $type = $this->resolveSingleType($token, $context);
                $tokens->next();
                if ($parserContext === self::PARSER_IN_NULLABLE) {
                    return $type;
                }

                $types[] = $type;
            }
        }

        if ($token === '|') {
            throw new RuntimeException(
                'A type is missing after a type separator'
            );
        }

        if (count($types) === 0) {
            if ($parserContext === self::PARSER_IN_NULLABLE) {
                throw new RuntimeException(
                    'A type is missing after a nullable character'
                );
            }

            if ($parserContext === self::PARSER_IN_ARRAY_EXPRESSION) {
                throw new RuntimeException(
                    'A type is missing in an array expression'
                );
            }

            if ($parserContext === self::PARSER_IN_COLLECTION_EXPRESSION) {
                throw new RuntimeException(
                    'A type is missing in a collection expression'
                );
            }
        } elseif (count($types) === 1) {
            return $types[0];
        }

        return new Compound($types);
    }

    /**
     * resolve the given type into a type object
     *
     * @param string $type the type string, representing a single type
     *
     * @return Type|Array_|Object_
     */
    private function resolveSingleType(string $type, Context $context)
    {
        switch (true) {
            case $this->isKeyword($type):
                return $this->resolveKeyword($type);
            case $this->isTypedArray($type):
                return $this->resolveTypedArray($type, $context);
            case $this->isFqsen($type):
                return $this->resolveTypedObject($type);
            case $this->isPartialStructuralElementName($type):
                return $this->resolveTypedObject($type, $context);
            // @codeCoverageIgnoreStart
            default:
                // I haven't got the foggiest how the logic would come here but added this as a defense.
                throw new RuntimeException(
                    'Unable to resolve type "' . $type . '", there is no known method to resolve it'
                );
        }

        // @codeCoverageIgnoreEnd
    }

    /**
     * Adds a keyword to the list of Keywords and associates it with a specific Value Object.
     */
    public function addKeyword(string $keyword, string $typeClassName) : void
    {
        if (!class_exists($typeClassName)) {
            throw new InvalidArgumentException(
                'The Value Object that needs to be created with a keyword "' . $keyword . '" must be an existing class'
                . ' but we could not find the class ' . $typeClassName
            );
        }

        if (!in_array(Type::class, class_implements($typeClassName), true)) {
            throw new InvalidArgumentException(
                'The class "' . $typeClassName . '" must implement the interface "phpDocumentor\Reflection\Type"'
            );
        }

        $this->keywords[$keyword] = $typeClassName;
    }

    /**
     * Detects whether the given type represents an array.
     *
     * @param string $type A relative or absolute type as defined in the phpDocumentor documentation.
     */
    private function isTypedArray(string $type) : bool
    {
        return substr($type, -2) === self::OPERATOR_ARRAY;
    }

    /**
     * Detects whether the given type represents a PHPDoc keyword.
     *
     * @param string $type A relative or absolute type as defined in the phpDocumentor documentation.
     */
    private function isKeyword(string $type) : bool
    {
        return in_array(strtolower($type), array_keys($this->keywords), true);
    }

    /**
     * Detects whether the given type represents a relative structural element name.
     *
     * @param string $type A relative or absolute type as defined in the phpDocumentor documentation.
     */
    private function isPartialStructuralElementName(string $type) : bool
    {
        return ($type[0] !== self::OPERATOR_NAMESPACE) && !$this->isKeyword($type);
    }

    /**
     * Tests whether the given type is a Fully Qualified Structural Element Name.
     */
    private function isFqsen(string $type) : bool
    {
        return strpos($type, self::OPERATOR_NAMESPACE) === 0;
    }

    /**
     * Resolves the given typed array string (i.e. `string[]`) into an Array object with the right types set.
     */
    private function resolveTypedArray(string $type, Context $context) : Array_
    {
        return new Array_($this->resolveSingleType(substr($type, 0, -2), $context));
    }

    /**
     * Resolves the given keyword (such as `string`) into a Type object representing that keyword.
     */
    private function resolveKeyword(string $type) : Type
    {
        $className = $this->keywords[strtolower($type)];
        return new $className();
    }

    /**
     * Resolves the given FQSEN string into an FQSEN object.
     */
    private function resolveTypedObject(string $type, ?Context $context = null) : Object_
    {
        return new Object_($this->fqsenResolver->resolve($type, $context));
    }

    /**
     * Resolves the collection values and keys
     *
     * @return Array_|Collection
     */
    private function resolveCollection(ArrayIterator $tokens, Type $classType, Context $context) : Type
    {
        $isArray = ((string) $classType === 'array');

        // allow only "array" or class name before "<"
        if (!$isArray
            && (!$classType instanceof Object_ || $classType->getFqsen() === null)) {
            throw new RuntimeException(
                $classType . ' is not a collection'
            );
        }

        $tokens->next();

        $valueType = $this->parseTypes($tokens, $context, self::PARSER_IN_COLLECTION_EXPRESSION);
        $keyType   = null;

        if ($tokens->current() !== null && trim($tokens->current()) === ',') {
            // if we have a comma, then we just parsed the key type, not the value type
            $keyType = $valueType;
            if ($isArray) {
                // check the key type for an "array" collection. We allow only
                // strings or integers.
                if (!$keyType instanceof String_ &&
                    !$keyType instanceof Integer &&
                    !$keyType instanceof Compound
                ) {
                    throw new RuntimeException(
                        'An array can have only integers or strings as keys'
                    );
                }

                if ($keyType instanceof Compound) {
                    foreach ($keyType->getIterator() as $item) {
                        if (!$item instanceof String_ &&
                            !$item instanceof Integer
                        ) {
                            throw new RuntimeException(
                                'An array can have only integers or strings as keys'
                            );
                        }
                    }
                }
            }

            $tokens->next();
            // now let's parse the value type
            $valueType = $this->parseTypes($tokens, $context, self::PARSER_IN_COLLECTION_EXPRESSION);
        }

        if ($tokens->current() !== '>') {
            if (empty($tokens->current())) {
                throw new RuntimeException(
                    'Collection: ">" is missing'
                );
            }

            throw new RuntimeException(
                'Unexpected character "' . $tokens->current() . '", ">" is missing'
            );
        }

        if ($isArray) {
            return new Array_($valueType, $keyType);
        }

        /** @psalm-suppress RedundantCondition */
        if ($classType instanceof Object_) {
            return $this->makeCollectionFromObject($classType, $valueType, $keyType);
        }

        throw new RuntimeException('Invalid $classType provided');
    }

    private function makeCollectionFromObject(Object_ $object, Type $valueType, ?Type $keyType = null) : Collection
    {
        return new Collection($object->getFqsen(), $valueType, $keyType);
    }
}
