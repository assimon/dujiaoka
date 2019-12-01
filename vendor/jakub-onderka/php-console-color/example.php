<?php
$loader = require_once __DIR__ . '/vendor/autoload.php';

$consoleColor = new JakubOnderka\PhpConsoleColor\ConsoleColor();

echo "Colors are supported: " . ($consoleColor->isSupported() ? 'Yes' : 'No') . "\n";
echo "256 colors are supported: " . ($consoleColor->are256ColorsSupported() ? 'Yes' : 'No') . "\n\n";

if ($consoleColor->isSupported()) {
    foreach ($consoleColor->getPossibleStyles() as $style) {
        echo $consoleColor->apply($style, $style) . "\n";
    }
}

echo "\n";

if ($consoleColor->are256ColorsSupported()) {
    echo "Foreground colors:\n";
    for ($i = 1; $i <= 255; $i++) {
        echo $consoleColor->apply("color_$i", str_pad($i, 6, ' ', STR_PAD_BOTH));

        if ($i % 15 === 0) {
            echo "\n";
        }
    }

    echo "\nBackground colors:\n";

    for ($i = 1; $i <= 255; $i++) {
        echo $consoleColor->apply("bg_color_$i", str_pad($i, 6, ' ', STR_PAD_BOTH));

        if ($i % 15 === 0) {
            echo "\n";
        }
    }

    echo "\n";
}
