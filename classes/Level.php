<?php

namespace Neat\Log;

use Psr\Log\LogLevel;

class Level extends LogLevel
{
    /**
     * @see https://tools.ietf.org/html/rfc5424#page-11
     * @see https://secure.php.net/manual/en/network.constants.php
     */
    const PRIORITIES = [
        self::EMERGENCY => LOG_EMERG,
        self::ALERT     => LOG_ALERT,
        self::CRITICAL  => LOG_CRIT,
        self::ERROR     => LOG_ERR,
        self::WARNING   => LOG_WARNING,
        self::NOTICE    => LOG_NOTICE,
        self::INFO      => LOG_INFO,
        self::DEBUG     => LOG_DEBUG,
    ];
}
