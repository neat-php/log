<?php

namespace Neat\Log\Test;

class SyslogMock
{
    /**
     * @var SyslogMock
     */
    public static $instance;

    /**
     * Syslog wrapper
     *
     * @param int    $priority
     * @param string $message
     * @return bool
     */
    public function syslog($priority, $message)
    {
        return syslog($priority, $message);
    }

    /**
     * Closelog wrapper
     *
     * @return bool
     */
    public function closelog()
    {
        return closelog();
    }

    /**
     * Openlog wrapper
     *
     * @param string $ident
     * @param int    $option
     * @param int    $facility
     * @return bool
     */
    public function openlog($ident, $option, $facility)
    {
        return openlog($ident, $option, $facility);
    }

    /**
     * Get syslog mock
     *
     * @return SyslogMock
     */
    public static function get(): SyslogMock
    {
        return self::$instance
            ?? self::$instance = new static;
    }

    /**
     * Set syslog mock
     *
     * @param SyslogMock $mock
     */
    public static function set(SyslogMock $mock)
    {
        require_once __DIR__ . '/syslog.php';

        self::$instance = $mock;
    }
}
