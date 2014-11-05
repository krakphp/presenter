<?php

namespace Krak\Tests\xxx;

use InvalidArgumentException,
    Krak\Presenter\Provider\ViewPresenterServiceProvider as Provider,
    Krak\Tests\TestCase,
    Pimple\Container,
    RuntimeException,
    Symfony\Component\Config\FileLocator;


class ViewPresenterServiceProviderTest extends TestCase
{
    public function setUp()
    {
        $this->c = new Container();
    }

    public function tearDown()
    {
        $this->c = null;
    }

    public function testRegister()
    {
        $this->c->register(
            new Provider(),
            [
                'presenter.paths' => [__DIR__],
                'presenter.ext' => 'php',
                'presenter.view_alias' => 'v'
            ]
        );

        $presenter = $this->c['presenter'];
        $locator = $this->c['presenter.file_locator'];

        $this->assertInstanceOf('Krak\Presenter\ViewPresenter', $presenter);
        $this->assertInstanceOf('Symfony\Component\Config\FileLocator', $locator);
        $this->assertEquals('php', $presenter->getExtension());
        $this->assertEquals('v', $presenter->getViewAlias());

        try {
            $locator->locate('ViewPresenterServiceProviderTest.php');
            $this->assertTrue(true);
        } catch (InvalidArgumentException $e) {
            $this->assertTrue(false, 'file locator was not setup right');
        }
    }

    public function testPathsException()
    {
        $this->c->register(new Provider());

        try {
            $presenter = $this->c['presenter'];
            $this->assertTrue(false, 'exception was not throw');
        } catch (RuntimeException $e) {
            $this->assertTrue(true);
        }
    }

    public function testFileLocatorSet()
    {
        $locator = new FileLocator(__DIR__);

        $this->c->register(new Provider(), [
            'presenter.file_locator' => function() use ($locator) {
                return $locator;
            }
        ]);

        $presenter = $this->c['presenter'];
        $this->assertEquals($locator, $this->c['presenter.file_locator']);
    }
}

