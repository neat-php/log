<?php

namespace Neat\Log\Test;

use DateTime;
use DateTimeZone;
use Neat\Log\Format\Timestamp;
use PHPUnit\Framework\TestCase;

class TimestampTest extends TestCase
{
    /**
     * Test default
     */
    public function testDefault()
    {
        $format = new class extends Timestamp {
            protected function time(): DateTime
            {
                return new DateTime('2018-09-16T10:59:01+0200');
            }
        };

        $this->assertSame('[2018-09-16T10:59:01+0200] Hi', $format('info', 'Hi'));
    }

    /**
     * Test format
     */
    public function testFormat()
    {
        $format = new class('Y-m-d H:i:s.u') extends Timestamp {
            protected function time(): DateTime
            {
                return new DateTime('2018-09-16T10:59:01.123456+0200');
            }
        };

        $this->assertSame('[2018-09-16 10:59:01.123456] Hi', $format('info', 'Hi'));
    }

    /**
     * Test custom timezone
     */
    public function testDefaultTimeZone()
    {
        $default = date_default_timezone_get();
        try {
            date_default_timezone_set('Etc/GMT+12');

            $format = new Timestamp('O');
            $this->assertSame('[-1200] Hi', $format('info', 'Hi'));
        } finally {
            date_default_timezone_set($default);
        }
    }

    /**
     * Test custom timezone
     */
    public function testCustomTimeZone()
    {
        $format = new Timestamp('O', '-0615');

        $this->assertSame('[-0615] Hi', $format('info', 'Hi'));
    }

    /**
     * Test custom timezone object
     */
    public function testCustomTimeZoneObject()
    {
        $format = new Timestamp('O', new DateTimeZone('-0615'));

        $this->assertSame('[-0615] Hi', $format('info', 'Hi'));
    }
}
