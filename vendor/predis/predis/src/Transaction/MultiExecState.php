<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Transaction;

/**
 * Utility class used to track the state of a MULTI / EXEC transaction.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class MultiExecState
{
    const INITIALIZED = 1;    // 0b00001
    const INSIDEBLOCK = 2;    // 0b00010
    const DISCARDED = 4;    // 0b00100
    const CAS = 8;    // 0b01000
    const WATCH = 16;   // 0b10000

    private $flags;

    /**
     *
     */
    public function __construct()
    {
        $this->flags = 0;
    }

    /**
     * Sets the internal state flags.
     *
     * @param int $flags Set of flags
     */
    public function set($flags)
    {
        $this->flags = $flags;
    }

    /**
     * Gets the internal state flags.
     *
     * @return int
     */
    public function get()
    {
        return $this->flags;
    }

    /**
     * Sets one or more flags.
     *
     * @param int $flags Set of flags
     */
    public function flag($flags)
    {
        $this->flags |= $flags;
    }

    /**
     * Resets one or more flags.
     *
     * @param int $flags Set of flags
     */
    public function unflag($flags)
    {
        $this->flags &= ~$flags;
    }

    /**
     * Returns if the specified flag or set of flags is set.
     *
     * @param int $flags Flag
     *
     * @return bool
     */
    public function check($flags)
    {
        return ($this->flags & $flags) === $flags;
    }

    /**
     * Resets the state of a transaction.
     */
    public function reset()
    {
        $this->flags = 0;
    }

    /**
     * Returns the state of the RESET flag.
     *
     * @return bool
     */
    public function isReset()
    {
        return $this->flags === 0;
    }

    /**
     * Returns the state of the INITIALIZED flag.
     *
     * @return bool
     */
    public function isInitialized()
    {
        return $this->check(self::INITIALIZED);
    }

    /**
     * Returns the state of the INSIDEBLOCK flag.
     *
     * @return bool
     */
    public function isExecuting()
    {
        return $this->check(self::INSIDEBLOCK);
    }

    /**
     * Returns the state of the CAS flag.
     *
     * @return bool
     */
    public function isCAS()
    {
        return $this->check(self::CAS);
    }

    /**
     * Returns if WATCH is allowed in the current state.
     *
     * @return bool
     */
    public function isWatchAllowed()
    {
        return $this->check(self::INITIALIZED) && !$this->check(self::CAS);
    }

    /**
     * Returns the state of the WATCH flag.
     *
     * @return bool
     */
    public function isWatching()
    {
        return $this->check(self::WATCH);
    }

    /**
     * Returns the state of the DISCARDED flag.
     *
     * @return bool
     */
    public function isDiscarded()
    {
        return $this->check(self::DISCARDED);
    }
}
