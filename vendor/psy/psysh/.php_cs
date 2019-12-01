<?php

$finder = PhpCsFixer\Finder::create()
    ->in(__DIR__)
    ->name('.php_cs')
    ->name('build-manual')
    ->name('build-phar')
    ->exclude('build-vendor');

$header = <<<EOF
This file is part of Psy Shell.

(c) 2012-2018 Justin Hileman

For the full copyright and license information, please view the LICENSE
file that was distributed with this source code.
EOF;

return PhpCsFixer\Config::create()
    ->setRules(array(
        '@Symfony' => true,
        'array_syntax' => array('syntax' => 'short'),
        'binary_operator_spaces' => false,
        'concat_space' => array('spacing' => 'one'),
        'header_comment' => array('header' => $header),
        'increment_style' => array('style' => 'post'),
        'method_argument_space' => array('keep_multiple_spaces_after_comma' => true),
        'ordered_imports' => true,
        'pre_increment' => false,
        'yoda_style' => false,
    ))
    ->setFinder($finder);
