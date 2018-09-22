<?php

namespace Neat\Log\Test\Format;

use LogicException;
use Neat\Log\Format\Truncate;
use PHPUnit\Framework\TestCase;

class TruncateTest extends TestCase
{
    /**
     * Test not truncated message
     */
    public function testNotTruncated()
    {
        $truncate = new Truncate(8);

        $this->assertSame('original', $truncate('debug', 'original'));
        $this->assertSame('ok', $truncate('info', 'ok'));
    }

    /**
     * Test truncated message
     */
    public function testTruncated()
    {
        $truncate = new Truncate(8);

        $this->assertSame('too long', $truncate('debug', 'too long!'));
        $this->assertSame('Way too ', $truncate('debug', 'Way too long'));
    }

    /**
     * Test custom overflow
     */
    public function testOverflow()
    {
        $this->assertSame('too l$', (new Truncate(6, '$'))('debug', 'too long!'));
        $this->assertSame('too...', (new Truncate(6, '...'))('debug', 'too long!'));
        $this->assertSame('too lo', (new Truncate(6, ''))('debug', 'too long!'));
    }

    /**
     * Test overflow too long
     */
    public function testOverflowTooLong()
    {
        $this->expectException(LogicException::class);
        $this->expectExceptionMessage('Overflow can not be longer than maximum allowed message length.');

        new Truncate(10, '... (truncated)');
    }
}
