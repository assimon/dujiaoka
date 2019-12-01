<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\PubSub;

/**
 * Base implementation of a PUB/SUB consumer abstraction based on PHP iterators.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
abstract class AbstractConsumer implements \Iterator
{
    const SUBSCRIBE = 'subscribe';
    const UNSUBSCRIBE = 'unsubscribe';
    const PSUBSCRIBE = 'psubscribe';
    const PUNSUBSCRIBE = 'punsubscribe';
    const MESSAGE = 'message';
    const PMESSAGE = 'pmessage';
    const PONG = 'pong';

    const STATUS_VALID = 1;       // 0b0001
    const STATUS_SUBSCRIBED = 2;  // 0b0010
    const STATUS_PSUBSCRIBED = 4; // 0b0100

    private $position = null;
    private $statusFlags = self::STATUS_VALID;

    /**
     * Automatically stops the consumer when the garbage collector kicks in.
     */
    public function __destruct()
    {
        $this->stop(true);
    }

    /**
     * Checks if the specified flag is valid based on the state of the consumer.
     *
     * @param int $value Flag.
     *
     * @return bool
     */
    protected function isFlagSet($value)
    {
        return ($this->statusFlags & $value) === $value;
    }

    /**
     * Subscribes to the specified channels.
     *
     * @param mixed $channel,... One or more channel names.
     */
    public function subscribe($channel /*, ... */)
    {
        $this->writeRequest(self::SUBSCRIBE, func_get_args());
        $this->statusFlags |= self::STATUS_SUBSCRIBED;
    }

    /**
     * Unsubscribes from the specified channels.
     *
     * @param string ... One or more channel names.
     */
    public function unsubscribe(/* ... */)
    {
        $this->writeRequest(self::UNSUBSCRIBE, func_get_args());
    }

    /**
     * Subscribes to the specified channels using a pattern.
     *
     * @param mixed $pattern,... One or more channel name patterns.
     */
    public function psubscribe($pattern /* ... */)
    {
        $this->writeRequest(self::PSUBSCRIBE, func_get_args());
        $this->statusFlags |= self::STATUS_PSUBSCRIBED;
    }

    /**
     * Unsubscribes from the specified channels using a pattern.
     *
     * @param string ... One or more channel name patterns.
     */
    public function punsubscribe(/* ... */)
    {
        $this->writeRequest(self::PUNSUBSCRIBE, func_get_args());
    }

    /**
     * PING the server with an optional payload that will be echoed as a
     * PONG message in the pub/sub loop.
     *
     * @param string $payload Optional PING payload.
     */
    public function ping($payload = null)
    {
        $this->writeRequest('PING', array($payload));
    }

    /**
     * Closes the context by unsubscribing from all the subscribed channels. The
     * context can be forcefully closed by dropping the underlying connection.
     *
     * @param bool $drop Indicates if the context should be closed by dropping the connection.
     *
     * @return bool Returns false when there are no pending messages.
     */
    public function stop($drop = false)
    {
        if (!$this->valid()) {
            return false;
        }

        if ($drop) {
            $this->invalidate();
            $this->disconnect();
        } else {
            if ($this->isFlagSet(self::STATUS_SUBSCRIBED)) {
                $this->unsubscribe();
            }
            if ($this->isFlagSet(self::STATUS_PSUBSCRIBED)) {
                $this->punsubscribe();
            }
        }

        return !$drop;
    }

    /**
     * Closes the underlying connection when forcing a disconnection.
     */
    abstract protected function disconnect();

    /**
     * Writes a Redis command on the underlying connection.
     *
     * @param string $method    Command ID.
     * @param array  $arguments Arguments for the command.
     */
    abstract protected function writeRequest($method, $arguments);

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        // NOOP
    }

    /**
     * Returns the last message payload retrieved from the server and generated
     * by one of the active subscriptions.
     *
     * @return array
     */
    public function current()
    {
        return $this->getValue();
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->position;
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        if ($this->valid()) {
            ++$this->position;
        }

        return $this->position;
    }

    /**
     * Checks if the the consumer is still in a valid state to continue.
     *
     * @return bool
     */
    public function valid()
    {
        $isValid = $this->isFlagSet(self::STATUS_VALID);
        $subscriptionFlags = self::STATUS_SUBSCRIBED | self::STATUS_PSUBSCRIBED;
        $hasSubscriptions = ($this->statusFlags & $subscriptionFlags) > 0;

        return $isValid && $hasSubscriptions;
    }

    /**
     * Resets the state of the consumer.
     */
    protected function invalidate()
    {
        $this->statusFlags = 0;    // 0b0000;
    }

    /**
     * Waits for a new message from the server generated by one of the active
     * subscriptions and returns it when available.
     *
     * @return array
     */
    abstract protected function getValue();
}
