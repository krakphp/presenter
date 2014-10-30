<?php

namespace Krak\Presenter\View;

trait ViewTrait
{
    /**
     * @var string
     */
    private $view_file;

    /**
     * @return string
     */
    public function getViewFile()
    {
        return $this->view_file;
    }

    /**
     * @param string $view_file
     */
    public function setViewFile($view_file)
    {
        $this->view_file = $view_file;
    }
}
