<?php

namespace Neat\Log\Test\Process;

use Neat\Log\Process\Context;
use Neat\Log\Record;
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
                ['trace' => "line1\nline2", 'query' => 'SELECT...', 'user' => 'john'],
            ],
        ];
    }

    /**
     * Test context processor
     *
     * @param string $result
     * @param string $message
     * @param array  $context
     * @dataProvider provideContextData
     */
    public function testContext(string $result, string $message, array $context)
    {
        $before    = new Record('info', $message, $context);
        $after     = new Record('info', $result, $context);
        $processor = new Context(['trace', 'query']);

        $this->assertEquals($after, $processor($before));
    }
}
