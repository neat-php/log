<?php

namespace Neat\Log;

use Psr\Log\LoggerInterface;
use Psr\Log\LoggerTrait;

/**
 * @see http://php.net/manual/en/function.syslog.php
 * @see http://man7.org/linux/man-pages/man3/syslog.3.html
 */
class Syslog implements LoggerInterface
{
    use LoggerTrait;

    /**
     * Syslog constructor
     *
     * @param string $identifier App identifier (optional)
     * @param int    $option     Option mask (optional)
     * @param int    $facility   Facility (optional, defaults to LOG_USER)
     */
    public function __construct(string $identifier = null, int $option = 0, int $facility = LOG_USER)
    {
        openlog($identifier, $option, $facility);
    }

    /**
     * Syslog destructor
     */
    public function __destruct()
    {
        closelog();
    }

    /**
     * Log to syslog
     *
     * @param mixed  $level
     * @param string $message
     * @param array  $context
     */
    public function log($level, $message, array $context = [])
    {
        $record = new Record($level, $message);

        syslog($record->priority() ?? LOG_INFO, $record->message());
    }
}
