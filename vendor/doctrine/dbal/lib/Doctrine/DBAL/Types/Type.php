<?php

namespace Doctrine\DBAL\Types;

use Doctrine\DBAL\DBALException;
use Doctrine\DBAL\ParameterType;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use function array_map;
use function get_class;
use function str_replace;
use function strrpos;
use function substr;

/**
 * The base class for so-called Doctrine mapping types.
 *
 * A Type object is obtained by calling the static {@link getType()} method.
 */
abstract class Type
{
    /** @deprecated Use {@see DefaultTypes::BIGINT} instead. */
    public const BIGINT = Types::BIGINT;

    /** @deprecated Use {@see DefaultTypes::BINARY} instead. */
    public const BINARY = Types::BINARY;

    /** @deprecated Use {@see DefaultTypes::BLOB} instead. */
    public const BLOB = Types::BLOB;

    /** @deprecated Use {@see DefaultTypes::BOOLEAN} instead. */
    public const BOOLEAN = Types::BOOLEAN;

    /** @deprecated Use {@see DefaultTypes::DATE_MUTABLE} instead. */
    public const DATE = Types::DATE_MUTABLE;

    /** @deprecated Use {@see DefaultTypes::DATE_IMMUTABLE} instead. */
    public const DATE_IMMUTABLE = Types::DATE_IMMUTABLE;

    /** @deprecated Use {@see DefaultTypes::DATEINTERVAL} instead. */
    public const DATEINTERVAL = Types::DATEINTERVAL;

    /** @deprecated Use {@see DefaultTypes::DATETIME_MUTABLE} instead. */
    public const DATETIME = Types::DATETIME_MUTABLE;

    /** @deprecated Use {@see DefaultTypes::DATETIME_IMMUTABLE} instead. */
    public const DATETIME_IMMUTABLE = Types::DATETIME_IMMUTABLE;

    /** @deprecated Use {@see DefaultTypes::DATETIMETZ_MUTABLE} instead. */
    public const DATETIMETZ = Types::DATETIMETZ_MUTABLE;

    /** @deprecated Use {@see DefaultTypes::DATETIMETZ_IMMUTABLE} instead. */
    public const DATETIMETZ_IMMUTABLE = Types::DATETIMETZ_IMMUTABLE;

    /** @deprecated Use {@see DefaultTypes::DECIMAL} instead. */
    public const DECIMAL = Types::DECIMAL;

    /** @deprecated Use {@see DefaultTypes::FLOAT} instead. */
    public const FLOAT = Types::FLOAT;

    /** @deprecated Use {@see DefaultTypes::GUID} instead. */
    public const GUID = Types::GUID;

    /** @deprecated Use {@see DefaultTypes::INTEGER} instead. */
    public const INTEGER = Types::INTEGER;

    /** @deprecated Use {@see DefaultTypes::JSON} instead. */
    public const JSON = Types::JSON;

    /** @deprecated Use {@see DefaultTypes::JSON_ARRAY} instead. */
    public const JSON_ARRAY = Types::JSON_ARRAY;

    /** @deprecated Use {@see DefaultTypes::OBJECT} instead. */
    public const OBJECT = Types::OBJECT;

    /** @deprecated Use {@see DefaultTypes::SIMPLE_ARRAY} instead. */
    public const SIMPLE_ARRAY = Types::SIMPLE_ARRAY;

    /** @deprecated Use {@see DefaultTypes::SMALLINT} instead. */
    public const SMALLINT = Types::SMALLINT;

    /** @deprecated Use {@see DefaultTypes::STRING} instead. */
    public const STRING = Types::STRING;

    /** @deprecated Use {@see DefaultTypes::ARRAY} instead. */
    public const TARRAY = Types::ARRAY;

    /** @deprecated Use {@see DefaultTypes::TEXT} instead. */
    public const TEXT = Types::TEXT;

