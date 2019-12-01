<?php

use Symfony\CS\Config\Config;
use Symfony\CS\Finder\DefaultFinder;

if (class_exists('PhpCsFixer\Finder')) {    // PHP-CS-Fixer 2.x
    $finder = PhpCsFixer\Finder::create()->in([
        'library',
        'tests',
    ]);

    return PhpCsFixer\Config::create()
        ->setRules(array(
            '@PSR2' => true,
        ))
		->setUsingCache(true)
        ->setFinder($finder)
    ;
}

$finder = DefaultFinder::create()->in(
    [
        'library',
        'tests',
    ]);

return Config::create()
    ->level('psr2')
    ->setUsingCache(true)
    ->finder($finder);
