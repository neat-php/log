<?php

namespace Neat\Log\Test;

use Neat\Log\Normalize;
use PHPUnit\Framework\TestCase;

class NormalizeTest extends TestCase
{
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
     * Test normalize string
     *
     * @param mixed  $value
     * @param string $expected
     * @dataProvider provideStringData
     */
    public function testString($value, string $expected)
    {
        $this->assertSame($expected, Normalize::string($value));
    }

    /**
     * Test normalize strings
     */
    public function testStrings()
    {
        $this->assertSame([], Normalize::strings(null));
        $this->assertSame([], Normalize::strings([]));
        $this->assertSame(['x'], Normalize::strings(['x']));
        $this->assertSame(['x'], Normalize::strings(['x']));
    }
}