    /** @deprecated Use {@see DefaultTypes::TIME_MUTABLE} instead. */
    public const TIME = Types::TIME_MUTABLE;

    /** @deprecated Use {@see DefaultTypes::TIME_IMMUTABLE} instead. */
    public const TIME_IMMUTABLE = Types::TIME_IMMUTABLE;

    /**
     * The map of supported doctrine mapping types.
     */
    private const BUILTIN_TYPES_MAP = [
        Types::ARRAY                => ArrayType::class,
        Types::BIGINT               => BigIntType::class,
        Types::BINARY               => BinaryType::class,
        Types::BLOB                 => BlobType::class,
        Types::BOOLEAN              => BooleanType::class,
        Types::DATE_MUTABLE         => DateType::class,
        Types::DATE_IMMUTABLE       => DateImmutableType::class,
        Types::DATEINTERVAL         => DateIntervalType::class,
        Types::DATETIME_MUTABLE     => DateTimeType::class,
        Types::DATETIME_IMMUTABLE   => DateTimeImmutableType::class,
        Types::DATETIMETZ_MUTABLE   => DateTimeTzType::class,
        Types::DATETIMETZ_IMMUTABLE => DateTimeTzImmutableType::class,
        Types::DECIMAL              => DecimalType::class,
        Types::FLOAT                => FloatType::class,
        Types::GUID                 => GuidType::class,
        Types::INTEGER              => IntegerType::class,
        Types::JSON                 => JsonType::class,
        Types::JSON_ARRAY           => JsonArrayType::class,
        Types::OBJECT               => ObjectType::class,
        Types::SIMPLE_ARRAY         => SimpleArrayType::class,
        Types::SMALLINT             => SmallIntType::class,
        Types::STRING               => StringType::class,
        Types::TEXT                 => TextType::class,
        Types::TIME_MUTABLE         => TimeType::class,
        Types::TIME_IMMUTABLE       => TimeImmutableType::class,
    ];

    /** @var TypeRegistry|null */
    private static $typeRegistry;

    /**
     * @internal Do not instantiate directly - use {@see Type::addType()} method instead.
     */
    final public function __construct()
    {
    }

    /**
     * Converts a value from its PHP representation to its database representation
     * of this type.
     *
     * @param mixed            $value    The value to convert.
     * @param AbstractPlatform $platform The currently used database platform.
     *
     * @return mixed The database representation of the value.
     */
    public function convertToDatabaseValue($value, AbstractPlatform $platform)
    {
        return $value;
    }

    /**
     * Converts a value from its database representation to its PHP representation
     * of this type.
     *
     * @param mixed            $value    The value to convert.
     * @param AbstractPlatform $platform The currently used database platform.
     *
     * @return mixed The PHP representation of the value.
     */
    public function convertToPHPValue($value, AbstractPlatform $platform)
    {
        return $value;
    }

    /**
     * Gets the default length of this type.
     *
     * @deprecated Rely on information provided by the platform instead.
     *
     * @return int|null
     */
    public function getDefaultLength(AbstractPlatform $platform)
    {
        return null;
    }

    /**
     * Gets the SQL declaration snippet for a field of this type.
     *
     * @param mixed[]          $fieldDeclaration The field declaration.
     * @param AbstractPlatform $platform         The currently used database platform.
     *
     * @return string
     */
    abstract public function getSQLDeclaration(array $fieldDeclaration, AbstractPlatform $platform);

    /**
     * Gets the name of this type.
     *
     * @return string
     *
     * @todo Needed?
     */
    abstract public function getName();

    /**
     * @internal This method is only to be used within DBAL for forward compatibility purposes. Do not use directly.
     */
    final public static function getTypeRegistry() : TypeRegistry
    {
        if (self::$typeRegistry === null) {
            self::$typeRegistry = self::createTypeRegistry();
        }

        return self::$typeRegistry;
    }

