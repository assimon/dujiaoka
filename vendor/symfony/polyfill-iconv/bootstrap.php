<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

use Symfony\Polyfill\Iconv as p;

if (!function_exists('iconv')) {
    define('ICONV_IMPL', 'Symfony');
    define('ICONV_VERSION', '1.0');
    define('ICONV_MIME_DECODE_STRICT', 1);
    define('ICONV_MIME_DECODE_CONTINUE_ON_ERROR', 2);

    function iconv($from, $to, $s) { return p\Iconv::iconv($from, $to, $s); }
    function iconv_get_encoding($type = 'all') { return p\Iconv::iconv_get_encoding($type); }
    function iconv_set_encoding($type, $charset) { return p\Iconv::iconv_set_encoding($type, $charset); }
    function iconv_mime_encode($name, $value, $pref = null) { return p\Iconv::iconv_mime_encode($name, $value, $pref); }
    function iconv_mime_decode_headers($encodedHeaders, $mode = 0, $enc = null) { return p\Iconv::iconv_mime_decode_headers($encodedHeaders, $mode, $enc); }

    if (extension_loaded('mbstring')) {
        function iconv_strlen($s, $enc = null) { null === $enc and $enc = p\Iconv::$internalEncoding; return mb_strlen($s, $enc); }
        function iconv_strpos($s, $needle, $offset = 0, $enc = null) { null === $enc and $enc = p\Iconv::$internalEncoding; return mb_strpos($s, $needle, $offset, $enc); }
        function iconv_strrpos($s, $needle, $enc = null) { null === $enc and $enc = p\Iconv::$internalEncoding; return mb_strrpos($s, $needle, 0, $enc); }
        function iconv_substr($s, $start, $length = 2147483647, $enc = null) { null === $enc and $enc = p\Iconv::$internalEncoding; return mb_substr($s, $start, $length, $enc); }
        function iconv_mime_decode($encodedHeaders, $mode = 0, $enc = null) { null === $enc and $enc = p\Iconv::$internalEncoding; return mb_decode_mimeheader($encodedHeaders, $mode, $enc); }
    } else {
        if (extension_loaded('xml')) {
            function iconv_strlen($s, $enc = null) { return p\Iconv::strlen1($s, $enc); }
        } else {
            function iconv_strlen($s, $enc = null) { return p\Iconv::strlen2($s, $enc); }
        }

        function iconv_strpos($s, $needle, $offset = 0, $enc = null) { return p\Iconv::iconv_strpos($s, $needle, $offset, $enc); }
        function iconv_strrpos($s, $needle, $enc = null) { return p\Iconv::iconv_strrpos($s, $needle, $enc); }
        function iconv_substr($s, $start, $length = 2147483647, $enc = null) { return p\Iconv::iconv_substr($s, $start, $length, $enc); }
        function iconv_mime_decode($encodedHeaders, $mode = 0, $enc = null) { return p\Iconv::iconv_mime_decode($encodedHeaders, $mode, $enc); }
    }
}
