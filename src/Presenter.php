<?php

namespace Krak\Presenter;

/**
 * Presenter
 * A presenter simply takes data and transforms it into a string
 * to be presented/displayed
 */
interface Presenter
{
    /**
     * Present the view and return the content associated with it
     * @param mixed $view
     * @return string
     */
    public function present($view);

    /**
     * Whether or not the presenter can actually present the data/view
     * @param mixed $data
     * @return bool
     */
    public function canPresent($view);
}
