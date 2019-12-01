<?php

namespace Cron;

use DateTime;
use DateTimeImmutable;
use DateTimeZone;
use Exception;
use InvalidArgumentException;
use RuntimeException;

/**
 * CRON expression parser that can determine whether or not a CRON expression is
 * due to run, the next run date and previous run date of a CRON expression.
 * The determinations made by this class are accurate if checked run once per
 * minute (seconds are dropped from date time comparisons).
 *
 * Schedule parts must map to:
 * minute [0-59], hour [0-23], day of month, month [1-12|JAN-DEC], day of week
 * [1-7|MON-SUN], and an optional year.
 *
 * @link http://en.wikipedia.org/wiki/Cron
 */
class CronExpression
{
    const MINUTE = 0;
    const HOUR = 1;
    const DAY = 2;
    const MONTH = 3;
    const WEEKDAY = 4;
    const YEAR = 5;

    /**
     * @var array CRON expression parts
     */
    private $cronParts;

    /**
     * @var FieldFactory CRON field factory
     */
    private $fieldFactory;

    /**
     * @var int Max iteration count when searching for next run date
     */
    private $maxIterationCount = 1000;

    /**
     * @var array Order in which to test of cron parts
     */
    private static $order = array(self::YEAR, self::MONTH, self::DAY, self::WEEKDAY, self::HOUR, self::MINUTE);

    /**
     * Factory method to create a new CronExpression.
     *
     * @param string $expression The CRON expression to create.  There are
     *                           several special predefined values which can be used to substitute the
     *                           CRON expression:
     *
     *      `@yearly`, `@annually` - Run once a year, midnight, Jan. 1 - 0 0 1 1 *
     *      `@monthly` - Run once a month, midnight, first of month - 0 0 1 * *
     *      `@weekly` - Run once a week, midnight on Sun - 0 0 * * 0
     *      `@daily` - Run once a day, midnight - 0 0 * * *
     *      `@hourly` - Run once an hour, first minute - 0 * * * *
     * @param FieldFactory $fieldFactory Field factory to use
     *
     * @return CronExpression
     */
    public static function factory($expression, FieldFactory $fieldFactory = null)
    {
        $mappings = array(
            '@yearly' => '0 0 1 1 *',
            '@annually' => '0 0 1 1 *',
            '@monthly' => '0 0 1 * *',
            '@weekly' => '0 0 * * 0',
            '@daily' => '0 0 * * *',
            '@hourly' => '0 * * * *'
        );

        if (isset($mappings[$expression])) {
            $expression = $mappings[$expression];
        }

        return new static($expression, $fieldFactory ?: new FieldFactory());
    }

    /**
     * Validate a CronExpression.
     *
     * @param string $expression The CRON expression to validate.
     *
     * @return bool True if a valid CRON expression was passed. False if not.
     * @see \Cron\CronExpression::factory
     */
    public static function isValidExpression($expression)
    {
        try {
            self::factory($expression);
        } catch (InvalidArgumentException $e) {
            return false;
        }

        return true;
    }

    /**
     * Parse a CRON expression
     *
     * @param string       $expression   CRON expression (e.g. '8 * * * *')
     * @param FieldFactory $fieldFactory Factory to create cron fields
     */
    public function __construct($expression, FieldFactory $fieldFactory)
    {
        $this->fieldFactory = $fieldFactory;
        $this->setExpression($expression);
    }

    /**
     * Set or change the CRON expression
     *
     * @param string $value CRON expression (e.g. 8 * * * *)
     *
     * @return CronExpression
     * @throws \InvalidArgumentException if not a valid CRON expression
     */
    public function setExpression($value)
    {
        $this->cronParts = preg_split('/\s/', $value, -1, PREG_SPLIT_NO_EMPTY);
        if (count($this->cronParts) < 5) {
            throw new InvalidArgumentException(
                $value . ' is not a valid CRON expression'
            );
        }

        foreach ($this->cronParts as $position => $part) {
            $this->setPart($position, $part);
        }

        return $this;
    }

