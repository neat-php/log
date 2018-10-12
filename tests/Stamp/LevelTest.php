<?php

namespace Neat\Log\Test\Stamp;

use Neat\Log\Record;
use Neat\Log\Stamp\Level;
use PHPUnit\Framework\TestCase;
use Psr\Log\LogLevel;

class LevelTest extends TestCase
{
    /**
     * Provide level data
     *
     * @return array
     */
    public function provideLevelData(): array
    {
        return [
            [LogLevel::EMERGENCY],
            [LogLevel::ALERT],
            [LogLevel::CRITICAL],
            [LogLevel::ERROR],
            [LogLevel::WARNING],
            [LogLevel::NOTICE],
            [LogLevel::INFO],
            [LogLevel::DEBUG],
            ['unknown'],
            [''],
        ];
    }

    /**
     * Test level
     *
     * @dataProvider provideLevelData
     * @param string $level
     */
    public function testLevel(string $level)
    {
        $record = new Record($level, 'message');
        $format = new Level;

        $this->assertSame($level, $format($record));
    }
}
