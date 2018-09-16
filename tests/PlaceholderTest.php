<?php

namespace Neat\Log\Test;

use Neat\Log\Placeholder;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class PlaceholderTest extends TestCase
{
    /**
     * Create mocked logger expecting one log entry
     *
     * @param string $level
     * @param string $message
     * @param array  $context
     * @return MockObject|LoggerInterface
     */
    public function createMockExpecting($level, $message, $context = [])
    {
        $mock = $this->createMock(LoggerInterface::class);
        $mock->expects($this->once())
            ->method('log')
            ->with($level, $message, $context);

        return $mock;
    }

    /**
     * Provide placeholder data
     *
     * @return array
     */
    public function providePlaceholderData()
    {
        $string = new class {
            public function __toString()
            {
                return 'string';
            }
        };

        return [
            ['No placeholders', ['key' => 'value'], 'No placeholders'],
            ['One {key}', ['key' => 'value'], 'One value'],
            ['Two occurrences: {key} and {key}', ['key' => 'value'], 'Two occurrences: value and value'],
            ['Missing context {key}', [], 'Missing context {key}'],
            ['Object: {key}', ['key' => $string], 'Object: string'],
        ];
    }

    /**
     * Test placeholder
     *
     * @dataProvider providePlaceholderData
     * @param string $message
     * @param array  $context
     * @param string $expected
     */
    public function testPlaceholder(string $message, array $context, string $expected)
    {
        $mock = $this->createMockExpecting('warning', $expected, $context);

        $log = new Placeholder($mock);
        $log->log('warning', $message, $context);
    }
}
