<?php

namespace Krak\Tests\View;

use Krak\Tests\Fixtures\View\TestTraitTreeView as TestView,
    Krak\Tests\TestCase;

class TreeViewTest extends TestCase
{
    public function setUp()
    {}

    public function tearDown()
    {}

    public function testInstanceOf()
    {
        $v = new TestView();
        $this->assertInstanceOf('Krak\Presenter\View\TreeView', $v);
    }

    public function testGetChildren()
    {
        $v = new TestView();
        $this->assertEquals(array(), $v->getChildren());
    }

    public function testInitialState()
    {
        $v = new TestView();
        $this->assertNull($v->getContent());
    }

    public function testContent()
    {
        $v = new TestView();
        $v->setContent('content');
        $this->assertEquals('content', $v->getContent());
    }
}
