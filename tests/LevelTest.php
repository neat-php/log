<?php

namespace Neat\Log\Test;

use Neat\Log\Level;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\InvalidArgumentException;
use Psr\Log\LoggerInterface;
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
        /** @var LoggerInterface|MockObject $mock */
        $mock = $this->createMock(LoggerInterface::class);
        $mock->expects($this->once())
            ->method('log')
            ->with($level, $expected, []);

        $log = new Level($mock);
        $log->log($level, $message);
    }

    /**
     * Provide invalid level data
     *
     * @return array
     */
    public function provideInvalidLevelData(): array
    {
        return [
            [0],
            [1],
            [true],
            [false],
            [null],
            [[]],
            [(object) []],
        ];
    }

    /**
     * Test level
     *
     * @dataProvider provideInvalidLevelData
     * @param mixed $level
     */
    public function testInvalidLevel($level)
    {
        $this->expectException(InvalidArgumentException::class);

        /** @var LoggerInterface|MockObject $mock */
        $mock = $this->createMock(LoggerInterface::class);

        $log = new Level($mock);
        $log->log($level, 'Hi');
    }
}