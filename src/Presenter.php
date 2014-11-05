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
     * @param mixed $data
     * @return string
     */
    public function present($data);

    /**
     * @param mixed $data
     * @return bool
     */
    public function canPresent($data);
}
