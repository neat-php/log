<?php

namespace Neat\Log\Test;

use Neat\Log\Syslog;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class SyslogTest extends TestCase
{
    /**
     * Test opening and closing the syslog
     */
    public function testOpenAndClose()
    {
        /** @var MockObject|SyslogMock $mock */
        $mock = $this->createPartialMock(SyslogMock::class, ['openlog', 'closelog', 'syslog']);
        $mock
            ->expects($this->at(0))
            ->method('openlog')
            ->with('NeatSyslogTest', 0, LOG_USER)
            ->willReturn(true);
        $mock
            ->expects($this->at(1))
            ->method('closelog')
            ->with()
            ->willReturn(true);

        SyslogMock::set($mock);

        new Syslog('NeatSyslogTest');
    }

    /**
     * Test logging to syslog
     */
    public function testLog()
    {
        /** @var MockObject|SyslogMock $mock */
        $mock = $this->createPartialMock(SyslogMock::class, ['openlog', 'closelog', 'syslog']);
        $mock
            ->expects($this->once())
            ->method('syslog')
            ->with(LOG_ALERT, 'red alert!')
            ->willReturn(true);

        SyslogMock::set($mock);

        $log = new Syslog;
        $log->alert('red alert!');
    }
}
