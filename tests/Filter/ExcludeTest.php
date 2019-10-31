<?php

namespace Neat\Log\Test\Filter;

use Neat\Log\Filter\Exclude;
use Neat\Log\Record;
use Neat\Log\Test\CallableMock;
use PHPUnit\Framework\TestCase;

class ExcludeTest extends TestCase
{
    /**
     * Provide match data
     *
     * @return array
     */
    public function provideMatchData(): array
    {
        return [
            [true, 'Message', false],
            [false, 'Message', true],
        ];
    }

    /**
     * Test match
     *
     * @param bool   $expected
     * @param string $message
     * @param bool   $match
     * @dataProvider provideMatchData
     */
    public function testMatch(bool $expected, string $message, bool $match)
    {
        $record  = new Record('warning', $message);

        $mock = $this->createPartialMock(CallableMock::class, ['__invoke']);
        $mock
            ->expects($this->once())
            ->method('__invoke')
            ->with($record)
            ->willReturn($match);

        $exclude = new Exclude($mock);
        $matched = $exclude($record);

        $this->assertSame($expected, $matched);
    }
}
