<?php

namespace Neat\Log\Test\Filter;

use Neat\Log\Filter\Pattern;
use Neat\Log\Record;
use PHPUnit\Framework\TestCase;

class PatternTest extends TestCase
{
    /**
     * Provide match data
     *
     * @return array
     */
    public function provideMatchData(): array
    {
        return [
            [true, 'Message', '/^Message$/'],
            [false, 'Message', '/^AnotherMessage$/'],
        ];
    }

    /**
     * Test match
     *
     * @param bool   $match
     * @param string $message
     * @param string $pattern
     * @dataProvider provideMatchData
     */
    public function testMatch(bool $match, string $message, string $pattern)
    {
        $record  = new Record('warning', $message);
        $pattern = new Pattern($pattern);
        $matched = $pattern($record);

        $this->assertSame($match, $matched);
    }
}
