<?php

/*
 * This file is part of Psy Shell.
 *
 * (c) 2012-2018 Justin Hileman
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Psy\Util;

/**
 * String utility methods.
 *
 * @author ju1ius
 */
class Str
{
    const UNVIS_RX = <<<'EOS'
/
    \\(?:
        ((?:040)|s)
        | (240)
        | (?: M-(.) )
        | (?: M\^(.) )
        | (?: \^(.) )
    )
/xS
EOS;

    /**
     * Decodes a string encoded by libsd's strvis.
     *
     * From `man 3 vis`:
     *
     * Use an ‘M’ to represent meta characters (characters with the 8th bit set),
     * and use a caret ‘^’ to represent control characters (see iscntrl(3)).
     * The following formats are used:
     *
     *      \040    Represents ASCII space.
     *
     *      \240    Represents Meta-space (&nbsp in HTML).
     *
     *      \M-C    Represents character ‘C’ with the 8th bit set.
     *              Spans characters ‘\241’ through ‘\376’.
     *
     *      \M^C    Represents control character ‘C’ with the 8th bit set.
     *              Spans characters ‘\200’ through ‘\237’, and ‘\377’ (as ‘\M^?’).
     *
     *      \^C     Represents the control character ‘C’.
     *              Spans characters ‘\000’ through ‘\037’, and ‘\177’ (as ‘\^?’).
     *
     * The other formats are supported by PHP's stripcslashes,
     * except for the \s sequence (ASCII space).
     *
     * @param string $input The string to decode
     *
     * @return string
     */
    public static function unvis($input)
    {
        $output = \preg_replace_callback(self::UNVIS_RX, 'self::unvisReplace', $input);
        // other escapes & octal are handled by stripcslashes
        return \stripcslashes($output);
    }

    /**
     * Callback for Str::unvis.
     *
     * @param array $match The matches passed by preg_replace_callback
     *
     * @return string
     */
    protected static function unvisReplace($match)
    {
        // \040, \s
        if (!empty($match[1])) {
            return "\x20";
        }
        // \240
        if (!empty($match[2])) {
            return "\xa0";
        }
        // \M-(.)
        if (isset($match[3]) && $match[3] !== '') {
            $chr = $match[3];
            // unvis S_META1
            $cp = 0200;
            $cp |= \ord($chr);

            return \chr($cp);
        }
        // \M^(.)
        if (isset($match[4]) && $match[4] !== '') {
            $chr = $match[4];
            // unvis S_META | S_CTRL
            $cp = 0200;
            $cp |= ($chr === '?') ? 0177 : \ord($chr) & 037;

            return \chr($cp);
        }
        // \^(.)
        if (isset($match[5]) && $match[5] !== '') {
            $chr = $match[5];
            // unvis S_CTRL
            $cp = 0;
            $cp |= ($chr === '?') ? 0177 : \ord($chr) & 037;

            return \chr($cp);
        }
    }
}
