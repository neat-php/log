<?php

namespace Neat\Log\Test;

use Neat\Log\Filter;
use Neat\Log\Record;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class FilterTest extends TestCase
{
    /**
     * Test unfiltered log
     */
    public function testUnfiltered()
    {
        /** @var MockObject|LoggerInterface $mock */
        $mock = $this->createMock(LoggerInterface::class);
        $mock->expects($this->once())
            ->method('log')
            ->with('debug', 'It worked!', []);

        $log = new Filter($mock);
        $log->debug('It worked!');
    }

    /**
     * Test filter should log
     */
    public function testFilterShouldLog()
    {
        /** @var MockObject|LoggerInterface $mock */
        $mock = $this->createMock(LoggerInterface::class);
        $mock->expects($this->once())
            ->method('log')
            ->with('warning', 'Please show me!', []);

        /** @var MockObject|callable $filter1 */
        $filter1 = $this->createPartialMock('stdClass', ['__invoke']);
        $filter1->expects($this->once())
            ->method('__invoke')
            ->with(new Record('warning', 'Please show me!', []))
            ->willReturn(true);

        /** @var MockObject|callable $filter2 */
        $filter2 = $this->createPartialMock('stdClass', ['__invoke']);
        $filter2->expects($this->once())
            ->method('__invoke')
            ->with(new Record('warning', 'Please show me!', []))
            ->willReturn(true);

        $log = new Filter($mock, $filter1, $filter2);
        $log->warning('Please show me!');
    }

    /**
     * Test filter should not log
     */
    public function testFilterShouldNotLog()
    {
        /** @var MockObject|LoggerInterface $mock */
        $mock = $this->createMock(LoggerInterface::class);

        /** @var MockObject|callable $filter1 */
        $filter1 = $this->createPartialMock('stdClass', ['__invoke']);
        $filter1->expects($this->once())
            ->method('__invoke')
            ->with(new Record('warning', 'Please do not show me!', []))
            ->willReturn(false);

        /** @var MockObject|callable $filter2 */
        $filter2 = $this->createPartialMock('stdClass', ['__invoke']);

        $log = new Filter($mock, $filter1, $filter2);
        $log->warning('Please do not show me!');
    }
}
