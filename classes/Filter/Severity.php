<?php

namespace Neat\Log\Filter;

use Psr\Log\LogLevel;

class Severity
{
    /**
     * @see https://tools.ietf.org/html/rfc5424#page-11
     */
    const SEVERITIES = [
        LogLevel::EMERGENCY => 0,
        LogLevel::ALERT     => 1,
        LogLevel::CRITICAL  => 2,
        LogLevel::ERROR     => 3,
        LogLevel::WARNING   => 4,
        LogLevel::NOTICE    => 5,
        LogLevel::INFO      => 6,
        LogLevel::DEBUG     => 7,
    ];

    /**
     * @var int
     */
    private $severity;

    /**
     * Severity constructor
     *
     * @param string $level
     */
    public function __construct(string $level)
    {
        $this->severity = self::SEVERITIES[$level] ?? null;
    }

    /**
     * Level has severity?
     *
     * @param string $level
     * @return bool
     */
    public function __invoke(string $level): bool
    {
        $severity = self::SEVERITIES[$level] ?? null;

        return $this->severity === null
            || $severity === null
            || $severity <= $this->severity;
    }
}
