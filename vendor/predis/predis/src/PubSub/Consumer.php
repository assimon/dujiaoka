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

use Predis\ClientException;
use Predis\ClientInterface;
use Predis\Command\Command;
use Predis\Connection\AggregateConnectionInterface;
use Predis\NotSupportedException;

/**
 * PUB/SUB consumer abstraction.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class Consumer extends AbstractConsumer
{
    private $client;
    private $options;

    /**
     * @param ClientInterface $client  Client instance used by the consumer.
     * @param array           $options Options for the consumer initialization.
     */
    public function __construct(ClientInterface $client, array $options = null)
    {
        $this->checkCapabilities($client);

        $this->options = $options ?: array();
        $this->client = $client;

        $this->genericSubscribeInit('subscribe');
        $this->genericSubscribeInit('psubscribe');
    }

    /**
     * Returns the underlying client instance used by the pub/sub iterator.
     *
     * @return ClientInterface
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Checks if the client instance satisfies the required conditions needed to
     * initialize a PUB/SUB consumer.
     *
     * @param ClientInterface $client Client instance used by the consumer.
     *
     * @throws NotSupportedException
     */
    private function checkCapabilities(ClientInterface $client)
    {
        if ($client->getConnection() instanceof AggregateConnectionInterface) {
            throw new NotSupportedException(
                'Cannot initialize a PUB/SUB consumer over aggregate connections.'
            );
        }

        $commands = array('publish', 'subscribe', 'unsubscribe', 'psubscribe', 'punsubscribe');

        if ($client->getProfile()->supportsCommands($commands) === false) {
            throw new NotSupportedException(
                'The current profile does not support PUB/SUB related commands.'
            );
        }
    }

    /**
     * This method shares the logic to handle both SUBSCRIBE and PSUBSCRIBE.
     *
     * @param string $subscribeAction Type of subscription.
     */
    private function genericSubscribeInit($subscribeAction)
    {
        if (isset($this->options[$subscribeAction])) {
            $this->$subscribeAction($this->options[$subscribeAction]);
        }
    }

    /**
     * {@inheritdoc}
     */
    protected function writeRequest($method, $arguments)
    {
        $this->client->getConnection()->writeRequest(
            $this->client->createCommand($method,
                Command::normalizeArguments($arguments)
            )
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function disconnect()
    {
        $this->client->disconnect();
    }

    /**
     * {@inheritdoc}
     */
    protected function getValue()
    {
        $response = $this->client->getConnection()->read();

        switch ($response[0]) {
            case self::SUBSCRIBE:
            case self::UNSUBSCRIBE:
            case self::PSUBSCRIBE:
            case self::PUNSUBSCRIBE:
                if ($response[2] === 0) {
                    $this->invalidate();
                }
                // The missing break here is intentional as we must process
                // subscriptions and unsubscriptions as standard messages.
                // no break

            case self::MESSAGE:
                return (object) array(
                    'kind' => $response[0],
                    'channel' => $response[1],
                    'payload' => $response[2],
                );

            case self::PMESSAGE:
                return (object) array(
                    'kind' => $response[0],
                    'pattern' => $response[1],
                    'channel' => $response[2],
                    'payload' => $response[3],
                );

            case self::PONG:
                return (object) array(
                    'kind' => $response[0],
                    'payload' => $response[1],
                );

            default:
                throw new ClientException(
                    "Unknown message type '{$response[0]}' received in the PUB/SUB context."
                );
        }
    }
}
