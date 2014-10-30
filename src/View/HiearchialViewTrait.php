<?php

namespace Krak\Presenter\View;

trait HierarchialViewTrait
{
    use ViewTrait;

    private $content;

    /**
     * @return HierarchialView[]
     */
    public function getChildren()
    {
        return array();
    }

    /**
     * Set the rendered content for this view
     * @var string
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * get the rendered content for this view
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }
}
