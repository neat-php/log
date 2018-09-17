<?php

namespace Neat\Log\Test;

use Neat\Log\Manifold;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class ManifoldTest extends TestCase
{
    /**
     * Test manifold without output
     */
    public function testNone()
    {
        $manifold = new Manifold;
        $manifold->log('error', 'Hello o oo  Anyone there e ee???');

        $this->addToAssertionCount(1); // No assertions by design
    }

    /**
     * Provide output counts
     *
     * @return array
     */
    public function provideOutputCounts()
    {
        return [
            [1],
            [2],
            [3],
            [10],
        ];
    }

    /**
     * Test outputs
     *
     * @param int $count
     * @dataProvider provideOutputCounts
     */
    public function testOutputs(int $count)
    {
        $outputs = [];
        for ($index = 0; $index < $count; $index++) {
            $mock = $this->createMock(LoggerInterface::class);
            $mock->expects($this->once())
                ->method('log')
                ->with('error', 'Something went wrong.', []);

            $outputs[] = $mock;
        }

        $manifold = new Manifold(...$outputs);
        $manifold->log('error', 'Something went wrong.', []);
    }
}
