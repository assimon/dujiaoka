<?php

namespace Doctrine\DBAL\Driver\OCI8;

use Doctrine\DBAL\Driver\AbstractDriverException;

class OCI8Exception extends AbstractDriverException
{
    /**
     * @param mixed[]|false $error
     *
     * @return \Doctrine\DBAL\Driver\OCI8\OCI8Exception
     */
    public static function fromErrorInfo($error)
    {
        if ($error === false) {
            return new self('Database error occurred but no error information was retrieved from the driver.');
        }

        return new self($error['message'], null, $error['code']);
    }
}
