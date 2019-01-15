<?php

namespace Neat\Log\Test;

use Neat\Log\Stream;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamFile;
use PHPUnit\Framework\TestCase;

class StreamTest extends TestCase
{
    public function testCreate()
    {
        $stream = new Stream(fopen('/dev/null', 'a'));

        $this->assertInstanceOf(Stream::class, $stream);
    }

    public function testCreatNotWritable()
    {
        $this->expectException(\RuntimeException::class);
        new Stream(fopen('/dev/null', 'r'));
    }

    public function testCreateNoResource()
    {
        $this->expectException(\TypeError::class);
        new Stream('/dev/null');
    }

    public function testLog()
    {
        $root = vfsStream::setup();

        $stream = new Stream(fopen($root->url() . '/file.log', 'a'));

        $stream->log('error', 'Something happened');

        /** @var vfsStreamFile $child */
        $child = $root->getChild('file.log');
        $this->assertInstanceOf(vfsStreamFile::class, $child);
        $this->assertEquals('Something happened' . PHP_EOL, $child->getContent());
    }
}
