<?php

namespace Krak\Presenter;

use Krak\Presenter\View\HierarchialView;

class HierarchialViewPresenter implements Presenter
{
    /**
     * @var Presenter
     */
    protected $presenter;

    public function __construct(Presenter $p)
    {
        $this->presenter = $p;
    }

    public function present($view)
    {
        if ($view instanceof HierarchialView == false) {
            return $this->presenter->present($view);
        }

        foreach ($view->getChildren() as $child)
        {
            $content = $this->present($child);
            $child->setContent($content);
        }

        /* delegate the actual presentation to the presenter */
        return $this->presenter->present($view);
    }
}
