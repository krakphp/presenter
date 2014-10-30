<?php

namespace Krak\Tests;

use Krak\Presenter\Buffer;
use Krak\Tests\TestCase;

class BufferTest extends TestCase
{
    public function setUp()
    {}

    public function tearDown()
    {}

    public function testEmptyBuffer()
    {
        $buf = new Buffer();
        $this->assertEquals('', $buf->getContents());
    }

    public function testAppend()
    {
        $buf = new Buffer();
        $buf->append('con');
        $buf->append('tents');

        $this->assertEquals('contents', $buf->getContents());
    }

    public function testSetContents()
    {
        $buf = new Buffer();
        $buf->setContents('contents');

        $this->assertEquals('contents', $buf->getContents());
    }

    public function testBuffering()
    {
        $buf = new Buffer();

        $buf->start();?>
data
<?php $buf->end();

        $this->assertEquals("data\n", $buf->getContents());
    }
}
