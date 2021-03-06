<?php

namespace Neat\Log\Test\Filter;

use Neat\Log\Filter\Severity;
use Neat\Log\Record;
use PHPUnit\Framework\TestCase;

class SeverityTest extends TestCase
{
    /**
     * Provide level data
     *
     * @return array
     */
    public function provideLevelData(): array
    {
        return [
            [true, 'debug', 'debug'],
            [true, 'emergency', 'emergency'],
            [true, 'debug', 'emergency'],
            [false, 'emergency', 'debug'],
            [true, 'emergency', 'unknown'],
            [true, 'unknown', 'emergency'],
            [true, 'emergency', ''],
            [true, '', 'emergency'],
        ];
    }

    /**
     * Test level
     *
     * @param bool   $match
     * @param string $minimumLevel
     * @param string $level
     * @dataProvider provideLevelData
     */
    public function testLevel(bool $match, string $minimumLevel, string $level)
    {
        $record   = new Record($level, 'message');
        $severity = new Severity($minimumLevel);
        $matched  = $severity($record);

        $this->assertSame($match, $matched);
    }
}
