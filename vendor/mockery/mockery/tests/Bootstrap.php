<?php
/**
 * Mockery
 *
 * LICENSE
 *
 * This source file is subject to the new BSD license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://github.com/padraic/mockery/master/LICENSE
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to padraic@php.net so we can send you a copy immediately.
 *
 * @category   Mockery
 * @package    Mockery
 * @subpackage UnitTests
 * @copyright  Copyright (c) 2010 Pádraic Brady (http://blog.astrumfutura.com)
 * @license    http://github.com/padraic/mockery/blob/master/LICENSE New BSD License
 */

/*
 * Set error reporting to the level to which Mockery code must comply.
 */
error_reporting(E_ALL);

function isAbsolutePath($path)
{
    $windowsPattern = '~^[A-Z]:[\\/]~i';
    return ($path[0] === DIRECTORY_SEPARATOR) || (preg_match($windowsPattern, $path) === 1);
}

$root    = realpath(dirname(dirname(__FILE__)));
$composerVendorDirectory = getenv("COMPOSER_VENDOR_DIR") ?: "vendor";

if (!isAbsolutePath($composerVendorDirectory)) {
    $composerVendorDirectory = $root . DIRECTORY_SEPARATOR . $composerVendorDirectory;
}

/**
 * Check that composer installation was done
 */
$autoloadPath = $composerVendorDirectory . DIRECTORY_SEPARATOR . 'autoload.php';
if (!file_exists($autoloadPath)) {
    throw new Exception(
        'Please run "php composer.phar install" in root directory '
        . 'to setup unit test dependencies before running the tests'
    );
}

require_once $autoloadPath;

$hamcrestRelativePath = 'hamcrest/hamcrest-php/hamcrest/Hamcrest.php';
if (DIRECTORY_SEPARATOR !== '/') {
    $hamcrestRelativePath = str_replace('/', DIRECTORY_SEPARATOR, $hamcrestRelativePath);
}
$hamcrestPath = $composerVendorDirectory . DIRECTORY_SEPARATOR . $hamcrestRelativePath;

require_once $hamcrestPath;

Mockery::globalHelpers();

/*
 * Unset global variables that are no longer needed.
 */
unset($root, $autoloadPath, $hamcrestPath, $composerVendorDirectory);
