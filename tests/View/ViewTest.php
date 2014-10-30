<?php

namespace Krak\Tests\View;

use Krak\Tests\Fixtures\View\TestView;
use Krak\Tests\TestCase;

class ViewTest extends TestCase
{
    public function setUp()
    {}

    public function tearDown()
    {}

    public function testInstanceOf()
    {
        $v = new TestView();
        $this->assertInstanceOf('Krak\Presenter\View\View', $v);
    }

    public function testInitialState()
    {
        $v = new TestView();
        $this->assertNull($v->getViewFile());
    }

    public function testViewFile()
    {
        $v = new TestView();
        $v->setViewFile('file');
        $this->assertEquals('file', $v->getViewFile());
    }
}
