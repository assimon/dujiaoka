<?php

/*
 * This file is part of the Predis package.
 *
 * (c) Daniele Alessandri <suppakilla@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Predis\Command;

/**
 * @link http://redis.io/commands/info
 *
 * @author Daniele Alessandri <suppakilla@gmail.com>
 */
class ServerInfo extends Command
{
    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return 'INFO';
    }

    /**
     * {@inheritdoc}
     */
    public function parseResponse($data)
    {
        $info = array();
        $infoLines = preg_split('/\r?\n/', $data);

        foreach ($infoLines as $row) {
            if (strpos($row, ':') === false) {
                continue;
            }

            list($k, $v) = $this->parseRow($row);
            $info[$k] = $v;
        }

        return $info;
    }

    /**
     * Parses a single row of the response and returns the key-value pair.
     *
     * @param string $row Single row of the response.
     *
     * @return array
     */
    protected function parseRow($row)
    {
        list($k, $v) = explode(':', $row, 2);

        if (preg_match('/^db\d+$/', $k)) {
            $v = $this->parseDatabaseStats($v);
        }

        return array($k, $v);
    }

    /**
     * Extracts the statistics of each logical DB from the string buffer.
     *
     * @param string $str Response buffer.
     *
     * @return array
     */
    protected function parseDatabaseStats($str)
    {
        $db = array();

        foreach (explode(',', $str) as $dbvar) {
            list($dbvk, $dbvv) = explode('=', $dbvar);
            $db[trim($dbvk)] = $dbvv;
        }

        return $db;
    }

    /**
     * Parses the response and extracts the allocation statistics.
     *
     * @param string $str Response buffer.
     *
     * @return array
     */
    protected function parseAllocationStats($str)
    {
        $stats = array();

        foreach (explode(',', $str) as $kv) {
            @list($size, $objects, $extra) = explode('=', $kv);

            // hack to prevent incorrect values when parsing the >=256 key
            if (isset($extra)) {
                $size = ">=$objects";
                $objects = $extra;
            }

            $stats[$size] = $objects;
        }

        return $stats;
    }
}
