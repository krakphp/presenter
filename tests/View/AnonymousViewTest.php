<?php

namespace Krak\Tests\View;

use Krak\Presenter\View\AnonymousView;
use Krak\Tests\TestCase;

class AnonymousViewTest extends TestCase
{
    public function setUp()
    {}

    public function tearDown()
    {}

    public function testInstanceOf()
    {
        $this->assertInstanceOf(
            'Krak\Presenter\View\View',
            new AnonymousView('', array())
        );
    }

    public function testViewFile()
    {
        $v = new AnonymousView('file', array());
        $this->assertEquals('file', $v->getViewFile());
    }

    public function testData()
    {
        $v = new AnonymousView('file', array('key' => 'value', 'key1' => 'value2'));

        $has_keys = $v->key == 'value' && $v->key1 == 'value2';
        $this->assertTrue($has_keys);
    }

    public function testCreate()
    {
        $v = AnonymousView::create('file');

        $this->assertEquals('file', $v->getViewFile());
        $this->assertEquals(array(), get_object_vars($v));
    }
}
