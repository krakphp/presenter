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
        return $this->presentRecursive($view, true);
    }

    protected function presentRecursive($view, $is_root = false)
    {
        if ($view instanceof TreeView == false) {
            return $this->presenter->present($view);
        }

        foreach ($view->getChildren() as $child)
        {
            $this->presentRecursive($child);
        }

        /* delegate the actual presentation to the presenter */
        $content = $this->presenter->present($view);
        $view->setContent($content);

        if ($is_root) {
            return $content;
        }
    }
}
