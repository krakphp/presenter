<?php

namespace Krak\Tests\EventListener;

use Krak\Presenter\EventListener\ViewListener,
    Krak\Presenter\MockPresenter,
    Krak\Tests\TestCase,
    StdClass,
    Symfony\Component\HttpFoundation\Request,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent as Event,
    Symfony\Component\HttpKernel\HttpKernelInterface;

class ViewListenerTest extends TestCase
{
    private $kernel;

    public function setUp()
    {
        $this->kernel = $this->getMock('Symfony\Component\HttpKernel\HttpKernelInterface');
    }

    public function tearDown()
    {
        $this->kernel = null;
    }

    public function testSubscribedEvents()
    {
        $this->assertInternalType('array', ViewListener::getSubscribedEvents());
    }

    public function testKernelViewNotMasterRequest()
    {
        $obj = new StdClass();

        $presenter = new MockPresenter();
        $presenter->mock($obj, 'value');

        $event = new Event(
            $this->kernel,
            new Request(),
            HttpKernelInterface::SUB_REQUEST,
            $obj
        );

        $listener = new ViewListener(new MockPresenter());
        $listener->onKernelView($event);

        $this->assertNull($event->getResponse());
    }

    public function testKernelViewNotView()
    {
        $event = new Event(
            $this->kernel,
            new Request(),
            HttpKernelInterface::MASTER_REQUEST,
            []
        );

        $listener = new ViewListener(new MockPresenter());
        $listener->onKernelView($event);

        $this->assertNull($event->getResponse());
    }

    public function testKernelView()
    {
        $obj = new StdClass();

        $presenter = new MockPresenter();
        $presenter->mock($obj, 'value');

        $event = new Event(
            $this->kernel,
            new Request(),
            HttpKernelInterface::MASTER_REQUEST,
            $obj
        );

        $listener = new ViewListener($presenter);
        $listener->onKernelView($event);

        $this->assertEquals('value', $event->getResponse()->getContent());
    }
}
