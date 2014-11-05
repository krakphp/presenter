<?php

namespace Krak\Tests;

use Krak\Presenter\Exception\FileNotFoundException,
    Krak\Presenter\Exception\CannotPresentException,
    Krak\Presenter\View\AnonymousView,
    Krak\Presenter\ViewPresenter,
    Krak\Tests\Fixtures\View\TestView,
    Krak\Tests\TestCase,
    InvalidArgumentException,
    Symfony\Component\Config\FileLocator;

class ViewPresenterTest extends TestCase
{
    /**
     * @var FileLocator
     */
    private $locator;

    public function setUp()
    {
        $this->locator = new FileLocator(__DIR__ . '/Fixtures/Resources/views');
    }

    public function tearDown()
    {
        $this->locator = null;
    }

    public function testInstanceOf()
    {
        $p = new ViewPresenter($this->locator);
        $this->assertInstanceOf('Krak\Presenter\Presenter', $p);
    }

    public function testConstructor()
    {
        $p = new ViewPresenter($this->locator, 'php', 'v');
        $this->assertEquals('php', $p->getExtension());
        $this->assertEquals('v', $p->getViewAlias());
    }

    public function testViewAliasException()
    {
        $p = new ViewPresenter($this->locator);

        try {
            $p->setViewAlias('12');
            $this->assertTrue(false, 'did not throw an exception');
        } catch (InvalidArgumentException $e) {
            $this->assertEquals("alias '12' is not a valid alias", $e->getMessage());
        }
    }

    public function testPresentSimple()
    {
        $p = new ViewPresenter($this->locator, 'phtml');
        $content = $p->present(AnonymousView::create('test1'));
        $this->assertEquals("test-content\n", $content);
    }

    public function testPresentNotAView()
    {
        $p = new ViewPresenter($this->locator);

        try {
            $p->present('data');
            $this->assertTrue(false, 'did not throw an exception');
        } catch (CannotPresentException $e) {
            $this->assertTrue(true);
        }
    }

    public function testPresentFileNotFound()
    {
        $p = new ViewPresenter($this->locator);

        try {
            $p->present(AnonymousView::create('bad-name'));
            $this->assertTrue(false, 'did not throw an exception');
        } catch (FileNotFoundException $e) {
            $this->assertTrue(true);
        }
    }

    public function testDynamicContent()
    {
        $p = new ViewPresenter($this->locator, 'phtml', 'v');

        $v = new TestView();
        $v->setViewFile('test-view');

        $content = $p->present($v);

        $this->assertEquals('dynamic-content', $content);
    }
}
