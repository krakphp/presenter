<?php

namespace Krak\Tests\View;

use Krak\Tests\Fixtures\View\TestCacheableView as TestView;
use Krak\Tests\TestCase;

class CacheableViewTest extends TestCase
{
    public function setUp()
    {}

    public function tearDown()
    {}

    public function testInstanceOf()
    {
        $v = new TestView();
        $this->assertInstanceOf('Krak\Presenter\View\CacheableView', $v);
    }

    public function testCacheTuple()
    {
        $v = new TestView();
        $this->assertEquals(array('key', 3600), $v->getCacheTuple());
    }
}
