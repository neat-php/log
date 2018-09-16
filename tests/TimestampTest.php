<?php

namespace Neat\Log\Test;

use DateTime;
use DateTimeZone;
use Neat\Log\Timestamp;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class TimestampTest extends TestCase
{
    /**
     * Create mocked logger expecting one log entry
     *
     * @param string $level
     * @param string $message
     * @param array  $context
     * @return MockObject|LoggerInterface
     */
    public function createMockExpecting($level, $message, $context = [])
    {
        $mock = $this->createMock(LoggerInterface::class);
        $mock->expects($this->once())
            ->method('log')
            ->with($level, $message, $context);

        return $mock;
    }

    /**
     * Test default
     */
    public function testDefault()
    {
        $mock = $this->createMockExpecting('info', '[2018-09-16T10:59:01+0200] Hi');

        $log = new class($mock) extends Timestamp {
            protected function time(): DateTime
            {
                return new DateTime('2018-09-16T10:59:01+0200');
            }
        };

        $log->log('info', 'Hi');
    }

    /**
     * Test format
     */
    public function testFormat()
    {
        $mock = $this->createMockExpecting('info', '[2018-09-16 10:59:01.123456] Hi');

        $log = new class($mock, 'Y-m-d H:i:s.u') extends Timestamp {
            protected function time(): DateTime
            {
                return new DateTime('2018-09-16T10:59:01.123456+0200');
            }
        };

        $log->log('info', 'Hi');
    }

    /**
     * Test custom timezone
     */
    public function testDefaultTimeZone()
    {
        $mock = $this->createMockExpecting('info', '[-1200] Hi');

        $default = date_default_timezone_get();
        try {
            date_default_timezone_set('Etc/GMT+12');

            $log = new Timestamp($mock, 'O');
            $log->log('info', 'Hi');
        } finally {
            date_default_timezone_set($default);
        }
    }

    /**
     * Test custom timezone
     */
    public function testCustomTimeZone()
    {
        $mock = $this->createMockExpecting('info', '[-0615] Hi');

        $log = new Timestamp($mock, 'O', '-0615');
        $log->log('info', 'Hi');
    }

    /**
     * Test custom timezone object
     */
    public function testCustomTimeZoneObject()
    {
        $mock = $this->createMockExpecting('info', '[-0615] Hi');

        $log = new Timestamp($mock, 'O', new DateTimeZone('-0615'));
        $log->log('info', 'Hi');
    }
}
