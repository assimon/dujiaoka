<?php

namespace Cron;

use DateTime;
use InvalidArgumentException;


/**
 * Day of week field.  Allows: * / , - ? L #
 *
 * Days of the week can be represented as a number 0-7 (0|7 = Sunday)
 * or as a three letter string: SUN, MON, TUE, WED, THU, FRI, SAT.
 *
 * 'L' stands for "last". It allows you to specify constructs such as
 * "the last Friday" of a given month.
 *
 * '#' is allowed for the day-of-week field, and must be followed by a
 * number between one and five. It allows you to specify constructs such as
 * "the second Friday" of a given month.
 */
class DayOfWeekField extends AbstractField
{
    public function isSatisfiedBy(DateTime $date, $value)
    {
        if ($value == '?') {
            return true;
        }

        // Convert text day of the week values to integers
        $value = $this->convertLiterals($value);

        $currentYear = $date->format('Y');
        $currentMonth = $date->format('m');
        $lastDayOfMonth = $date->format('t');

        // Find out if this is the last specific weekday of the month
        if (strpos($value, 'L')) {
            $weekday = str_replace('7', '0', substr($value, 0, strpos($value, 'L')));
            $tdate = clone $date;
            $tdate->setDate($currentYear, $currentMonth, $lastDayOfMonth);
            while ($tdate->format('w') != $weekday) {
                $tdateClone = new DateTime();
                $tdate = $tdateClone
                    ->setTimezone($tdate->getTimezone())
                    ->setDate($currentYear, $currentMonth, --$lastDayOfMonth);
            }

            return $date->format('j') == $lastDayOfMonth;
        }

        // Handle # hash tokens
        if (strpos($value, '#')) {
            list($weekday, $nth) = explode('#', $value);

            // 0 and 7 are both Sunday, however 7 matches date('N') format ISO-8601
            if ($weekday === '0') {
                $weekday = 7;
            }

            // Validate the hash fields
            if ($weekday < 0 || $weekday > 7) {
                throw new InvalidArgumentException("Weekday must be a value between 0 and 7. {$weekday} given");
            }
            if ($nth > 5) {
                throw new InvalidArgumentException('There are never more than 5 of a given weekday in a month');
            }
            // The current weekday must match the targeted weekday to proceed
            if ($date->format('N') != $weekday) {
                return false;
            }

            $tdate = clone $date;
            $tdate->setDate($currentYear, $currentMonth, 1);
            $dayCount = 0;
            $currentDay = 1;
            while ($currentDay < $lastDayOfMonth + 1) {
                if ($tdate->format('N') == $weekday) {
                    if (++$dayCount >= $nth) {
                        break;
                    }
                }
                $tdate->setDate($currentYear, $currentMonth, ++$currentDay);
            }

            return $date->format('j') == $currentDay;
        }

        // Handle day of the week values
        if (strpos($value, '-')) {
            $parts = explode('-', $value);
            if ($parts[0] == '7') {
                $parts[0] = '0';
            } elseif ($parts[1] == '0') {
                $parts[1] = '7';
            }
            $value = implode('-', $parts);
        }

        // Test to see which Sunday to use -- 0 == 7 == Sunday
        $format = in_array(7, str_split($value)) ? 'N' : 'w';
        $fieldValue = $date->format($format);

        return $this->isSatisfied($fieldValue, $value);
    }

    public function increment(DateTime $date, $invert = false)
    {
        if ($invert) {
            $date->modify('-1 day');
            $date->setTime(23, 59, 0);
        } else {
            $date->modify('+1 day');
            $date->setTime(0, 0, 0);
        }

        return $this;
    }

    public function validate($value)
    {
        $value = $this->convertLiterals($value);

        foreach (explode(',', $value) as $expr) {
            if (!preg_match('/^(\*|[0-7](L?|#[1-5]))([\/\,\-][0-7]+)*$/', $expr)) {
                return false;
            }
        }

        return true;
    }

    private function convertLiterals($string)
    {
        return str_ireplace(
            array('SUN', 'MON', 'TUE', 'WED', 'THU', 'FRI', 'SAT'),
            range(0, 6),
            $string
        );
    }
}
