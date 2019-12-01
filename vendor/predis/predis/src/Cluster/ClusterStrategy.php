<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Cluster;

use Predis\Command\CommandInterface;
use Predis\Command\ScriptCommand;

/**
 * Common class implementing the logic needed to support clustering strategies.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
abstract class ClusterStrategy implements StrategyInterface
{
    protected $commands;

    /**
     *
     */
    public function __construct()
    {
        $this->commands = $this->getDefaultCommands();
    }

    /**
     * Returns the default map of supported commands with their handlers.
     *
     * @return array
     */
    protected function getDefaultCommands()
    {
        $getKeyFromFirstArgument = array($this, 'getKeyFromFirstArgument');
        $getKeyFromAllArguments = array($this, 'getKeyFromAllArguments');

        return array(
            /* commands operating on the key space */
            'EXISTS' => $getKeyFromAllArguments,
            'DEL' => $getKeyFromAllArguments,
            'TYPE' => $getKeyFromFirstArgument,
            'EXPIRE' => $getKeyFromFirstArgument,
            'EXPIREAT' => $getKeyFromFirstArgument,
            'PERSIST' => $getKeyFromFirstArgument,
            'PEXPIRE' => $getKeyFromFirstArgument,
            'PEXPIREAT' => $getKeyFromFirstArgument,
            'TTL' => $getKeyFromFirstArgument,
            'PTTL' => $getKeyFromFirstArgument,
            'SORT' => array($this, 'getKeyFromSortCommand'),
            'DUMP' => $getKeyFromFirstArgument,
            'RESTORE' => $getKeyFromFirstArgument,

            /* commands operating on string values */
            'APPEND' => $getKeyFromFirstArgument,
            'DECR' => $getKeyFromFirstArgument,
            'DECRBY' => $getKeyFromFirstArgument,
            'GET' => $getKeyFromFirstArgument,
            'GETBIT' => $getKeyFromFirstArgument,
            'MGET' => $getKeyFromAllArguments,
            'SET' => $getKeyFromFirstArgument,
            'GETRANGE' => $getKeyFromFirstArgument,
            'GETSET' => $getKeyFromFirstArgument,
            'INCR' => $getKeyFromFirstArgument,
            'INCRBY' => $getKeyFromFirstArgument,
            'INCRBYFLOAT' => $getKeyFromFirstArgument,
            'SETBIT' => $getKeyFromFirstArgument,
            'SETEX' => $getKeyFromFirstArgument,
            'MSET' => array($this, 'getKeyFromInterleavedArguments'),
            'MSETNX' => array($this, 'getKeyFromInterleavedArguments'),
            'SETNX' => $getKeyFromFirstArgument,
            'SETRANGE' => $getKeyFromFirstArgument,
            'STRLEN' => $getKeyFromFirstArgument,
            'SUBSTR' => $getKeyFromFirstArgument,
            'BITOP' => array($this, 'getKeyFromBitOp'),
            'BITCOUNT' => $getKeyFromFirstArgument,
            'BITFIELD' => $getKeyFromFirstArgument,

            /* commands operating on lists */
            'LINSERT' => $getKeyFromFirstArgument,
            'LINDEX' => $getKeyFromFirstArgument,
            'LLEN' => $getKeyFromFirstArgument,
            'LPOP' => $getKeyFromFirstArgument,
            'RPOP' => $getKeyFromFirstArgument,
            'RPOPLPUSH' => $getKeyFromAllArguments,
            'BLPOP' => array($this, 'getKeyFromBlockingListCommands'),
            'BRPOP' => array($this, 'getKeyFromBlockingListCommands'),
            'BRPOPLPUSH' => array($this, 'getKeyFromBlockingListCommands'),
            'LPUSH' => $getKeyFromFirstArgument,
            'LPUSHX' => $getKeyFromFirstArgument,
            'RPUSH' => $getKeyFromFirstArgument,
            'RPUSHX' => $getKeyFromFirstArgument,
            'LRANGE' => $getKeyFromFirstArgument,
            'LREM' => $getKeyFromFirstArgument,
            'LSET' => $getKeyFromFirstArgument,
            'LTRIM' => $getKeyFromFirstArgument,

            /* commands operating on sets */
            'SADD' => $getKeyFromFirstArgument,
            'SCARD' => $getKeyFromFirstArgument,
            'SDIFF' => $getKeyFromAllArguments,
            'SDIFFSTORE' => $getKeyFromAllArguments,
            'SINTER' => $getKeyFromAllArguments,
            'SINTERSTORE' => $getKeyFromAllArguments,
            'SUNION' => $getKeyFromAllArguments,
            'SUNIONSTORE' => $getKeyFromAllArguments,
            'SISMEMBER' => $getKeyFromFirstArgument,
            'SMEMBERS' => $getKeyFromFirstArgument,
            'SSCAN' => $getKeyFromFirstArgument,
            'SPOP' => $getKeyFromFirstArgument,
            'SRANDMEMBER' => $getKeyFromFirstArgument,
            'SREM' => $getKeyFromFirstArgument,

            /* commands operating on sorted sets */
            'ZADD' => $getKeyFromFirstArgument,
            'ZCARD' => $getKeyFromFirstArgument,
            'ZCOUNT' => $getKeyFromFirstArgument,
            'ZINCRBY' => $getKeyFromFirstArgument,
            'ZINTERSTORE' => array($this, 'getKeyFromZsetAggregationCommands'),
            'ZRANGE' => $getKeyFromFirstArgument,
            'ZRANGEBYSCORE' => $getKeyFromFirstArgument,
            'ZRANK' => $getKeyFromFirstArgument,
            'ZREM' => $getKeyFromFirstArgument,
            'ZREMRANGEBYRANK' => $getKeyFromFirstArgument,
            'ZREMRANGEBYSCORE' => $getKeyFromFirstArgument,
            'ZREVRANGE' => $getKeyFromFirstArgument,
            'ZREVRANGEBYSCORE' => $getKeyFromFirstArgument,
            'ZREVRANK' => $getKeyFromFirstArgument,
            'ZSCORE' => $getKeyFromFirstArgument,
            'ZUNIONSTORE' => array($this, 'getKeyFromZsetAggregationCommands'),
            'ZSCAN' => $getKeyFromFirstArgument,
            'ZLEXCOUNT' => $getKeyFromFirstArgument,
            'ZRANGEBYLEX' => $getKeyFromFirstArgument,
            'ZREMRANGEBYLEX' => $getKeyFromFirstArgument,
            'ZREVRANGEBYLEX' => $getKeyFromFirstArgument,

            /* commands operating on hashes */
            'HDEL' => $getKeyFromFirstArgument,
            'HEXISTS' => $getKeyFromFirstArgument,
            'HGET' => $getKeyFromFirstArgument,
            'HGETALL' => $getKeyFromFirstArgument,
            'HMGET' => $getKeyFromFirstArgument,
            'HMSET' => $getKeyFromFirstArgument,
            'HINCRBY' => $getKeyFromFirstArgument,
            'HINCRBYFLOAT' => $getKeyFromFirstArgument,
            'HKEYS' => $getKeyFromFirstArgument,
            'HLEN' => $getKeyFromFirstArgument,
            'HSET' => $getKeyFromFirstArgument,
            'HSETNX' => $getKeyFromFirstArgument,
            'HVALS' => $getKeyFromFirstArgument,
            'HSCAN' => $getKeyFromFirstArgument,
            'HSTRLEN' => $getKeyFromFirstArgument,

            /* commands operating on HyperLogLog */
            'PFADD' => $getKeyFromFirstArgument,
            'PFCOUNT' => $getKeyFromAllArguments,
            'PFMERGE' => $getKeyFromAllArguments,

            /* scripting */
            'EVAL' => array($this, 'getKeyFromScriptingCommands'),
            'EVALSHA' => array($this, 'getKeyFromScriptingCommands'),

            /* commands performing geospatial operations */
            'GEOADD' => $getKeyFromFirstArgument,
            'GEOHASH' => $getKeyFromFirstArgument,
            'GEOPOS' => $getKeyFromFirstArgument,
            'GEODIST' => $getKeyFromFirstArgument,
            'GEORADIUS' => array($this, 'getKeyFromGeoradiusCommands'),
            'GEORADIUSBYMEMBER' => array($this, 'getKeyFromGeoradiusCommands'),
        );
    }

    /**
     * Returns the list of IDs for the supported commands.
     *
     * @return array
     */
    public function getSupportedCommands()
    {
        return array_keys($this->commands);
    }

    /**
     * Sets an handler for the specified command ID.
     *
     * The signature of the callback must have a single parameter of type
     * Predis\Command\CommandInterface.
     *
     * When the callback argument is omitted or NULL, the previously associated
     * handler for the specified command ID is removed.
     *
     * @param string $commandID Command ID.
     * @param mixed  $callback  A valid callable object, or NULL to unset the handler.
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
                'The argument must be a callable object or NULL.'
            );
        }

        $this->commands[$commandID] = $callback;
    }

    /**
     * Extracts the key from the first argument of a command instance.
     *
     * @param CommandInterface $command Command instance.
     *
     * @return string
     */
    protected function getKeyFromFirstArgument(CommandInterface $command)
    {
        return $command->getArgument(0);
    }

    /**
     * Extracts the key from a command with multiple keys only when all keys in
     * the arguments array produce the same hash.
     *
     * @param CommandInterface $command Command instance.
     *
     * @return string|null
     */
    protected function getKeyFromAllArguments(CommandInterface $command)
    {
        $arguments = $command->getArguments();

        if ($this->checkSameSlotForKeys($arguments)) {
            return $arguments[0];
        }
    }

    /**
     * Extracts the key from a command with multiple keys only when all keys in
     * the arguments array produce the same hash.
     *
     * @param CommandInterface $command Command instance.
     *
     * @return string|null
     */
    protected function getKeyFromInterleavedArguments(CommandInterface $command)
    {
        $arguments = $command->getArguments();
        $keys = array();

        for ($i = 0; $i < count($arguments); $i += 2) {
            $keys[] = $arguments[$i];
        }

        if ($this->checkSameSlotForKeys($keys)) {
            return $arguments[0];
        }
    }

    /**
     * Extracts the key from SORT command.
     *
     * @param CommandInterface $command Command instance.
     *
     * @return string|null
     */
    protected function getKeyFromSortCommand(CommandInterface $command)
    {
        $arguments = $command->getArguments();
        $firstKey = $arguments[0];

        if (1 === $argc = count($arguments)) {
            return $firstKey;
        }

        $keys = array($firstKey);

        for ($i = 1; $i < $argc; ++$i) {
            if (strtoupper($arguments[$i]) === 'STORE') {
                $keys[] = $arguments[++$i];
            }
        }

        if ($this->checkSameSlotForKeys($keys)) {
            return $firstKey;
        }
    }

    /**
     * Extracts the key from BLPOP and BRPOP commands.
     *
     * @param CommandInterface $command Command instance.
     *
     * @return string|null
     */
    protected function getKeyFromBlockingListCommands(CommandInterface $command)
    {
        $arguments = $command->getArguments();

        if ($this->checkSameSlotForKeys(array_slice($arguments, 0, count($arguments) - 1))) {
            return $arguments[0];
        }
    }

    /**
     * Extracts the key from BITOP command.
     *
     * @param CommandInterface $command Command instance.
     *
     * @return string|null
     */
    protected function getKeyFromBitOp(CommandInterface $command)
    {
        $arguments = $command->getArguments();

        if ($this->checkSameSlotForKeys(array_slice($arguments, 1, count($arguments)))) {
            return $arguments[1];
        }
    }

    /**
     * Extracts the key from GEORADIUS and GEORADIUSBYMEMBER commands.
     *
     * @param CommandInterface $command Command instance.
     *
     * @return string|null
     */
    protected function getKeyFromGeoradiusCommands(CommandInterface $command)
    {
        $arguments = $command->getArguments();
        $argc = count($arguments);
        $startIndex = $command->getId() === 'GEORADIUS' ? 5 : 4;

        if ($argc > $startIndex) {
            $keys = array($arguments[0]);

            for ($i = $startIndex; $i < $argc; ++$i) {
                $argument = strtoupper($arguments[$i]);
                if ($argument === 'STORE' || $argument === 'STOREDIST') {
                    $keys[] = $arguments[++$i];
                }
            }

            if ($this->checkSameSlotForKeys($keys)) {
                return $arguments[0];
            } else {
                return;
            }
        }

        return $arguments[0];
    }

    /**
     * Extracts the key from ZINTERSTORE and ZUNIONSTORE commands.
     *
     * @param CommandInterface $command Command instance.
     *
     * @return string|null
     */
    protected function getKeyFromZsetAggregationCommands(CommandInterface $command)
    {
        $arguments = $command->getArguments();
        $keys = array_merge(array($arguments[0]), array_slice($arguments, 2, $arguments[1]));

        if ($this->checkSameSlotForKeys($keys)) {
            return $arguments[0];
        }
    }

    /**
     * Extracts the key from EVAL and EVALSHA commands.
     *
     * @param CommandInterface $command Command instance.
     *
     * @return string|null
     */
    protected function getKeyFromScriptingCommands(CommandInterface $command)
    {
        if ($command instanceof ScriptCommand) {
            $keys = $command->getKeys();
        } else {
            $keys = array_slice($args = $command->getArguments(), 2, $args[1]);
        }

        if ($keys && $this->checkSameSlotForKeys($keys)) {
            return $keys[0];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getSlot(CommandInterface $command)
    {
        $slot = $command->getSlot();

        if (!isset($slot) && isset($this->commands[$cmdID = $command->getId()])) {
            $key = call_user_func($this->commands[$cmdID], $command);

            if (isset($key)) {
                $slot = $this->getSlotByKey($key);
                $command->setSlot($slot);
            }
        }

        return $slot;
    }

    /**
     * Checks if the specified array of keys will generate the same hash.
     *
     * @param array $keys Array of keys.
     *
     * @return bool
     */
    protected function checkSameSlotForKeys(array $keys)
    {
        if (!$count = count($keys)) {
            return false;
        }

        $currentSlot = $this->getSlotByKey($keys[0]);

        for ($i = 1; $i < $count; ++$i) {
            $nextSlot = $this->getSlotByKey($keys[$i]);

            if ($currentSlot !== $nextSlot) {
                return false;
            }

            $currentSlot = $nextSlot;
        }

        return true;
    }

    /**
     * Returns only the hashable part of a key (delimited by "{...}"), or the
     * whole key if a key tag is not found in the string.
     *
     * @param string $key A key.
     *
     * @return string
     */
    protected function extractKeyTag($key)
    {
        if (false !== $start = strpos($key, '{')) {
            if (false !== ($end = strpos($key, '}', $start)) && $end !== ++$start) {
                $key = substr($key, $start, $end - $start);
            }
        }

        return $key;
    }
}
