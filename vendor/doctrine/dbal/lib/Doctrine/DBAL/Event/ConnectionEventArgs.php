<?php

namespace Doctrine\DBAL\Event;

use Doctrine\Common\EventArgs;
use Doctrine\DBAL\Connection;
use Doctrine\DBAL\Driver;
use Doctrine\DBAL\Platforms\AbstractPlatform;
use Doctrine\DBAL\Schema\AbstractSchemaManager;

/**
 * Event Arguments used when a Driver connection is established inside Doctrine\DBAL\Connection.
 */
class ConnectionEventArgs extends EventArgs
{
    /** @var Connection */
    private $connection;

    public function __construct(Connection $connection)
    {
        $this->connection = $connection;
    }

    /**
     * @return Connection
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @deprecated Use ConnectionEventArgs::getConnection() and Connection::getDriver() instead.
     *
     * @return Driver
     */
    public function getDriver()
    {
        return $this->connection->getDriver();
    }

    /**
     * @deprecated Use ConnectionEventArgs::getConnection() and Connection::getDatabasePlatform() instead.
     *
     * @return AbstractPlatform
     */
    public function getDatabasePlatform()
    {
        return $this->connection->getDatabasePlatform();
    }

    /**
     * @deprecated Use ConnectionEventArgs::getConnection() and Connection::getSchemaManager() instead.
     *
     * @return AbstractSchemaManager
     */
    public function getSchemaManager()
    {
        return $this->connection->getSchemaManager();
    }
}
