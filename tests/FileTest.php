<?php

namespace Neat\Log\Test;

use Neat\Log\File;
use org\bovigo\vfs\vfsStream;
use org\bovigo\vfs\vfsStreamFile;
use PHPUnit\Framework\TestCase;
use Psr\Log\LoggerInterface;

class FileTest extends TestCase
{
    /**
     * Test create
     */
    public function testCreate()
    {
        $file = new File('/some/log/file');

        $this->assertInstanceOf(LoggerInterface::class, $file);
    }

    /**
     * Test log
     */
    public function testLog()
    {
        $root = vfsStream::setup();

        $file = new File($root->url() . '/file.log');
        $this->assertFalse($root->hasChild('file.log'));

        $file->log('error', 'Something happened');

        $this->assertTrue($root->hasChild('file.log'));

        /** @var vfsStreamFile $child */
        $child = $root->getChild('file.log');
        $this->assertInstanceOf(vfsStreamFile::class, $child);
        $this->assertEquals('Something happened' . PHP_EOL, $child->getContent());
    }

    /**
     * Test logging in a new directory
     */
    public function testLogNewDirectory()
    {
        $root = vfsStream::setup();

        $file = new File($root->url() . '/new/file.log');
        $this->assertFalse($root->hasChild('new'));
        $this->assertFalse($root->hasChild('new/file.log'));

        $file->log('error', 'Something happened');

        $this->assertTrue($root->hasChild('new'));
        $this->assertTrue($root->hasChild('new/file.log'));

        /** @var vfsStreamFile $child */
        $child = $root->getChild('new/file.log');
        $this->assertInstanceOf(vfsStreamFile::class, $child);
        $this->assertEquals('Something happened' . PHP_EOL, $child->getContent());
    }

    /**
     * Test logging without filesystem permissions
     */
    public function testWithoutPermissions()
    {
        $root = vfsStream::setup();
        $root->chmod(0000);

        $file = new File($root->url() . '/file.log');
        $file->log('error', 'Something happened');

        $this->assertFalse($root->hasChildren());
    }

    /**
     * Test logging in a new directory without filesystem permissions
     */
    public function testNewDirectoryWithoutPermissions()
    {
        $root = vfsStream::setup();
        $root->chmod(0000);

        $file = new File($root->url() . '/new/file.log');
        $file->log('error', 'Something happened');

        $this->assertFalse($root->hasChildren());
    }
}
