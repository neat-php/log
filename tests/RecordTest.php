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
}
