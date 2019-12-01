<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Readline;

use Hoa\Console\Readline\Readline as HoaReadline;
use Psy\Exception\BreakException;

/**
 * Hoa\Console Readline implementation.
 */
class HoaConsole implements Readline
{
    /** @var HoaReadline */
    private $hoaReadline;

    /**
     * @return bool
     */
    public static function isSupported()
    {
        return \class_exists('\Hoa\Console\Console', true);
    }

    public function __construct()
    {
        $this->hoaReadline = new HoaReadline();
    }

    /**
     * {@inheritdoc}
     */
    public function addHistory($line)
    {
        $this->hoaReadline->addHistory($line);

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function clearHistory()
    {
        $this->hoaReadline->clearHistory();

        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function listHistory()
    {
        $i = 0;
        $list = [];
        while (($item = $this->hoaReadline->getHistory($i++)) !== null) {
            $list[] = $item;
        }

        return $list;
    }

    /**
     * {@inheritdoc}
     */
    public function readHistory()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     *
     * @throws BreakException if user hits Ctrl+D
     *
     * @return string
     */
    public function readline($prompt = null)
    {
        return $this->hoaReadline->readLine($prompt);
    }

    /**
     * {@inheritdoc}
     */
    public function redisplay()
    {
        // noop
    }

    /**
     * {@inheritdoc}
     */
    public function writeHistory()
    {
        return true;
    }
}
