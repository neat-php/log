<?php

namespace Neat\Log\Test;

use Neat\Log\Format\Level;
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
            [LogLevel::EMERGENCY, 'Hi', '[emergency] Hi'],
            [LogLevel::ALERT, 'Hi', '[alert] Hi'],
            [LogLevel::CRITICAL, 'Hi', '[critical] Hi'],
            [LogLevel::ERROR, 'Hi', '[error] Hi'],
            [LogLevel::WARNING, 'Hi', '[warning] Hi'],
            [LogLevel::NOTICE, 'Hi', '[notice] Hi'],
            [LogLevel::INFO, 'Hi', '[info] Hi'],
            [LogLevel::DEBUG, 'Hi', '[debug] Hi'],
            ['unknown', 'Hi', '[unknown] Hi'],
            ['', 'Hi', '[] Hi'],
        ];
    }

    /**
     * Test level
     *
     * @dataProvider provideLevelData
     * @param string $level
     * @param string $message
     * @param string $expected
     */
    public function testLevel(string $level, string $message, string $expected)
    {
        $format = new Level();

        $this->assertSame($expected, $format($level, $message));
    }
}
