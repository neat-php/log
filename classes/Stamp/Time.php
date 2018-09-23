<?php

namespace Neat\Log\Stamp;

use DateTime;
use DateTimeZone;

class Time
{
    /**
     * @var string
     */
    private $format;

    /**
     * @var DateTimeZone
     */
    private $timezone;

    /**
     * Timestamp constructor
     *
     * @param string              $format
     * @param string|DateTimeZone $timezone
     */
    public function __construct(string $format = DATE_ISO8601, $timezone = null)
    {
        if (!$timezone instanceof DateTimeZone) {
            $timezone = new DateTimeZone($timezone ?? date_default_timezone_get());
        }

        $this->format   = $format;
        $this->timezone = $timezone;
    }

    /**
     * Format message with timestamp
     *
     * @return string
     */
    public function __invoke(): string
    {
        return $this->time()->format($this->format);
    }

    /**
     * Get time
     *
     * @return DateTime
     */
    protected function time(): DateTime
    {
        $time = DateTime::createFromFormat('U.u', number_format(microtime(true), 6, '.', ''));
        $time->setTimezone($this->timezone);

        return $time;
    }
}
