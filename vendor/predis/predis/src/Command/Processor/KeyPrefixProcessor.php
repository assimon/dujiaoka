<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Command\Processor;

use Predis\Command\CommandInterface;
use Predis\Command\PrefixableCommandInterface;

/**
 * Command processor capable of prefixing keys stored in the arguments of Redis
 * commands supported.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class KeyPrefixProcessor implements ProcessorInterface
{
    private $prefix;
    private $commands;

    /**
     * @param string $prefix Prefix for the keys.
     */
    public function __construct($prefix)
    {
        $this->prefix = $prefix;
        $this->commands = array(
            /* ---------------- Redis 1.2 ---------------- */
            'EXISTS' => 'static::all',
            'DEL' => 'static::all',
            'TYPE' => 'static::first',
            'KEYS' => 'static::first',
            'RENAME' => 'static::all',
            'RENAMENX' => 'static::all',
            'EXPIRE' => 'static::first',
            'EXPIREAT' => 'static::first',
            'TTL' => 'static::first',
            'MOVE' => 'static::first',
            'SORT' => 'static::sort',
            'DUMP' => 'static::first',
            'RESTORE' => 'static::first',
            'SET' => 'static::first',
            'SETNX' => 'static::first',
            'MSET' => 'static::interleaved',
            'MSETNX' => 'static::interleaved',
            'GET' => 'static::first',
            'MGET' => 'static::all',
            'GETSET' => 'static::first',
            'INCR' => 'static::first',
            'INCRBY' => 'static::first',
            'DECR' => 'static::first',
            'DECRBY' => 'static::first',
            'RPUSH' => 'static::first',
            'LPUSH' => 'static::first',
            'LLEN' => 'static::first',
            'LRANGE' => 'static::first',
            'LTRIM' => 'static::first',
            'LINDEX' => 'static::first',
            'LSET' => 'static::first',
            'LREM' => 'static::first',
            'LPOP' => 'static::first',
            'RPOP' => 'static::first',
            'RPOPLPUSH' => 'static::all',
            'SADD' => 'static::first',
            'SREM' => 'static::first',
            'SPOP' => 'static::first',
            'SMOVE' => 'static::skipLast',
            'SCARD' => 'static::first',
            'SISMEMBER' => 'static::first',
            'SINTER' => 'static::all',
            'SINTERSTORE' => 'static::all',
            'SUNION' => 'static::all',
            'SUNIONSTORE' => 'static::all',
            'SDIFF' => 'static::all',
            'SDIFFSTORE' => 'static::all',
            'SMEMBERS' => 'static::first',
            'SRANDMEMBER' => 'static::first',
            'ZADD' => 'static::first',
            'ZINCRBY' => 'static::first',
            'ZREM' => 'static::first',
            'ZRANGE' => 'static::first',
            'ZREVRANGE' => 'static::first',
            'ZRANGEBYSCORE' => 'static::first',
            'ZCARD' => 'static::first',
            'ZSCORE' => 'static::first',
            'ZREMRANGEBYSCORE' => 'static::first',
            /* ---------------- Redis 2.0 ---------------- */
            'SETEX' => 'static::first',
            'APPEND' => 'static::first',
            'SUBSTR' => 'static::first',
            'BLPOP' => 'static::skipLast',
            'BRPOP' => 'static::skipLast',
            'ZUNIONSTORE' => 'static::zsetStore',
            'ZINTERSTORE' => 'static::zsetStore',
            'ZCOUNT' => 'static::first',
            'ZRANK' => 'static::first',
            'ZREVRANK' => 'static::first',
            'ZREMRANGEBYRANK' => 'static::first',
            'HSET' => 'static::first',
            'HSETNX' => 'static::first',
            'HMSET' => 'static::first',
            'HINCRBY' => 'static::first',
            'HGET' => 'static::first',
            'HMGET' => 'static::first',
            'HDEL' => 'static::first',
            'HEXISTS' => 'static::first',
            'HLEN' => 'static::first',
            'HKEYS' => 'static::first',
            'HVALS' => 'static::first',
            'HGETALL' => 'static::first',
            'SUBSCRIBE' => 'static::all',
            'UNSUBSCRIBE' => 'static::all',
            'PSUBSCRIBE' => 'static::all',
            'PUNSUBSCRIBE' => 'static::all',
            'PUBLISH' => 'static::first',
            /* ---------------- Redis 2.2 ---------------- */
            'PERSIST' => 'static::first',
            'STRLEN' => 'static::first',
            'SETRANGE' => 'static::first',
            'GETRANGE' => 'static::first',
            'SETBIT' => 'static::first',
            'GETBIT' => 'static::first',
            'RPUSHX' => 'static::first',
            'LPUSHX' => 'static::first',
            'LINSERT' => 'static::first',
            'BRPOPLPUSH' => 'static::skipLast',
            'ZREVRANGEBYSCORE' => 'static::first',
            'WATCH' => 'static::all',
            /* ---------------- Redis 2.6 ---------------- */
            'PTTL' => 'static::first',
            'PEXPIRE' => 'static::first',
            'PEXPIREAT' => 'static::first',
            'PSETEX' => 'static::first',
            'INCRBYFLOAT' => 'static::first',
            'BITOP' => 'static::skipFirst',
            'BITCOUNT' => 'static::first',
            'HINCRBYFLOAT' => 'static::first',
            'EVAL' => 'static::evalKeys',
            'EVALSHA' => 'static::evalKeys',
            'MIGRATE' => 'static::migrate',
            /* ---------------- Redis 2.8 ---------------- */
            'SSCAN' => 'static::first',
            'ZSCAN' => 'static::first',
            'HSCAN' => 'static::first',
            'PFADD' => 'static::first',
            'PFCOUNT' => 'static::all',
            'PFMERGE' => 'static::all',
            'ZLEXCOUNT' => 'static::first',
            'ZRANGEBYLEX' => 'static::first',
            'ZREMRANGEBYLEX' => 'static::first',
            'ZREVRANGEBYLEX' => 'static::first',
            'BITPOS' => 'static::first',
            /* ---------------- Redis 3.2 ---------------- */
            'HSTRLEN' => 'static::first',
            'BITFIELD' => 'static::first',
            'GEOADD' => 'static::first',
            'GEOHASH' => 'static::first',
            'GEOPOS' => 'static::first',
            'GEODIST' => 'static::first',
            'GEORADIUS' => 'static::georadius',
            'GEORADIUSBYMEMBER' => 'static::georadius',
        );
    }

    /**
     * Sets a prefix that is applied to all the keys.
     *
     * @param string $prefix Prefix for the keys.
     */
    public function setPrefix($prefix)
    {
        $this->prefix = $prefix;
    }

    /**
     * Gets the current prefix.
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * {@inheritdoc}
     */
    public function process(CommandInterface $command)
    {
        if ($command instanceof PrefixableCommandInterface) {
            $command->prefixKeys($this->prefix);
        } elseif (isset($this->commands[$commandID = strtoupper($command->getId())])) {
            call_user_func($this->commands[$commandID], $command, $this->prefix);
        }
    }

    /**
     * Sets an handler for the specified command ID.
     *
     * The callback signature must have 2 parameters of the following types:
     *
     *   - Predis\Command\CommandInterface (command instance)
     *   - String (prefix)
     *
     * When the callback argument is omitted or NULL, the previously
     * associated handler for the specified command ID is removed.
     *
     * @param string $commandID The ID of the command to be handled.
     * @param mixed  $callback  A valid callable object or NULL.
     *
     * @throws \InvalidArgumentException
     */
    public function setCommandHandler($commandID, $callback = null)
    {
        $commandID = strtoupper($commandID);

        if (!isset($callback)) {
            unset($this->commands[$commandID]);

            return;
        }

        if (!is_callable($callback)) {
            throw new \InvalidArgumentException(
                'Callback must be a valid callable object or NULL'
            );
        }

        $this->commands[$commandID] = $callback;
    }

    /**
     * {@inheritdoc}
     */
    public function __toString()
    {
        return $this->getPrefix();
    }

    /**
     * Applies the specified prefix only the first argument.
     *
     * @param CommandInterface $command Command instance.
     * @param string           $prefix  Prefix string.
     */
    public static function first(CommandInterface $command, $prefix)
    {
        if ($arguments = $command->getArguments()) {
            $arguments[0] = "$prefix{$arguments[0]}";
            $command->setRawArguments($arguments);
        }
    }

    /**
     * Applies the specified prefix to all the arguments.
     *
     * @param CommandInterface $command Command instance.
     * @param string           $prefix  Prefix string.
     */
    public static function all(CommandInterface $command, $prefix)
    {
        if ($arguments = $command->getArguments()) {
            foreach ($arguments as &$key) {
                $key = "$prefix$key";
            }

            $command->setRawArguments($arguments);
        }
    }

    /**
     * Applies the specified prefix only to even arguments in the list.
     *
     * @param CommandInterface $command Command instance.
     * @param string           $prefix  Prefix string.
     */
    public static function interleaved(CommandInterface $command, $prefix)
    {
        if ($arguments = $command->getArguments()) {
            $length = count($arguments);

            for ($i = 0; $i < $length; $i += 2) {
                $arguments[$i] = "$prefix{$arguments[$i]}";
            }

            $command->setRawArguments($arguments);
        }
    }

    /**
     * Applies the specified prefix to all the arguments but the first one.
     *
     * @param CommandInterface $command Command instance.
     * @param string           $prefix  Prefix string.
     */
    public static function skipFirst(CommandInterface $command, $prefix)
    {
        if ($arguments = $command->getArguments()) {
            $length = count($arguments);

            for ($i = 1; $i < $length; ++$i) {
                $arguments[$i] = "$prefix{$arguments[$i]}";
            }

            $command->setRawArguments($arguments);
        }
    }

    /**
     * Applies the specified prefix to all the arguments but the last one.
     *
     * @param CommandInterface $command Command instance.
     * @param string           $prefix  Prefix string.
     */
    public static function skipLast(CommandInterface $command, $prefix)
    {
        if ($arguments = $command->getArguments()) {
            $length = count($arguments);

            for ($i = 0; $i < $length - 1; ++$i) {
                $arguments[$i] = "$prefix{$arguments[$i]}";
            }

            $command->setRawArguments($arguments);
        }
    }

    /**
     * Applies the specified prefix to the keys of a SORT command.
     *
     * @param CommandInterface $command Command instance.
     * @param string           $prefix  Prefix string.
     */
    public static function sort(CommandInterface $command, $prefix)
    {
        if ($arguments = $command->getArguments()) {
            $arguments[0] = "$prefix{$arguments[0]}";

            if (($count = count($arguments)) > 1) {
                for ($i = 1; $i < $count; ++$i) {
                    switch (strtoupper($arguments[$i])) {
                        case 'BY':
                        case 'STORE':
                            $arguments[$i] = "$prefix{$arguments[++$i]}";
                            break;

                        case 'GET':
                            $value = $arguments[++$i];
                            if ($value !== '#') {
                                $arguments[$i] = "$prefix$value";
                            }
                            break;

                        case 'LIMIT';
                            $i += 2;
                            break;
                    }
                }
            }

            $command->setRawArguments($arguments);
        }
    }

    /**
     * Applies the specified prefix to the keys of an EVAL-based command.
     *
     * @param CommandInterface $command Command instance.
     * @param string           $prefix  Prefix string.
     */
    public static function evalKeys(CommandInterface $command, $prefix)
    {
        if ($arguments = $command->getArguments()) {
            for ($i = 2; $i < $arguments[1] + 2; ++$i) {
                $arguments[$i] = "$prefix{$arguments[$i]}";
            }

            $command->setRawArguments($arguments);
        }
    }

    /**
     * Applies the specified prefix to the keys of Z[INTERSECTION|UNION]STORE.
     *
     * @param CommandInterface $command Command instance.
     * @param string           $prefix  Prefix string.
     */
    public static function zsetStore(CommandInterface $command, $prefix)
    {
        if ($arguments = $command->getArguments()) {
            $arguments[0] = "$prefix{$arguments[0]}";
            $length = ((int) $arguments[1]) + 2;

            for ($i = 2; $i < $length; ++$i) {
                $arguments[$i] = "$prefix{$arguments[$i]}";
            }

            $command->setRawArguments($arguments);
        }
    }

    /**
     * Applies the specified prefix to the key of a MIGRATE command.
     *
     * @param CommandInterface $command Command instance.
     * @param string           $prefix  Prefix string.
     */
    public static function migrate(CommandInterface $command, $prefix)
    {
        if ($arguments = $command->getArguments()) {
            $arguments[2] = "$prefix{$arguments[2]}";
            $command->setRawArguments($arguments);
        }
    }

    /**
     * Applies the specified prefix to the key of a GEORADIUS command.
     *
     * @param CommandInterface $command Command instance.
     * @param string           $prefix  Prefix string.
     */
    public static function georadius(CommandInterface $command, $prefix)
    {
        if ($arguments = $command->getArguments()) {
            $arguments[0] = "$prefix{$arguments[0]}";
            $startIndex = $command->getId() === 'GEORADIUS' ? 5 : 4;

            if (($count = count($arguments)) > $startIndex) {
                for ($i = $startIndex; $i < $count; ++$i) {
                    switch (strtoupper($arguments[$i])) {
                        case 'STORE':
                        case 'STOREDIST':
                            $arguments[$i] = "$prefix{$arguments[++$i]}";
                            break;

                    }
                }
            }

            $command->setRawArguments($arguments);
        }
    }
}
