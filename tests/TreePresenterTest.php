<?php

namespace Krak\Tests;

use Krak\Presenter\MockPresenter;
use Krak\Presenter\TreePresenter;
use Krak\Tests\Fixtures\View\TestTreeChildView as TestChildView;
use Krak\Tests\Fixtures\View\TestTreeView as TestView;
use Krak\Tests\TestCase;

use stdClass;

class TreePresenterTest extends TestCase
{
    private $mock_p;

    public function setUp()
    {
        $this->mock_p = new MockPresenter();
        $this->p = new TreePresenter($this->mock_p);
    }

    public function tearDown()
    {
        $this->mock_p = null;
        $this->p = null;
    }

    public function testPresenterChains()
    {
        $view = new stdClass();
        $this->mock_p->mock($view, 'data');

        $this->assertEquals('data', $this->p->present($view));
    }

    public function testPresenterNoChildren()
    {
        $view = new TestChildView();
        $this->mock_p->mock($view, 'data');

        $this->assertEquals('data', $this->p->present($view));
    }

    public function testPresenterTree()
    {
        $view = new TestView();
        list($child) = $view->getChildren();

        $this->mock_p->mock($view, 'parent');
        $this->mock_p->mock($child, 'child');

        $this->p->present($view);

        $this->assertEquals('child', $child->getContent());
    }
}