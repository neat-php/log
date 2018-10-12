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
            [true, 'Message', '/^Message$/', false],
            [false, 'Message', '/^Message$/', true],
            [false, 'Message', '/^AnotherMessage$/', false],
            [true, 'Message', '/^AnotherMessage$/', true],
        ];
    }

    /**
     * Test match
     *
     * @param bool   $match
     * @param string $message
     * @param string $pattern
     * @param bool   $exclude
     * @dataProvider provideMatchData
     */
    public function testMatch(bool $match, string $message, string $pattern, bool $exclude)
    {
        $record  = new Record('warning', $message);
        $pattern = new Pattern($pattern, $exclude);
        $matched = $pattern($record);

        $this->assertSame($match, $matched);
    }
}
