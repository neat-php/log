<?php

namespace Neat\Log\Test;

use Neat\Log\Record;
use PHPUnit\Framework\TestCase;

class RecordTest extends TestCase
{
    /**
     * Test create
     */
    public function testCreate()
    {
        $message = new Record('info', 'Hello world!');

        $this->assertSame('info', $message->level());
        $this->assertSame('Hello world!', $message->message());
        $this->assertSame([], $message->context());
    }

    /**
     * Test with level
     */
    public function testWithLevel()
    {
        $message = new Record('debug', 'Hi');

        $this->assertSame('notice', $message->withlevel('notice')->level());
        $this->assertSame('debug', $message->level());
    }

    /**
     * Test with message
     */
    public function testWithMessage()
    {
        $message = new Record('debug', 'Hi');

        $this->assertSame('Hello', $message->withMessage('Hello')->message());
        $this->assertSame('Hi', $message->message());
    }

    /**
     * Test with context
     */
    public function testWithContext()
    {
        $message = new Record('debug', 'Hi', ['foo' => 'bar']);

        $this->assertSame([], $message->withContext([])->context());
        $this->assertSame(['foo' => 'bar'], $message->context());
    }

    /**
     * Provide string data
     *
     * @return array
     */
    public function provideStringData()
    {
        $object = new class {
            function __toString()
            {
                return 'converted to string';
            }
        };
        return [
            ['', ''],
            ['test', 'test'],
            [$object, 'converted to string'],
            [new \stdClass, 'stdClass'],
            [new \DateTime, 'DateTime'],
            [[], 'array'],
            [['test'], 'array'],
            [0, '0'],
            [1, '1'],
            [.5, '0.5'],
            [true, 'true'],
            [false, 'false'],
            [null, 'null'],
        ];
    }

    /**
     * Test normalized level
     *
     * @param mixed  $value
     * @param string $expected
     * @dataProvider provideStringData
     */
    public function testNormalizedLevel($value, string $expected)
    {
        $record = new Record($value, '');

        $this->assertSame($expected, $record->level());
    }

    /**
     * Test normalized level
     *
     * @param mixed  $value
     * @param string $expected
     * @dataProvider provideStringData
     */
    public function testNormalizedMessage($value, string $expected)
    {
        $record = new Record('info', $value);

        $this->assertSame($expected, $record->message());
    }

    /**
     * Test normalized context strings
     */
    public function testNormalizedContextStrings()
    {
        $values   = [];
        $expected = [];
        foreach ($this->provideStringData() as list($in, $out)) {
            $values[] = $in;
            $expected[] = $out;
        }

        $record = new Record('info', 'testing', $values);

        $this->assertSame($expected, $record->contextStrings());
    }
}