    /**
     * Set part of the CRON expression
     *
     * @param int    $position The position of the CRON expression to set
     * @param string $value    The value to set
     *
     * @return CronExpression
     * @throws \InvalidArgumentException if the value is not valid for the part
     */
    public function setPart($position, $value)
    {
        if (!$this->fieldFactory->getField($position)->validate($value)) {
            throw new InvalidArgumentException(
                'Invalid CRON field value ' . $value . ' at position ' . $position
            );
        }

        $this->cronParts[$position] = $value;

        return $this;
    }

    /**
     * Set max iteration count for searching next run dates
     *
     * @param int $maxIterationCount Max iteration count when searching for next run date
     *
     * @return CronExpression
     */
    public function setMaxIterationCount($maxIterationCount)
    {
        $this->maxIterationCount = $maxIterationCount;
        
        return $this;
    }

    /**
     * Get a next run date relative to the current date or a specific date
     *
     * @param string|\DateTime $currentTime      Relative calculation date
     * @param int              $nth              Number of matches to skip before returning a
     *                                           matching next run date.  0, the default, will return the current
     *                                           date and time if the next run date falls on the current date and
     *                                           time.  Setting this value to 1 will skip the first match and go to
     *                                           the second match.  Setting this value to 2 will skip the first 2
     *                                           matches and so on.
     * @param bool             $allowCurrentDate Set to TRUE to return the current date if
     *                                           it matches the cron expression.
     *
     * @return \DateTime
     * @throws \RuntimeException on too many iterations
     */
    public function getNextRunDate($currentTime = 'now', $nth = 0, $allowCurrentDate = false)
    {
        return $this->getRunDate($currentTime, $nth, false, $allowCurrentDate);
    }

    /**
     * Get a previous run date relative to the current date or a specific date
     *
     * @param string|\DateTime $currentTime      Relative calculation date
     * @param int              $nth              Number of matches to skip before returning
     * @param bool             $allowCurrentDate Set to TRUE to return the
     *                                           current date if it matches the cron expression
     *
     * @return \DateTime
     * @throws \RuntimeException on too many iterations
     * @see \Cron\CronExpression::getNextRunDate
     */
    public function getPreviousRunDate($currentTime = 'now', $nth = 0, $allowCurrentDate = false)
    {
        return $this->getRunDate($currentTime, $nth, true, $allowCurrentDate);
    }

    /**
     * Get multiple run dates starting at the current date or a specific date
     *
     * @param int              $total            Set the total number of dates to calculate
     * @param string|\DateTime $currentTime      Relative calculation date
     * @param bool             $invert           Set to TRUE to retrieve previous dates
     * @param bool             $allowCurrentDate Set to TRUE to return the
     *                                           current date if it matches the cron expression
     *
     * @return array Returns an array of run dates
     */
    public function getMultipleRunDates($total, $currentTime = 'now', $invert = false, $allowCurrentDate = false)
    {
        $matches = array();
        for ($i = 0; $i < max(0, $total); $i++) {
            try {
                $matches[] = $this->getRunDate($currentTime, $i, $invert, $allowCurrentDate);
            } catch (RuntimeException $e) {
                break;
            }
        }

        return $matches;
    }

    /**
     * Get all or part of the CRON expression
     *
     * @param string $part Specify the part to retrieve or NULL to get the full
     *                     cron schedule string.
     *
     * @return string|null Returns the CRON expression, a part of the
     *                     CRON expression, or NULL if the part was specified but not found
     */
    public function getExpression($part = null)
    {
        if (null === $part) {
            return implode(' ', $this->cronParts);
        } elseif (array_key_exists($part, $this->cronParts)) {
            return $this->cronParts[$part];
        }

        return null;
    }

    /**
     * Helper method to output the full expression.
     *
     * @return string Full CRON expression
     */
    public function __toString()
    {
        return $this->getExpression();
    }

