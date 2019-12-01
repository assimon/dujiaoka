<?php
/*
 * This file is part of sebastian/global-state.
 *
 * (c) Sebastian Bergmann <sebastian@phpunit.de>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace SebastianBergmann\GlobalState;

/**
 * Exports parts of a Snapshot as PHP code.
 */
class CodeExporter
{
    public function constants(Snapshot $snapshot): string
    {
        $result = '';

        foreach ($snapshot->constants() as $name => $value) {
            $result .= \sprintf(
                'if (!defined(\'%s\')) define(\'%s\', %s);' . "\n",
                $name,
                $name,
                $this->exportVariable($value)
            );
        }

        return $result;
    }

    public function globalVariables(Snapshot $snapshot): string
    {
        $result = '$GLOBALS = [];' . PHP_EOL;

        foreach ($snapshot->globalVariables() as $name => $value) {
            $result .= \sprintf(
                '$GLOBALS[%s] = %s;' . PHP_EOL,
                $this->exportVariable($name),
                $this->exportVariable($value)
            );
        }

        return $result;
    }

    public function iniSettings(Snapshot $snapshot): string
    {
        $result = '';

        foreach ($snapshot->iniSettings() as $key => $value) {
            $result .= \sprintf(
                '@ini_set(%s, %s);' . "\n",
                $this->exportVariable($key),
                $this->exportVariable($value)
            );
        }

        return $result;
    }

    private function exportVariable($variable): string
    {
        if (\is_scalar($variable) || \is_null($variable) ||
            (\is_array($variable) && $this->arrayOnlyContainsScalars($variable))) {
            return \var_export($variable, true);
        }

        return 'unserialize(' . \var_export(\serialize($variable), true) . ')';
    }

    private function arrayOnlyContainsScalars(array $array): bool
    {
        $result = true;

        foreach ($array as $element) {
            if (\is_array($element)) {
                $result = self::arrayOnlyContainsScalars($element);
            } elseif (!\is_scalar($element) && !\is_null($element)) {
                $result = false;
            }

            if ($result === false) {
                break;
            }
        }

        return $result;
    }
}
