<?php

namespace Neat\Log\Test\Format;

use Neat\Log\Format\Context;
use PHPUnit\Framework\TestCase;

class ContextTest extends TestCase
{
    /**
     * Provide context data
     *
     * @return array
     */
    public function provideContextData()
    {
        return [
            ["Hi\n", 'Hi', []],
            ["Hi\nfoo: bar\n", 'Hi', ['foo' => 'bar']],
            ["Hi\nvar:      val\nvariable: value\n", 'Hi', ['var' => 'val', 'variable' => 'value']],
            ["Hi\n\ntrace\n-----\nline1\nline2\n", 'Hi', ['trace' => "line1\nline2"]],
            [
                "Hi\nuser: john\n\ntrace\n-----\nline1\nline2\n\nquery\n-----\nSELECT...\n",
                'Hi',
                ['trace' => "line1\nline2", 'query' => 'SELECT...', 'user' => 'john']
            ],
        ];
    }

    /**
     * Test context format
     *
     * @param string $formatted
     * @param string $message
     * @param array  $context
     * @dataProvider provideContextData
     */
    public function testContext(string $formatted, string $message, array $context)
    {
        $format = new Context(['trace', 'query']);

        $this->assertSame($formatted, $format('info', $message, $context));
    }
}
