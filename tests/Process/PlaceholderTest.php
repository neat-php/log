<?php

namespace Neat\Log\Test\Process;

use Neat\Log\Process\Placeholder;
use Neat\Log\Record;
use PHPUnit\Framework\TestCase;

class PlaceholderTest extends TestCase
{
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
        $before = new Record('warning', $message, $context);
        $after  = new Record('warning', $expected, $context);
        $format = new Placeholder;

        $this->assertEquals($after, $format($before));
    }
}
