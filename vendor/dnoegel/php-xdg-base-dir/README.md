# XDG Base Directory

[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)

Implementation of XDG Base Directory  specification for php

## Install

Via Composer

``` bash
$ composer require dnoegel/php-xdg-base-dir
```

## Usage

``` php
$xdg = \XdgBaseDir\Xdg();

echo $xdg->getHomeDir();
echo $xdg->getHomeConfigDir()
echo $xdg->getHomeDataDir()
echo $xdg->getHomeCacheDir()
echo $xdg->getRuntimeDir()

$xdg->getDataDirs() // returns array
$xdg->getConfigDirs() // returns array
```

## Testing

``` bash
$ phpunit
```

## License

The MIT License (MIT). Please see [License File](https://github.com/dnoegel/php-xdg-base-dir/blob/master/LICENSE) for more information.
