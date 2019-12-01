"""
vis.py
======

Ctypes based module to access libbsd's strvis & strunvis functions.

The `vis` function is the equivalent of strvis.
The `unvis` function is the equivalent of strunvis.
All functions accept unicode string as input and return a unicode string.

Constants:
----------

* to select alternate encoding format
  `VIS_OCTAL`:      use octal \ddd format
  `VIS_CSTYLE`:     use \[nrft0..] where appropiate

* to alter set of characters encoded
  (default is to encode all non-graphic except space, tab, and newline).
  `VIS_SP`:         also encode space
  `VIS_TAB`:        also encode tab
  `VIS_NL`:         also encode newline
  `VIS_WHITE`:      same as (VIS_SP | VIS_TAB | VIS_NL)
  `VIS_SAFE`:       only encode "unsafe" characters

* other
  `VIS_NOSLASH`:    inhibit printing '\'
  `VIS_HTTP1808`:   http-style escape % hex hex
  `VIS_HTTPSTYLE`:  http-style escape % hex hex
  `VIS_MIMESTYLE`:  mime-style escape = HEX HEX
  `VIS_HTTP1866`:   http-style &#num; or &string;
  `VIS_NOESCAPE`:   don't decode `\'
  `VIS_GLOB`:       encode glob(3) magic characters

:Authors:
    - ju1ius (http://github.com/ju1ius)
:Version: 1
:Date: 2014-01-05
"""
from ctypes import CDLL, c_char_p, c_int
from ctypes.util import find_library


__all__ = [
    'vis', 'unvis',
    'VIS_OCTAL', 'VIS_CSTYLE',
    'VIS_SP', 'VIS_TAB', 'VIS_NL', 'VIS_WHITE', 'VIS_SAFE',
    'VIS_NOSLASH', 'VIS_HTTP1808', 'VIS_HTTPSTYLE', 'VIS_MIMESTYLE',
    'VIS_HTTP1866', 'VIS_NOESCAPE', 'VIS_GLOB'
]


#############################################################
# Constants from bsd/vis.h
#############################################################

#to select alternate encoding format
VIS_OCTAL = 0x0001
VIS_CSTYLE = 0x0002
# to alter set of characters encoded
# (default is to encode all non-graphic except space, tab, and newline).
VIS_SP = 0x0004
VIS_TAB = 0x0008
VIS_NL = 0x0010
VIS_WHITE = VIS_SP | VIS_TAB | VIS_NL
VIS_SAFE = 0x0020
# other
VIS_NOSLASH = 0x0040
VIS_HTTP1808 = 0x0080
VIS_HTTPSTYLE = 0x0080
VIS_MIMESTYLE = 0x0100
VIS_HTTP1866 = 0x0200
VIS_NOESCAPE = 0x0400
VIS_GLOB = 0x1000

#############################################################
# Import libbsd/vis functions
#############################################################

_libbsd = CDLL(find_library('bsd'))

_strvis = _libbsd.strvis
_strvis.argtypes = [c_char_p, c_char_p, c_int]
_strvis.restype = c_int

_strunvis = _libbsd.strunvis
_strvis.argtypes = [c_char_p, c_char_p]
_strvis.restype = c_int


def vis(src, flags=VIS_WHITE):
    """
    Encodes the string `src` into libbsd's vis encoding.
    `flags` must be one of the VIS_* constants

    C definition:
    int strvis(char *dst, char *src, int flags);
    """
    src = bytes(src, 'utf-8')
    dst_p = c_char_p(bytes(len(src) * 4))
    src_p = c_char_p(src)
    flags = c_int(flags)

    bytes_written = _strvis(dst_p, src_p, flags)
    if -1 == bytes_written:
        raise RuntimeError('vis failed to encode string "{}"'.format(src))

    return dst_p.value.decode('utf-8')


def unvis(src):
    """
    Decodes a string encoded by vis.

    C definition:
    int strunvis(char *dst, char *src);
    """
    src = bytes(src, 'utf-8')
    dst_p = c_char_p(bytes(len(src)))
    src_p = c_char_p(src)

    bytes_written = _strunvis(dst_p, src_p)
    if -1 == bytes_written:
        raise RuntimeError('unvis failed to decode string "{}"'.format(src))

    return dst_p.value.decode('utf-8')
