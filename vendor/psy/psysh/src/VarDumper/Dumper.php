<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\VarDumper;

use Symfony\Component\Console\Formatter\OutputFormatter;
use Symfony\Component\VarDumper\Cloner\Cursor;
use Symfony\Component\VarDumper\Dumper\CliDumper;

/**
 * A PsySH-specialized CliDumper.
 */
class Dumper extends CliDumper
{
    private $formatter;
    private $forceArrayIndexes;

    protected static $onlyControlCharsRx = '/^[\x00-\x1F\x7F]+$/';
    protected static $controlCharsRx     = '/([\x00-\x1F\x7F]+)/';
    protected static $controlCharsMap    = [
        "\0"   => '\0',
        "\t"   => '\t',
        "\n"   => '\n',
        "\v"   => '\v',
        "\f"   => '\f',
        "\r"   => '\r',
        "\033" => '\e',
    ];

    public function __construct(OutputFormatter $formatter, $forceArrayIndexes = false)
    {
        $this->formatter = $formatter;
        $this->forceArrayIndexes = $forceArrayIndexes;
        parent::__construct();
        $this->setColors(false);
    }

    /**
     * {@inheritdoc}
     */
    public function enterHash(Cursor $cursor, $type, $class, $hasChild)
    {
        if (Cursor::HASH_INDEXED === $type || Cursor::HASH_ASSOC === $type) {
            $class = 0;
        }
        parent::enterHash($cursor, $type, $class, $hasChild);
    }

    /**
     * {@inheritdoc}
     */
    protected function dumpKey(Cursor $cursor)
    {
        if ($this->forceArrayIndexes || Cursor::HASH_INDEXED !== $cursor->hashType) {
            parent::dumpKey($cursor);
        }
    }

    protected function style($style, $value, $attr = [])
    {
        if ('ref' === $style) {
            $value = \strtr($value, '@', '#');
        }

        $styled = '';
        $map = self::$controlCharsMap;
        $cchr = $this->styles['cchr'];

        $chunks = \preg_split(self::$controlCharsRx, $value, null, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
        foreach ($chunks as $chunk) {
            if (\preg_match(self::$onlyControlCharsRx, $chunk)) {
                $chars = '';
                $i = 0;
                do {
                    $chars .= isset($map[$chunk[$i]]) ? $map[$chunk[$i]] : \sprintf('\x%02X', \ord($chunk[$i]));
                } while (isset($chunk[++$i]));

                $chars = $this->formatter->escape($chars);
                $styled .= "<{$cchr}>{$chars}</{$cchr}>";
            } else {
                $styled .= $this->formatter->escape($chunk);
            }
        }

        $style = $this->styles[$style];

        return "<{$style}>{$styled}</{$style}>";
    }

    /**
     * {@inheritdoc}
     */
    protected function dumpLine($depth, $endOfValue = false)
    {
        if ($endOfValue && 0 < $depth) {
            $this->line .= ',';
        }
        $this->line = $this->formatter->format($this->line);
        parent::dumpLine($depth, $endOfValue);
    }
}
