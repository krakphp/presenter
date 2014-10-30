<?php

namespace Krak\Presenter\View;

interface HierarchialView extends View
{
    /**
     * @return HierarchialView[]
     */
    public function getChildren();

    /**
     * Set the rendered content for this view
     * @var string
     */
    public function setContent($content);

    /**
     * get the rendered content for this view
     * @return string
     */
    public function getContent();
}
