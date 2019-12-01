<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Replication;

use Predis\Command\CommandInterface;
use Predis\NotSupportedException;

/**
 * Defines a strategy for master/slave replication.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class ReplicationStrategy
{
    protected $disallowed;
    protected $readonly;
    protected $readonlySHA1;

    /**
     *
     */
    public function __construct()
    {
        $this->disallowed = $this->getDisallowedOperations();
        $this->readonly = $this->getReadOnlyOperations();
        $this->readonlySHA1 = array();
    }

    /**
     * Returns if the specified command will perform a read-only operation
     * on Redis or not.
     *
     * @param CommandInterface $command Command instance.
     *
     * @throws NotSupportedException
     *
     * @return bool
     */
    public function isReadOperation(CommandInterface $command)
    {
        if (isset($this->disallowed[$id = $command->getId()])) {
            throw new NotSupportedException(
                "The command '$id' is not allowed in replication mode."
            );
        }

        if (isset($this->readonly[$id])) {
            if (true === $readonly = $this->readonly[$id]) {
                return true;
            }

            return call_user_func($readonly, $command);
        }

        if (($eval = $id === 'EVAL') || $id === 'EVALSHA') {
            $sha1 = $eval ? sha1($command->getArgument(0)) : $command->getArgument(0);

            if (isset($this->readonlySHA1[$sha1])) {
                if (true === $readonly = $this->readonlySHA1[$sha1]) {
                    return true;
                }

                return call_user_func($readonly, $command);
            }
        }

        return false;
    }

    /**
     * Returns if the specified command is not allowed for execution in a master
     * / slave replication context.
     *
     * @param CommandInterface $command Command instance.
     *
     * @return bool
     */
    public function isDisallowedOperation(CommandInterface $command)
    {
        return isset($this->disallowed[$command->getId()]);
    }

    /**
     * Checks if a SORT command is a readable operation by parsing the arguments
     * array of the specified commad instance.
     *
     * @param CommandInterface $command Command instance.
     *
     * @return bool
     */
    protected function isSortReadOnly(CommandInterface $command)
    {
        $arguments = $command->getArguments();
        $argc = count($arguments);

        if ($argc > 1) {
            for ($i = 1; $i < $argc; ++$i) {
                $argument = strtoupper($arguments[$i]);
                if ($argument === 'STORE') {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Checks if BITFIELD performs a read-only operation by looking for certain
     * SET and INCRYBY modifiers in the arguments array of the command.
     *
     * @param CommandInterface $command Command instance.
     *
     * @return bool
     */
    protected function isBitfieldReadOnly(CommandInterface $command)
    {
        $arguments = $command->getArguments();
        $argc = count($arguments);

        if ($argc >= 2) {
            for ($i = 1; $i < $argc; ++$i) {
                $argument = strtoupper($arguments[$i]);
                if ($argument === 'SET' || $argument === 'INCRBY') {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Checks if a GEORADIUS command is a readable operation by parsing the
     * arguments array of the specified commad instance.
     *
     * @param CommandInterface $command Command instance.
     *
     * @return bool
     */
    protected function isGeoradiusReadOnly(CommandInterface $command)
    {
        $arguments = $command->getArguments();
        $argc = count($arguments);
        $startIndex = $command->getId() === 'GEORADIUS' ? 5 : 4;

        if ($argc > $startIndex) {
            for ($i = $startIndex; $i < $argc; ++$i) {
                $argument = strtoupper($arguments[$i]);
                if ($argument === 'STORE' || $argument === 'STOREDIST') {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * Marks a command as a read-only operation.
     *
     * When the behavior of a command can be decided only at runtime depending
     * on its arguments, a callable object can be provided to dynamically check
     * if the specified command performs a read or a write operation.
     *
     * @param string $commandID Command ID.
     * @param mixed  $readonly  A boolean value or a callable object.
     */
    public function setCommandReadOnly($commandID, $readonly = true)
    {
        $commandID = strtoupper($commandID);

        if ($readonly) {
            $this->readonly[$commandID] = $readonly;
        } else {
            unset($this->readonly[$commandID]);
        }
    }

    /**
     * Marks a Lua script for EVAL and EVALSHA as a read-only operation. When
     * the behaviour of a script can be decided only at runtime depending on
     * its arguments, a callable object can be provided to dynamically check
     * if the passed instance of EVAL or EVALSHA performs write operations or
     * not.
     *
     * @param string $script   Body of the Lua script.
     * @param mixed  $readonly A boolean value or a callable object.
     */
    public function setScriptReadOnly($script, $readonly = true)
    {
        $sha1 = sha1($script);

        if ($readonly) {
            $this->readonlySHA1[$sha1] = $readonly;
        } else {
            unset($this->readonlySHA1[$sha1]);
        }
    }

    /**
     * Returns the default list of disallowed commands.
     *
     * @return array
     */
    protected function getDisallowedOperations()
    {
        return array(
            'SHUTDOWN' => true,
            'INFO' => true,
            'DBSIZE' => true,
            'LASTSAVE' => true,
            'CONFIG' => true,
            'MONITOR' => true,
            'SLAVEOF' => true,
            'SAVE' => true,
            'BGSAVE' => true,
            'BGREWRITEAOF' => true,
            'SLOWLOG' => true,
        );
    }

    /**
     * Returns the default list of commands performing read-only operations.
     *
     * @return array
     */
    protected function getReadOnlyOperations()
    {
        return array(
            'EXISTS' => true,
            'TYPE' => true,
            'KEYS' => true,
            'SCAN' => true,
            'RANDOMKEY' => true,
            'TTL' => true,
            'GET' => true,
            'MGET' => true,
            'SUBSTR' => true,
            'STRLEN' => true,
            'GETRANGE' => true,
            'GETBIT' => true,
            'LLEN' => true,
            'LRANGE' => true,
            'LINDEX' => true,
            'SCARD' => true,
            'SISMEMBER' => true,
            'SINTER' => true,
            'SUNION' => true,
            'SDIFF' => true,
            'SMEMBERS' => true,
            'SSCAN' => true,
            'SRANDMEMBER' => true,
            'ZRANGE' => true,
            'ZREVRANGE' => true,
            'ZRANGEBYSCORE' => true,
            'ZREVRANGEBYSCORE' => true,
            'ZCARD' => true,
            'ZSCORE' => true,
            'ZCOUNT' => true,
            'ZRANK' => true,
            'ZREVRANK' => true,
            'ZSCAN' => true,
            'ZLEXCOUNT' => true,
            'ZRANGEBYLEX' => true,
            'ZREVRANGEBYLEX' => true,
            'HGET' => true,
            'HMGET' => true,
            'HEXISTS' => true,
            'HLEN' => true,
            'HKEYS' => true,
            'HVALS' => true,
            'HGETALL' => true,
            'HSCAN' => true,
            'HSTRLEN' => true,
            'PING' => true,
            'AUTH' => true,
            'SELECT' => true,
            'ECHO' => true,
            'QUIT' => true,
            'OBJECT' => true,
            'BITCOUNT' => true,
            'BITPOS' => true,
            'TIME' => true,
            'PFCOUNT' => true,
            'SORT' => array($this, 'isSortReadOnly'),
            'BITFIELD' => array($this, 'isBitfieldReadOnly'),
            'GEOHASH' => true,
            'GEOPOS' => true,
            'GEODIST' => true,
            'GEORADIUS' => array($this, 'isGeoradiusReadOnly'),
            'GEORADIUSBYMEMBER' => array($this, 'isGeoradiusReadOnly'),
        );
    }
}
