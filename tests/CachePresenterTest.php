<?php

namespace Krak\Tests;

use Krak\Presenter\CachePresenter;
use Krak\Presenter\MockPresenter;
use Krak\Tests\Fixtures\MockCache;
use Krak\Tests\Fixtures\View\TestCacheableView as TestView;
use Krak\Tests\TestCase;

use stdClass;

class CachePresenterTest extends TestCase
{
    private $mock_p;
    private $cache;

    public function setUp()
    {
        $this->mock_p = new MockPresenter();
        $this->cache = new MockCache();
        $this->p = new CachePresenter($this->mock_p, $this->cache);
    }

    public function tearDown()
    {
        $this->mock_p = null;
        $this->cache = null;
        $this->p = null;
    }

    public function testPresenterChains()
    {
        $view = new stdClass();
        $this->mock_p->mock($view, 'data');

        $this->assertEquals('data', $this->p->present($view));
    }

    public function testPresenterNoCache()
    {
        $view = new stdClass();
        $this->mock_p->mock($view, 'data');

        $this->p->present($view);

        $this->assertCount(0, $this->cache->getData());
    }

    public function testCacheMiss()
    {
        $view = new TestView();
        $this->mock_p->mock($view, 'data');

        $content = $this->p->present($view);

        $this->assertEquals('data', $content);
        $this->assertEquals('data', $this->cache->fetch('key'));
    }

    public function testCacheHit()
    {
        $view = new TestView();
        $this->mock_p->mock($view, 'data');

        $this->cache->save('key', 'not-data');

        $content = $this->p->present($view);

        $this->assertEquals('not-data', $content);
    }

    public function testCanPresent()
    {
        $this->assertFalse($this->p->canPresent('value'));
    }
}
