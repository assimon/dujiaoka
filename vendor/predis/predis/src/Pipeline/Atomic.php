<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Pipeline;

use Predis\ClientException;
use Predis\ClientInterface;
use Predis\Connection\ConnectionInterface;
use Predis\Connection\NodeConnectionInterface;
use Predis\Response\ErrorInterface as ErrorResponseInterface;
use Predis\Response\ResponseInterface;
use Predis\Response\ServerException;

/**
 * Command pipeline wrapped into a MULTI / EXEC transaction.
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class Atomic extends Pipeline
{
    /**
     * {@inheritdoc}
     */
    public function __construct(ClientInterface $client)
    {
        if (!$client->getProfile()->supportsCommands(array('multi', 'exec', 'discard'))) {
            throw new ClientException(
                "The current profile does not support 'MULTI', 'EXEC' and 'DISCARD'."
            );
        }

        parent::__construct($client);
    }

    /**
     * {@inheritdoc}
     */
    protected function getConnection()
    {
        $connection = $this->getClient()->getConnection();

        if (!$connection instanceof NodeConnectionInterface) {
            $class = __CLASS__;

            throw new ClientException("The class '$class' does not support aggregate connections.");
        }

        return $connection;
    }

    /**
     * {@inheritdoc}
     */
    protected function executePipeline(ConnectionInterface $connection, \SplQueue $commands)
    {
        $profile = $this->getClient()->getProfile();
        $connection->executeCommand($profile->createCommand('multi'));

        foreach ($commands as $command) {
            $connection->writeRequest($command);
        }

        foreach ($commands as $command) {
            $response = $connection->readResponse($command);

            if ($response instanceof ErrorResponseInterface) {
                $connection->executeCommand($profile->createCommand('discard'));
                throw new ServerException($response->getMessage());
            }
        }

        $executed = $connection->executeCommand($profile->createCommand('exec'));

        if (!isset($executed)) {
            // TODO: should be throwing a more appropriate exception.
            throw new ClientException(
                'The underlying transaction has been aborted by the server.'
            );
        }

        if (count($executed) !== count($commands)) {
            $expected = count($commands);
            $received = count($executed);

            throw new ClientException(
                "Invalid number of responses [expected $expected, received $received]."
            );
        }

        $responses = array();
        $sizeOfPipe = count($commands);
        $exceptions = $this->throwServerExceptions();

        for ($i = 0; $i < $sizeOfPipe; ++$i) {
            $command = $commands->dequeue();
            $response = $executed[$i];

            if (!$response instanceof ResponseInterface) {
                $responses[] = $command->parseResponse($response);
            } elseif ($response instanceof ErrorResponseInterface && $exceptions) {
                $this->exception($connection, $response);
            } else {
                $responses[] = $response;
            }

            unset($executed[$i]);
        }

        return $responses;
    }
}