    /**
     * Determine if the cron is due to run based on the current date or a
     * specific date.  This method assumes that the current number of
     * seconds are irrelevant, and should be called once per minute.
     *
     * @param string|\DateTime $currentTime Relative calculation date
     *
     * @return bool Returns TRUE if the cron is due to run or FALSE if not
     */
    public function isDue($currentTime = 'now')
    {
        if ('now' === $currentTime) {
            $currentDate = date('Y-m-d H:i');
            $currentTime = strtotime($currentDate);
        } elseif ($currentTime instanceof DateTime) {
            $currentDate = clone $currentTime;
            // Ensure time in 'current' timezone is used
            $currentDate->setTimezone(new DateTimeZone(date_default_timezone_get()));
            $currentDate = $currentDate->format('Y-m-d H:i');
            $currentTime = strtotime($currentDate);
        } elseif ($currentTime instanceof DateTimeImmutable) {
            $currentDate = DateTime::createFromFormat('U', $currentTime->format('U'));
            $currentDate->setTimezone(new DateTimeZone(date_default_timezone_get()));
            $currentDate = $currentDate->format('Y-m-d H:i');
            $currentTime = strtotime($currentDate);
        } else {
            $currentTime = new DateTime($currentTime);
            $currentTime->setTime($currentTime->format('H'), $currentTime->format('i'), 0);
            $currentDate = $currentTime->format('Y-m-d H:i');
            $currentTime = $currentTime->getTimeStamp();
        }

        try {
            return $this->getNextRunDate($currentDate, 0, true)->getTimestamp() == $currentTime;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Get the next or previous run date of the expression relative to a date
     *
     * @param string|\DateTime $currentTime      Relative calculation date
     * @param int              $nth              Number of matches to skip before returning
     * @param bool             $invert           Set to TRUE to go backwards in time
     * @param bool             $allowCurrentDate Set to TRUE to return the
     *                                           current date if it matches the cron expression
     *
     * @return \DateTime
     * @throws \RuntimeException on too many iterations
     */
    protected function getRunDate($currentTime = null, $nth = 0, $invert = false, $allowCurrentDate = false)
    {
        if ($currentTime instanceof DateTime) {
            $currentDate = clone $currentTime;
        } elseif ($currentTime instanceof DateTimeImmutable) {
            $currentDate = DateTime::createFromFormat('U', $currentTime->format('U'));
            $currentDate->setTimezone($currentTime->getTimezone());
        } else {
            $currentDate = new DateTime($currentTime ?: 'now');
            $currentDate->setTimezone(new DateTimeZone(date_default_timezone_get()));
        }

        $currentDate->setTime($currentDate->format('H'), $currentDate->format('i'), 0);
        $nextRun = clone $currentDate;
        $nth = (int) $nth;

        // We don't have to satisfy * or null fields
        $parts = array();
        $fields = array();
        foreach (self::$order as $position) {
            $part = $this->getExpression($position);
            if (null === $part || '*' === $part) {
                continue;
            }
            $parts[$position] = $part;
            $fields[$position] = $this->fieldFactory->getField($position);
        }

        // Set a hard limit to bail on an impossible date
        for ($i = 0; $i < $this->maxIterationCount; $i++) {

            foreach ($parts as $position => $part) {
                $satisfied = false;
                // Get the field object used to validate this part
                $field = $fields[$position];
                // Check if this is singular or a list
                if (strpos($part, ',') === false) {
                    $satisfied = $field->isSatisfiedBy($nextRun, $part);
                } else {
                    foreach (array_map('trim', explode(',', $part)) as $listPart) {
                        if ($field->isSatisfiedBy($nextRun, $listPart)) {
                            $satisfied = true;
                            break;
                        }
                    }
                }

                // If the field is not satisfied, then start over
                if (!$satisfied) {
                    $field->increment($nextRun, $invert, $part);
                    continue 2;
                }
            }

            // Skip this match if needed
            if ((!$allowCurrentDate && $nextRun == $currentDate) || --$nth > -1) {
                $this->fieldFactory->getField(0)->increment($nextRun, $invert, isset($parts[0]) ? $parts[0] : null);
                continue;
            }

            return $nextRun;
        }

        // @codeCoverageIgnoreStart
        throw new RuntimeException('Impossible CRON expression');
        // @codeCoverageIgnoreEnd
    }
}
