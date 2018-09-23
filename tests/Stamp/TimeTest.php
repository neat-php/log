<?php

namespace Neat\Log\Test\Stamp;

use DateTime;
use DateTimeZone;
use Neat\Log\Stamp\Time;
use PHPUnit\Framework\TestCase;

class TimeTest extends TestCase
{
    /**
     * Test default
     */
    public function testDefault()
    {
        $time = new class extends Time {
            protected function time(): DateTime
            {
                return new DateTime('2018-09-16T10:59:01+0200');
            }
        };

        $this->assertSame('2018-09-16T10:59:01+0200', $time('info', 'Hi'));
    }

    /**
     * Test format
     */
    public function testFormat()
    {
        $time = new class('Y-m-d H:i:s.u') extends Time {
            protected function time(): DateTime
            {
                return new DateTime('2018-09-16T10:59:01.123456+0200');
            }
        };

        $this->assertSame('2018-09-16 10:59:01.123456', $time('info', 'Hi'));
    }

    /**
     * Test custom timezone
     */
    public function testDefaultTimeZone()
    {
        $default = date_default_timezone_get();
        try {
            date_default_timezone_set('Etc/GMT+12');

            $time = new Time('O');
            $this->assertSame('-1200', $time('info', 'Hi'));
        } finally {
            date_default_timezone_set($default);
        }
    }

    /**
     * Test custom timezone
     */
    public function testCustomTimeZone()
    {
        $time = new Time('O', '-0615');

        $this->assertSame('-0615', $time('info', 'Hi'));
    }

    /**
     * Test custom timezone object
     */
    public function testCustomTimeZoneObject()
    {
        $time = new Time('O', new DateTimeZone('-0615'));

        $this->assertSame('-0615', $time('info', 'Hi'));
    }
}
