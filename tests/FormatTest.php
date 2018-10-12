<?php

namespace Neat\Log\Test;

use Neat\Log\Format;
use Neat\Log\Record;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class FormatTest extends TestCase
{
    /**
     * Create mocked logger expecting one log entry
     *
     * @param string $level
     * @param string $message
     * @param array  $context
     * @return MockObject|LoggerInterface
     */
    public function createLogMockExpecting(string $level, string $message, array $context = [])
    {
        $mock = $this->createMock(LoggerInterface::class);
        $mock->expects($this->once())
            ->method('log')
            ->with($level, $message, $context);

        return $mock;
    }

    /**
     * Test without format
     *
     */
    public function testWithoutFormat()
    {
        $mock = $this->createLogMockExpecting('debug', 'Original message', ['foo' => 'bar']);

        $format = new Format($mock);
        $format->debug('Original message', ['foo' => 'bar']);
    }

    /**
     * Provide placeholder data
     *
     * @return array
     */
    public function provideFormatData()
    {
        return [
            ['debug', 'No placeholders', ['key' => 'value'], 'No placeholders'],
            ['debug', 'One {key}', ['key' => 'value'], 'One value'],
            ['debug', 'Two occurrences: {key} and {key}', ['key' => 'value'], 'Two occurrences: value and value'],
            ['debug', 'Missing context {key}', [], 'Missing context {key}'],
            ['debug', 'Object: {key}', [], 'Object: string'],
        ];
    }

    /**
     * Test placeholder
     *
     * @dataProvider provideFormatData
     * @param string $level
     * @param string $message
     * @param array  $context
     * @param string $expected
     */
    public function testFormat(string $level, string $message, array $context, string $expected)
    {
        $log = $this->createLogMockExpecting($level, $expected, $context);

        /** @var MockObject|callable $formatter */
        $formatter = $this->createPartialMock('stdClass', ['__invoke']);
        $formatter->expects($this->once())
            ->method('__invoke')
            ->with(new Record($level, $message, $context))
            ->willReturn(new Record($level, $expected, $context));

        $format = new Format($log, $formatter);
        $format->$level($message, $context);
    }
}
