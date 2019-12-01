<?php

namespace Cron;

use DateTime;


/**
 * Minutes field.  Allows: * , / -
 */
class MinutesField extends AbstractField
{
    public function isSatisfiedBy(DateTime $date, $value)
    {
        return $this->isSatisfied($date->format('i'), $value);
    }

    public function increment(DateTime $date, $invert = false, $parts = null)
    {
        if (is_null($parts)) {
            if ($invert) {
                $date->modify('-1 minute');
            } else {
                $date->modify('+1 minute');
            }
            return $this;
        }

        $parts = strpos($parts, ',') !== false ? explode(',', $parts) : array($parts);
        $minutes = array();
        foreach ($parts as $part) {
            $minutes = array_merge($minutes, $this->getRangeForExpression($part, 59));
        }

        $current_minute = $date->format('i');
        $position = $invert ? count($minutes) - 1 : 0;
        if (count($minutes) > 1) {
            for ($i = 0; $i < count($minutes) - 1; $i++) {
                if ((!$invert && $current_minute >= $minutes[$i] && $current_minute < $minutes[$i + 1]) ||
                    ($invert && $current_minute > $minutes[$i] && $current_minute <= $minutes[$i + 1])) {
                    $position = $invert ? $i : $i + 1;
                    break;
                }
            }
        }

        if ((!$invert && $current_minute >= $minutes[$position]) || ($invert && $current_minute <= $minutes[$position])) {
            $date->modify(($invert ? '-' : '+') . '1 hour');
            $date->setTime($date->format('H'), $invert ? 59 : 0);
        }
        else {
            $date->setTime($date->format('H'), $minutes[$position]);
        }

        return $this;
    }

    public function validate($value)
    {
        return (bool) preg_match('/^[\*,\/\-0-9]+$/', $value);
    }
}
