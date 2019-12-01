<?php
use JakubOnderka\PhpConsoleColor\ConsoleColor;
use JakubOnderka\PhpConsoleHighlighter\Highlighter;

require __DIR__ . '/../vendor/autoload.php';

$highlighter = new Highlighter(new ConsoleColor());

$fileContent = file_get_contents(__FILE__);
echo $highlighter->getCodeSnippet($fileContent, 3);