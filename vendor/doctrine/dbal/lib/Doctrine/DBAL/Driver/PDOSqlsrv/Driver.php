<?php

namespace Doctrine\DBAL\Driver\PDOSqlsrv;

use Doctrine\DBAL\Driver\AbstractSQLServerDriver;
use function is_int;
use function sprintf;

/**
 * The PDO-based Sqlsrv driver.
 */
class Driver extends AbstractSQLServerDriver
{
    /**
     * {@inheritdoc}
     */
    public function connect(array $params, $username = null, $password = null, array $driverOptions = [])
    {
        $pdoOptions = $dsnOptions = [];

        foreach ($driverOptions as $option => $value) {
            if (is_int($option)) {
                $pdoOptions[$option] = $value;
            } else {
                $dsnOptions[$option] = $value;
            }
        }

        return new Connection(
            $this->_constructPdoDsn($params, $dsnOptions),
            $username,
            $password,
            $pdoOptions
        );
    }

    /**
     * Constructs the Sqlsrv PDO DSN.
     *
     * @param mixed[]  $params
     * @param string[] $connectionOptions
     *
     * @return string The DSN.
     */
    private function _constructPdoDsn(array $params, array $connectionOptions)
    {
        $dsn = 'sqlsrv:server=';

        if (isset($params['host'])) {
            $dsn .= $params['host'];
        }

        if (isset($params['port']) && ! empty($params['port'])) {
            $dsn .= ',' . $params['port'];
        }

        if (isset($params['dbname'])) {
            $connectionOptions['Database'] = $params['dbname'];
        }

        if (isset($params['MultipleActiveResultSets'])) {
            $connectionOptions['MultipleActiveResultSets'] = $params['MultipleActiveResultSets'] ? 'true' : 'false';
        }

        return $dsn . $this->getConnectionOptionsDsn($connectionOptions);
    }

    /**
     * Converts a connection options array to the DSN
     *
     * @param string[] $connectionOptions
     */
    private function getConnectionOptionsDsn(array $connectionOptions) : string
    {
        $connectionOptionsDsn = '';

        foreach ($connectionOptions as $paramName => $paramValue) {
            $connectionOptionsDsn .= sprintf(';%s=%s', $paramName, $paramValue);
        }

        return $connectionOptionsDsn;
    }

    /**
     * {@inheritdoc}
     *
     * @deprecated
     */
    public function getName()
    {
        return 'pdo_sqlsrv';
    }
}
