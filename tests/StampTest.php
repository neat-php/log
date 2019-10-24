<?php

namespace Neat\Log\Test;

use Neat\Log\Record;
use Neat\Log\Stamp;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class StampTest extends TestCase
{
    /**
     * Test without stamp
     */
    public function testWithoutStamp()
    {
        /** @var MockObject|LoggerInterface $mock */
        $mock = $this->createMock(LoggerInterface::class);
        $mock->expects($this->once())
            ->method('log')
            ->with('debug', 'Original message', ['foo' => 'bar']);

        $stamp = new Stamp($mock);
        $stamp->debug('Original message', ['foo' => 'bar']);
    }

    /**
     * Test with stamp
     */
    public function testStamp()
    {
        /** @var MockObject|LoggerInterface $log */
        $log = $this->createMock(LoggerInterface::class);
        $log->expects($this->once())
            ->method('log')
            ->with('info', '[stamped] Hi', ['foo' => 'bar']);

        /** @var MockObject|callable $stamper */
        $stamper = $this->createPartialMock(CallableMock::class, ['__invoke']);
        $stamper->expects($this->once())
            ->method('__invoke')
            ->with(new Record('info', 'Hi', ['foo' => 'bar']))
            ->willReturn('stamped');

        $stamp = new Stamp($log, $stamper);
        $stamp->info('Hi', ['foo' => 'bar']);
    }
}
