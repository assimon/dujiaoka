<?php
/*
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS
 * "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT
 * LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR
 * A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT
 * OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL,
 * SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT
 * LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE,
 * DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
 * (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE
 * OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.
 *
 * This software consists of voluntary contributions made by many individuals
 * and is licensed under the MIT license. For more information, see
 * <http://www.doctrine-project.org>.
 */

namespace Mockery;

use Closure;
use ReflectionClass;
use UnexpectedValueException;
use InvalidArgumentException;

/**
 * This is a trimmed down version of https://github.com/doctrine/instantiator,
 * basically without the caching
 *
 * @author Marco Pivetta <ocramius@gmail.com>
 */
final class Instantiator
{
    /**
     * Markers used internally by PHP to define whether {@see \unserialize} should invoke
     * the method {@see \Serializable::unserialize()} when dealing with classes implementing
     * the {@see \Serializable} interface.
     */
    const SERIALIZATION_FORMAT_USE_UNSERIALIZER   = 'C';
    const SERIALIZATION_FORMAT_AVOID_UNSERIALIZER = 'O';

    /**
     * {@inheritDoc}
     */
    public function instantiate($className)
    {
        $factory    = $this->buildFactory($className);
        $instance   = $factory();

        return $instance;
    }

    /**
     * @internal
     * @private
     *
     * Builds a {@see \Closure} capable of instantiating the given $className without
     * invoking its constructor.
     * This method is only exposed as public because of PHP 5.3 compatibility. Do not
     * use this method in your own code
     *
     * @param string $className
     *
     * @return Closure
     */
    public function buildFactory($className)
    {
        $reflectionClass = $this->getReflectionClass($className);

        if ($this->isInstantiableViaReflection($reflectionClass)) {
            return function () use ($reflectionClass) {
                return $reflectionClass->newInstanceWithoutConstructor();
            };
        }

        $serializedString = sprintf(
            '%s:%d:"%s":0:{}',
            $this->getSerializationFormat($reflectionClass),
            strlen($className),
            $className
        );

        $this->attemptInstantiationViaUnSerialization($reflectionClass, $serializedString);

        return function () use ($serializedString) {
            return unserialize($serializedString);
        };
    }

    /**
     * @param string $className
     *
     * @return ReflectionClass
     *
     * @throws InvalidArgumentException
     */
    private function getReflectionClass($className)
    {
        if (! class_exists($className)) {
            throw new InvalidArgumentException("Class:$className does not exist");
        }

        $reflection = new ReflectionClass($className);

        if ($reflection->isAbstract()) {
            throw new InvalidArgumentException("Class:$className is an abstract class");
        }

        return $reflection;
    }

    /**
     * @param ReflectionClass $reflectionClass
     * @param string          $serializedString
     *
     * @throws UnexpectedValueException
     *
     * @return void
     */
    private function attemptInstantiationViaUnSerialization(ReflectionClass $reflectionClass, $serializedString)
    {
        set_error_handler(function ($code, $message, $file, $line) use ($reflectionClass, & $error) {
            $msg = sprintf(
                'Could not produce an instance of "%s" via un-serialization, since an error was triggered in file "%s" at line "%d"',
                $reflectionClass->getName(),
                $file,
                $line
            );

            $error = new UnexpectedValueException($msg, 0, new \Exception($message, $code));
        });

        try {
            unserialize($serializedString);
        } catch (\Exception $exception) {
            restore_error_handler();

            throw new UnexpectedValueException("An exception was raised while trying to instantiate an instance of \"{$reflectionClass->getName()}\" via un-serialization", 0, $exception);
        }

        restore_error_handler();

        if ($error) {
            throw $error;
        }
    }

    /**
     * @param ReflectionClass $reflectionClass
     *
     * @return bool
     */
    private function isInstantiableViaReflection(ReflectionClass $reflectionClass)
    {
        return ! ($reflectionClass->isInternal() && $reflectionClass->isFinal());
    }

    /**
     * Verifies whether the given class is to be considered internal
     *
     * @param ReflectionClass $reflectionClass
     *
     * @return bool
     */
    private function hasInternalAncestors(ReflectionClass $reflectionClass)
    {
        do {
            if ($reflectionClass->isInternal()) {
                return true;
            }
        } while ($reflectionClass = $reflectionClass->getParentClass());

        return false;
    }

    /**
     * Verifies if the given PHP version implements the `Serializable` interface serialization
     * with an incompatible serialization format. If that's the case, use serialization marker
     * "C" instead of "O".
     *
     * @link http://news.php.net/php.internals/74654
     *
     * @param ReflectionClass $reflectionClass
     *
     * @return string the serialization format marker, either self::SERIALIZATION_FORMAT_USE_UNSERIALIZER
     *                or self::SERIALIZATION_FORMAT_AVOID_UNSERIALIZER
     */
    private function getSerializationFormat(ReflectionClass $reflectionClass)
    {
        if ($this->isPhpVersionWithBrokenSerializationFormat()
            && $reflectionClass->implementsInterface('Serializable')
        ) {
            return self::SERIALIZATION_FORMAT_USE_UNSERIALIZER;
        }

        return self::SERIALIZATION_FORMAT_AVOID_UNSERIALIZER;
    }

    /**
     * Checks whether the current PHP runtime uses an incompatible serialization format
     *
     * @return bool
     */
    private function isPhpVersionWithBrokenSerializationFormat()
    {
        return PHP_VERSION_ID === 50429 || PHP_VERSION_ID === 50513;
    }
}
