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
 * Method-dispatcher loop built around the client-side abstraction of a Redis
 * PUB / SUB context.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class DispatcherLoop
{
    private $pubsub;

    protected $callbacks;
    protected $defaultCallback;
    protected $subscriptionCallback;

    /**
     * @param Consumer $pubsub PubSub consumer instance used by the loop.
     */
    public function __construct(Consumer $pubsub)
    {
        $this->callbacks = array();
        $this->pubsub = $pubsub;
    }

    /**
     * Checks if the passed argument is a valid callback.
     *
     * @param mixed $callable A callback.
     *
     * @throws \InvalidArgumentException
     */
    protected function assertCallback($callable)
    {
        if (!is_callable($callable)) {
            throw new \InvalidArgumentException('The given argument must be a callable object.');
        }
    }

    /**
     * Returns the underlying PUB / SUB context.
     *
     * @return Consumer
     */
    public function getPubSubConsumer()
    {
        return $this->pubsub;
    }

    /**
     * Sets a callback that gets invoked upon new subscriptions.
     *
     * @param mixed $callable A callback.
     */
    public function subscriptionCallback($callable = null)
    {
        if (isset($callable)) {
            $this->assertCallback($callable);
        }

        $this->subscriptionCallback = $callable;
    }

    /**
     * Sets a callback that gets invoked when a message is received on a
     * channel that does not have an associated callback.
     *
     * @param mixed $callable A callback.
     */
    public function defaultCallback($callable = null)
    {
        if (isset($callable)) {
            $this->assertCallback($callable);
        }

        $this->subscriptionCallback = $callable;
    }

    /**
     * Binds a callback to a channel.
     *
     * @param string   $channel  Channel name.
     * @param callable $callback A callback.
     */
    public function attachCallback($channel, $callback)
    {
        $callbackName = $this->getPrefixKeys().$channel;

        $this->assertCallback($callback);
        $this->callbacks[$callbackName] = $callback;
        $this->pubsub->subscribe($channel);
    }

    /**
     * Stops listening to a channel and removes the associated callback.
     *
     * @param string $channel Redis channel.
     */
    public function detachCallback($channel)
    {
        $callbackName = $this->getPrefixKeys().$channel;

        if (isset($this->callbacks[$callbackName])) {
            unset($this->callbacks[$callbackName]);
            $this->pubsub->unsubscribe($channel);
        }
    }

    /**
     * Starts the dispatcher loop.
     */
    public function run()
    {
        foreach ($this->pubsub as $message) {
            $kind = $message->kind;

            if ($kind !== Consumer::MESSAGE && $kind !== Consumer::PMESSAGE) {
                if (isset($this->subscriptionCallback)) {
                    $callback = $this->subscriptionCallback;
                    call_user_func($callback, $message);
                }

                continue;
            }

            if (isset($this->callbacks[$message->channel])) {
                $callback = $this->callbacks[$message->channel];
                call_user_func($callback, $message->payload);
            } elseif (isset($this->defaultCallback)) {
                $callback = $this->defaultCallback;
                call_user_func($callback, $message);
            }
        }
    }

    /**
     * Terminates the dispatcher loop.
     */
    public function stop()
    {
        $this->pubsub->stop();
    }

    /**
     * Return the prefix used for keys.
     *
     * @return string
     */
    protected function getPrefixKeys()
    {
        $options = $this->pubsub->getClient()->getOptions();

        if (isset($options->prefix)) {
            return $options->prefix->getPrefix();
        }

        return '';
    }
}
