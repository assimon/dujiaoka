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

use Predis\ClientContextInterface;
use Predis\ClientException;
use Predis\ClientInterface;
use Predis\Command\CommandInterface;
use Predis\CommunicationException;
use Predis\Connection\AggregateConnectionInterface;
use Predis\NotSupportedException;
use Predis\Protocol\ProtocolException;
use Predis\Response\ErrorInterface as ErrorResponseInterface;
use Predis\Response\ServerException;
use Predis\Response\Status as StatusResponse;

/**
 * Client-side abstraction of a Redis transaction based on MULTI / EXEC.
 *
 * {@inheritdoc}
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class MultiExec implements ClientContextInterface
{
    private $state;

    protected $client;
    protected $commands;
    protected $exceptions = true;
    protected $attempts = 0;
    protected $watchKeys = array();
    protected $modeCAS = false;

    /**
     * @param ClientInterface $client  Client instance used by the transaction.
     * @param array           $options Initialization options.
     */
    public function __construct(ClientInterface $client, array $options = null)
    {
        $this->assertClient($client);

        $this->client = $client;
        $this->state = new MultiExecState();

        $this->configure($client, $options ?: array());
        $this->reset();
    }

    /**
     * Checks if the passed client instance satisfies the required conditions
     * needed to initialize the transaction object.
     *
     * @param ClientInterface $client Client instance used by the transaction object.
     *
     * @throws NotSupportedException
     */
    private function assertClient(ClientInterface $client)
    {
        if ($client->getConnection() instanceof AggregateConnectionInterface) {
            throw new NotSupportedException(
                'Cannot initialize a MULTI/EXEC transaction over aggregate connections.'
            );
        }

        if (!$client->getProfile()->supportsCommands(array('MULTI', 'EXEC', 'DISCARD'))) {
            throw new NotSupportedException(
                'The current profile does not support MULTI, EXEC and DISCARD.'
            );
        }
    }

    /**
     * Configures the transaction using the provided options.
     *
     * @param ClientInterface $client  Underlying client instance.
     * @param array           $options Array of options for the transaction.
     **/
    protected function configure(ClientInterface $client, array $options)
    {
        if (isset($options['exceptions'])) {
            $this->exceptions = (bool) $options['exceptions'];
        } else {
            $this->exceptions = $client->getOptions()->exceptions;
        }

        if (isset($options['cas'])) {
            $this->modeCAS = (bool) $options['cas'];
        }

        if (isset($options['watch']) && $keys = $options['watch']) {
            $this->watchKeys = $keys;
        }

        if (isset($options['retry'])) {
            $this->attempts = (int) $options['retry'];
        }
    }

    /**
     * Resets the state of the transaction.
     */
    protected function reset()
    {
        $this->state->reset();
        $this->commands = new \SplQueue();
    }

    /**
     * Initializes the transaction context.
     */
    protected function initialize()
    {
        if ($this->state->isInitialized()) {
            return;
        }

        if ($this->modeCAS) {
            $this->state->flag(MultiExecState::CAS);
        }

        if ($this->watchKeys) {
            $this->watch($this->watchKeys);
        }

        $cas = $this->state->isCAS();
        $discarded = $this->state->isDiscarded();

        if (!$cas || ($cas && $discarded)) {
            $this->call('MULTI');

            if ($discarded) {
                $this->state->unflag(MultiExecState::CAS);
            }
        }

        $this->state->unflag(MultiExecState::DISCARDED);
        $this->state->flag(MultiExecState::INITIALIZED);
    }

    /**
     * Dynamically invokes a Redis command with the specified arguments.
     *
     * @param string $method    Command ID.
     * @param array  $arguments Arguments for the command.
     *
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        return $this->executeCommand(
            $this->client->createCommand($method, $arguments)
        );
    }

    /**
     * Executes a Redis command bypassing the transaction logic.
     *
     * @param string $commandID Command ID.
     * @param array  $arguments Arguments for the command.
     *
     * @throws ServerException
     *
     * @return mixed
     */
    protected function call($commandID, array $arguments = array())
    {
        $response = $this->client->executeCommand(
            $this->client->createCommand($commandID, $arguments)
        );

        if ($response instanceof ErrorResponseInterface) {
            throw new ServerException($response->getMessage());
        }

        return $response;
    }

    /**
     * Executes the specified Redis command.
     *
     * @param CommandInterface $command Command instance.
     *
     * @throws AbortedMultiExecException
     * @throws CommunicationException
     *
     * @return $this|mixed
     */
    public function executeCommand(CommandInterface $command)
    {
        $this->initialize();

        if ($this->state->isCAS()) {
            return $this->client->executeCommand($command);
        }

        $response = $this->client->getConnection()->executeCommand($command);

        if ($response instanceof StatusResponse && $response == 'QUEUED') {
            $this->commands->enqueue($command);
        } elseif ($response instanceof ErrorResponseInterface) {
            throw new AbortedMultiExecException($this, $response->getMessage());
        } else {
            $this->onProtocolError('The server did not return a +QUEUED status response.');
        }

        return $this;
    }

    /**
     * Executes WATCH against one or more keys.
     *
     * @param string|array $keys One or more keys.
     *
     * @throws NotSupportedException
     * @throws ClientException
     *
     * @return mixed
     */
    public function watch($keys)
    {
        if (!$this->client->getProfile()->supportsCommand('WATCH')) {
            throw new NotSupportedException('WATCH is not supported by the current profile.');
        }

        if ($this->state->isWatchAllowed()) {
            throw new ClientException('Sending WATCH after MULTI is not allowed.');
        }

        $response = $this->call('WATCH', is_array($keys) ? $keys : array($keys));
        $this->state->flag(MultiExecState::WATCH);

        return $response;
    }

    /**
     * Finalizes the transaction by executing MULTI on the server.
     *
     * @return MultiExec
     */
    public function multi()
    {
        if ($this->state->check(MultiExecState::INITIALIZED | MultiExecState::CAS)) {
            $this->state->unflag(MultiExecState::CAS);
            $this->call('MULTI');
        } else {
            $this->initialize();
        }

        return $this;
    }

    /**
     * Executes UNWATCH.
     *
     * @throws NotSupportedException
     *
     * @return MultiExec
     */
    public function unwatch()
    {
        if (!$this->client->getProfile()->supportsCommand('UNWATCH')) {
            throw new NotSupportedException(
                'UNWATCH is not supported by the current profile.'
            );
        }

        $this->state->unflag(MultiExecState::WATCH);
        $this->__call('UNWATCH', array());

        return $this;
    }

    /**
     * Resets the transaction by UNWATCH-ing the keys that are being WATCHed and
     * DISCARD-ing pending commands that have been already sent to the server.
     *
     * @return MultiExec
     */
    public function discard()
    {
        if ($this->state->isInitialized()) {
            $this->call($this->state->isCAS() ? 'UNWATCH' : 'DISCARD');

            $this->reset();
            $this->state->flag(MultiExecState::DISCARDED);
        }

        return $this;
    }

    /**
     * Executes the whole transaction.
     *
     * @return mixed
     */
    public function exec()
    {
        return $this->execute();
    }

    /**
     * Checks the state of the transaction before execution.
     *
     * @param mixed $callable Callback for execution.
     *
     * @throws \InvalidArgumentException
     * @throws ClientException
     */
    private function checkBeforeExecution($callable)
    {
        if ($this->state->isExecuting()) {
            throw new ClientException(
                'Cannot invoke "execute" or "exec" inside an active transaction context.'
            );
        }

        if ($callable) {
            if (!is_callable($callable)) {
                throw new \InvalidArgumentException('The argument must be a callable object.');
            }

            if (!$this->commands->isEmpty()) {
                $this->discard();

                throw new ClientException(
                    'Cannot execute a transaction block after using fluent interface.'
                );
            }
        } elseif ($this->attempts) {
            $this->discard();

            throw new ClientException(
                'Automatic retries are supported only when a callable block is provided.'
            );
        }
    }

    /**
     * Handles the actual execution of the whole transaction.
     *
     * @param mixed $callable Optional callback for execution.
     *
     * @throws CommunicationException
     * @throws AbortedMultiExecException
     * @throws ServerException
     *
     * @return array
     */
    public function execute($callable = null)
    {
        $this->checkBeforeExecution($callable);

        $execResponse = null;
        $attempts = $this->attempts;

        do {
            if ($callable) {
                $this->executeTransactionBlock($callable);
            }

            if ($this->commands->isEmpty()) {
                if ($this->state->isWatching()) {
                    $this->discard();
                }

                return;
            }

            $execResponse = $this->call('EXEC');

            if ($execResponse === null) {
                if ($attempts === 0) {
                    throw new AbortedMultiExecException(
                        $this, 'The current transaction has been aborted by the server.'
                    );
                }

                $this->reset();

                continue;
            }

            break;
        } while ($attempts-- > 0);

        $response = array();
        $commands = $this->commands;
        $size = count($execResponse);

        if ($size !== count($commands)) {
            $this->onProtocolError('EXEC returned an unexpected number of response items.');
        }

        for ($i = 0; $i < $size; ++$i) {
            $cmdResponse = $execResponse[$i];

            if ($cmdResponse instanceof ErrorResponseInterface && $this->exceptions) {
                throw new ServerException($cmdResponse->getMessage());
            }

            $response[$i] = $commands->dequeue()->parseResponse($cmdResponse);
        }

        return $response;
    }

    /**
     * Passes the current transaction object to a callable block for execution.
     *
     * @param mixed $callable Callback.
     *
     * @throws CommunicationException
     * @throws ServerException
     */
    protected function executeTransactionBlock($callable)
    {
        $exception = null;
        $this->state->flag(MultiExecState::INSIDEBLOCK);

        try {
            call_user_func($callable, $this);
        } catch (CommunicationException $exception) {
            // NOOP
        } catch (ServerException $exception) {
            // NOOP
        } catch (\Exception $exception) {
            $this->discard();
        }

        $this->state->unflag(MultiExecState::INSIDEBLOCK);

        if ($exception) {
            throw $exception;
        }
    }

    /**
     * Helper method for protocol errors encountered inside the transaction.
     *
     * @param string $message Error message.
     */
    private function onProtocolError($message)
    {
        // Since a MULTI/EXEC block cannot be initialized when using aggregate
        // connections we can safely assume that Predis\Client::getConnection()
        // will return a Predis\Connection\NodeConnectionInterface instance.
        CommunicationException::handle(new ProtocolException(
            $this->client->getConnection(), $message
        ));
    }
}
