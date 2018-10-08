<?php

namespace Neat\Log;

use Neat\Log\Test\SyslogMock;

/**
 * Syslog intercept function (overloads the PHP built-in syslog function)
 *
 * @param int    $priority
 * @param string $message
 * @return bool
 */
function syslog($priority, $message)
{
    return SyslogMock::get()->syslog($priority, $message);
}

/**
 * Closelog intercept function (overloads the PHP built-in closelog function)
 *
 * @return bool
 */
function closelog()
{
    return SyslogMock::get()->closelog();
}

/**
 * Openlog intercept function (overloads the PHP built-in openlog function)
 *
 * @param string $ident
 * @param int    $option
 * @param int    $facility
 * @return bool
 */
function openlog($ident, $option, $facility)
{
    return SyslogMock::get()->openlog($ident, $option, $facility);
}
