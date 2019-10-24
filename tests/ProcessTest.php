<?php

namespace Neat\Log\Test;

use Neat\Log\Process;
use Neat\Log\Record;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class ProcessTest extends TestCase
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
     * Test without processing
     *
     */
    public function testWithoutProcessing()
    {
        $mock = $this->createLogMockExpecting('debug', 'Original message', ['foo' => 'bar']);

        $process = new Process($mock);
        $process->debug('Original message', ['foo' => 'bar']);
    }

    /**
     * Provide placeholder data
     *
     * @return array
     */
    public function provideProcessData()
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
     * @dataProvider provideProcessData
     * @param string $level
     * @param string $message
     * @param array  $context
     * @param string $expected
     */
    public function testProcess(string $level, string $message, array $context, string $expected)
    {
        $log = $this->createLogMockExpecting($level, $expected, $context);

        /** @var MockObject|callable $callable */
        $callable = $this->createPartialMock(CallableMock::class, ['__invoke']);
        $callable->expects($this->once())
            ->method('__invoke')
            ->with(new Record($level, $message, $context))
            ->willReturn(new Record($level, $expected, $context));

        $process = new Process($log, $callable);
        $process->$level($message, $context);
    }
}
