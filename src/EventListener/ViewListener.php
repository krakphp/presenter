<?php

namespace Krak\Presenter\EventListener;

use Krak\Presenter\Presenter,
    Symfony\Component\EventDispatcher\EventSubscriberInterface,
    Symfony\Component\HttpFoundation\Response,
    Symfony\Component\HttpKernel\KernelEvents,
    Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

class ViewListener implements EventSubscriberInterface
{
    /**
     * @var Presenter
     */
    private $presenter;

    public function __construct(Presenter $presenter)
    {
        $this->presenter = $presenter;
    }

    public function onKernelView(GetResponseForControllerResultEvent $event)
    {
        if (!$event->isMasterRequest()) {
            return;
        }

        $view = $event->getControllerResult();

        if (!$this->presenter->canPresent($view)) {
            return;
        }

        $event->setResponse(
            new Response($this->presenter->present($view))
        );
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['onKernelView', 0],
        ];
    }
}
