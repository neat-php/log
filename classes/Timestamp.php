<?php

namespace Neat\Log;

use DateTime;
use DateTimeZone;
use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

class Timestamp
{
    use LoggerTrait;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @var string
     */
    private $format;

    /**
     * @var DateTimeZone
     */
    private $timezone;

    /**
     * Format constructor
     *
     * @param LoggerInterface     $logger
     * @param string              $format
     * @param string|DateTimeZone $timezone
     */
    public function __construct(LoggerInterface $logger, string $format = DATE_ISO8601, $timezone = null)
    {
        if (!$timezone instanceof DateTimeZone) {
            $timezone = new DateTimeZone($timezone ?? date_default_timezone_get());
        }

        $this->logger   = $logger;
        $this->format   = $format;
        $this->timezone = $timezone;
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

    /**
     * Format message with timestamp
     *
     * @param string $message
     * @return string
     */
    private function format(string $message): string
    {
        return sprintf('[%s] %s', $this->time()->format($this->format), $message);
    }

    /**
     * Log message with timestamp
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     */
    public function log($level, $message, array $context = [])
    {
        $this->logger->log($level, $this->format($message), $context);
    }
}
