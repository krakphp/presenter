<?php

namespace Krak\Presenter;

use Krak\Presenter\View\TreeView;

/**
 * Tree Presenter
 * a presenter decorator that will traverse a hierarchy/tree of views present
 * their data and then set the data into the view to be used. It then returns
 * the root views content.
 */
class TreePresenter implements Presenter
{
    /**
     * @var Presenter
     */
    protected $presenter;

    /**
     * @param Presenter $p
     */
    public function __construct(Presenter $p)
    {
        $this->presenter = $p;
    }

    /**
     * @param mixed $view
     * @return string
     */
    public function present($view)
    {
        if ($view instanceof TreeView == false) {
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