    private static function createTypeRegistry() : TypeRegistry
    {
        $registry = new TypeRegistry();

        foreach (self::BUILTIN_TYPES_MAP as $name => $class) {
            $registry->register($name, new $class());
        }

        return $registry;
    }

    /**
     * Factory method to create type instances.
     * Type instances are implemented as flyweights.
     *
     * @param string $name The name of the type (as returned by getName()).
     *
     * @return \Doctrine\DBAL\Types\Type
     *
     * @throws DBALException
     */
    public static function getType($name)
    {
        return self::getTypeRegistry()->get($name);
    }

    /**
     * Adds a custom type to the type map.
     *
     * @param string $name      The name of the type. This should correspond to what getName() returns.
     * @param string $className The class name of the custom type.
     *
     * @return void
     *
     * @throws DBALException
     */
    public static function addType($name, $className)
    {
        self::getTypeRegistry()->register($name, new $className());
    }

    /**
     * Checks if exists support for a type.
     *
     * @param string $name The name of the type.
     *
     * @return bool TRUE if type is supported; FALSE otherwise.
     */
    public static function hasType($name)
    {
        return self::getTypeRegistry()->has($name);
    }

    /**
     * Overrides an already defined type to use a different implementation.
     *
     * @param string $name
     * @param string $className
     *
     * @return void
     *
     * @throws DBALException
     */
    public static function overrideType($name, $className)
    {
        self::getTypeRegistry()->override($name, new $className());
    }

    /**
     * Gets the (preferred) binding type for values of this type that
     * can be used when binding parameters to prepared statements.
     *
     * This method should return one of the {@link \Doctrine\DBAL\ParameterType} constants.
     *
     * @return int
     */
    public function getBindingType()
    {
        return ParameterType::STRING;
    }

    /**
     * Gets the types array map which holds all registered types and the corresponding
     * type class
     *
     * @return string[]
     */
    public static function getTypesMap()
    {
        return array_map(
            static function (Type $type) : string {
                return get_class($type);
            },
            self::getTypeRegistry()->getMap()
        );
    }

    /**
     * @deprecated Relying on string representation is discouraged and will be removed in DBAL 3.0.
     *
     * @return string
     */
    public function __toString()
    {
        $type     = static::class;
        $position = strrpos($type, '\\');

        if ($position !== false) {
            $type = substr($type, $position);
        }

        return str_replace('Type', '', $type);
    }

    /**
     * Does working with this column require SQL conversion functions?
     *
     * This is a metadata function that is required for example in the ORM.
     * Usage of {@link convertToDatabaseValueSQL} and
     * {@link convertToPHPValueSQL} works for any type and mostly
     * does nothing. This method can additionally be used for optimization purposes.
     *
     * @return bool
     */
    public function canRequireSQLConversion()
    {
        return false;
    }

    /**
     * Modifies the SQL expression (identifier, parameter) to convert to a database value.
     *
     * @param string $sqlExpr
     *
     * @return string
     */
    public function convertToDatabaseValueSQL($sqlExpr, AbstractPlatform $platform)
    {
        return $sqlExpr;
    }

    /**
     * Modifies the SQL expression (identifier, parameter) to convert to a PHP value.
     *
     * @param string           $sqlExpr
     * @param AbstractPlatform $platform
     *
     * @return string
     */
    public function convertToPHPValueSQL($sqlExpr, $platform)
    {
        return $sqlExpr;
    }

    /**
     * Gets an array of database types that map to this Doctrine type.
     *
     * @return string[]
     */
    public function getMappedDatabaseTypes(AbstractPlatform $platform)
    {
        return [];
    }

    /**
     * If this Doctrine Type maps to an already mapped database type,
     * reverse schema engineering can't tell them apart. You need to mark
     * one of those types as commented, which will have Doctrine use an SQL
     * comment to typehint the actual Doctrine Type.
     *
     * @return bool
     */
    public function requiresSQLCommentHint(AbstractPlatform $platform)
    {
        return false;
    }
}
