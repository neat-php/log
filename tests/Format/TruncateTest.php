<?php

namespace Neat\Log\Test\Format;

use LogicException;
use Neat\Log\Format\Truncate;
use Neat\Log\Record;
use PHPUnit\Framework\TestCase;

class TruncateTest extends TestCase
{
    /**
     * Test not truncated message
     */
    public function testNotTruncated()
    {
        $truncate = new Truncate(8);

        $this->assertSame($expected = new Record('debug', 'original'), $truncate($expected));
        $this->assertSame($expected = new Record('info', 'ok'), $truncate($expected));
    }

    /**
     * Test truncated message
     */
    public function testTruncated()
    {
        $truncate = new Truncate(8);

        $this->assertEquals(new Record('debug', 'too long'), $truncate(new Record('debug', 'too long!')));
        $this->assertEquals(new Record('debug', 'Way too '), $truncate(new Record('debug', 'Way too long')));
    }

    /**
     * Test custom overflow
     */
    public function testOverflow()
    {
        $this->assertEquals(new Record('debug', 'too l$'), (new Truncate(6, '$'))(new Record('debug', 'too long!')));
        $this->assertEquals(new Record('debug', 'too...'), (new Truncate(6, '...'))(new Record('debug', 'too long!')));
        $this->assertEquals(new Record('debug', 'too lo'), (new Truncate(6, ''))(new Record('debug', 'too long!')));
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
