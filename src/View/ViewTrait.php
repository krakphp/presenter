<?php

namespace Krak\Presenter\View;

trait ViewTrait
{
    private $view_file;

    public function getViewFile()
    {
        return $this->view_file;
    }

    public function setViewFile($view_file)
    {
        $this->view_file = $view_file;
    }
}
