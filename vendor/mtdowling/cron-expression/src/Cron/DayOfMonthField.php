<?php

namespace Cron;

use DateTime;

/**
 * Day of month field.  Allows: * , / - ? L W
 *
 * 'L' stands for "last" and specifies the last day of the month.
 *
 * The 'W' character is used to specify the weekday (Monday-Friday) nearest the
 * given day. As an example, if you were to specify "15W" as the value for the
 * day-of-month field, the meaning is: "the nearest weekday to the 15th of the
 * month". So if the 15th is a Saturday, the trigger will fire on Friday the
 * 14th. If the 15th is a Sunday, the trigger will fire on Monday the 16th. If
 * the 15th is a Tuesday, then it will fire on Tuesday the 15th. However if you
 * specify "1W" as the value for day-of-month, and the 1st is a Saturday, the
 * trigger will fire on Monday the 3rd, as it will not 'jump' over the boundary
 * of a month's days. The 'W' character can only be specified when the
 * day-of-month is a single day, not a range or list of days.
 *
 * @author Michael Dowling <mtdowling@gmail.com>
 */
class DayOfMonthField extends AbstractField
{
    /**
     * Get the nearest day of the week for a given day in a month
     *
     * @param int $currentYear  Current year
     * @param int $currentMonth Current month
     * @param int $targetDay    Target day of the month
     *
     * @return \DateTime Returns the nearest date
     */
    private static function getNearestWeekday($currentYear, $currentMonth, $targetDay)
    {
        $tday = str_pad($targetDay, 2, '0', STR_PAD_LEFT);
        $target = DateTime::createFromFormat('Y-m-d', "$currentYear-$currentMonth-$tday");
        $currentWeekday = (int) $target->format('N');

        if ($currentWeekday < 6) {
            return $target;
        }

        $lastDayOfMonth = $target->format('t');

        foreach (array(-1, 1, -2, 2) as $i) {
            $adjusted = $targetDay + $i;
            if ($adjusted > 0 && $adjusted <= $lastDayOfMonth) {
                $target->setDate($currentYear, $currentMonth, $adjusted);
                if ($target->format('N') < 6 && $target->format('m') == $currentMonth) {
                    return $target;
                }
            }
        }
    }

    public function isSatisfiedBy(DateTime $date, $value)
    {
        // ? states that the field value is to be skipped
        if ($value == '?') {
            return true;
        }

        $fieldValue = $date->format('d');

        // Check to see if this is the last day of the month
        if ($value == 'L') {
            return $fieldValue == $date->format('t');
        }

        // Check to see if this is the nearest weekday to a particular value
        if (strpos($value, 'W')) {
            // Parse the target day
            $targetDay = substr($value, 0, strpos($value, 'W'));
            // Find out if the current day is the nearest day of the week
            return $date->format('j') == self::getNearestWeekday(
                $date->format('Y'),
                $date->format('m'),
                $targetDay
            )->format('j');
        }

        return $this->isSatisfied($date->format('d'), $value);
    }

    public function increment(DateTime $date, $invert = false)
    {
        if ($invert) {
            $date->modify('previous day');
            $date->setTime(23, 59);
        } else {
            $date->modify('next day');
            $date->setTime(0, 0);
        }

        return $this;
    }

    /**
     * Validates that the value is valid for the Day of the Month field
     * Days of the month can contain values of 1-31, *, L, or ? by default. This can be augmented with lists via a ',',
     * ranges via a '-', or with a '[0-9]W' to specify the closest weekday.
     *
     * @param string $value
     * @return bool
     */
    public function validate($value)
    {
        // Allow wildcards and a single L
        if ($value === '?' || $value === '*' || $value === 'L') {
            return true;
        }

        // If you only contain numbers and are within 1-31
        if ((bool) preg_match('/^\d{1,2}$/', $value) && ($value >= 1 && $value <= 31)) {
            return true;
        }

        // If you have a -, we will deal with each of your chunks
        if ((bool) preg_match('/-/', $value)) {
            // We cannot have a range within a list or vice versa
            if ((bool) preg_match('/,/', $value)) {
                return false;
            }

            $chunks = explode('-', $value);
            foreach ($chunks as $chunk) {
                if (!$this->validate($chunk)) {
                    return false;
                }
            }

            return true;
        }

        // If you have a comma, we will deal with each value
        if ((bool) preg_match('/,/', $value)) {
            // We cannot have a range within a list or vice versa
            if ((bool) preg_match('/-/', $value)) {
                return false;
            }

            $chunks = explode(',', $value);
            foreach ($chunks as $chunk) {
                if (!$this->validate($chunk)) {
                    return false;
                }
            }

            return true;
        }

        // If you contain a /, we'll deal with it
        if ((bool) preg_match('/\//', $value)) {
            $chunks = explode('/', $value);
            foreach ($chunks as $chunk) {
                if (!$this->validate($chunk)) {
                    return false;
                }
            }
            return true;
        }

        // If you end in W, make sure that it has a numeric in front of it
        if ((bool) preg_match('/^\d{1,2}W$/', $value)) {
            return true;
        }

        return false;
    }
}
