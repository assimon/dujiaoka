[![Latest Stable Version](https://poser.pugx.org/phpunit/php-code-coverage/v/stable.png)](https://packagist.org/packages/phpunit/php-code-coverage)
[![Build Status](https://travis-ci.org/sebastianbergmann/php-code-coverage.svg?branch=master)](https://travis-ci.org/sebastianbergmann/php-code-coverage)

# PHP_CodeCoverage

**PHP_CodeCoverage** is a library that provides collection, processing, and rendering functionality for PHP code coverage information.

## Installation

You can add this library as a local, per-project dependency to your project using [Composer](https://getcomposer.org/):

    composer require phpunit/php-code-coverage

If you only need this library during development, for instance to run your project's test suite, then you should add it as a development-time dependency:

    composer require --dev phpunit/php-code-coverage

## Using the PHP_CodeCoverage API

```php
<?php
$coverage = new \SebastianBergmann\CodeCoverage\CodeCoverage;
$coverage->start('<name of test>');

// ...

$coverage->stop();

$writer = new \SebastianBergmann\CodeCoverage\Report\Clover;
$writer->process($coverage, '/tmp/clover.xml');

$writer = new \SebastianBergmann\CodeCoverage\Report\Html\Facade;
$writer->process($coverage, '/tmp/code-coverage-report');
```

