<?php

namespace Krak\Presenter;

/**
 * Buffer
 * A utility class for holding data. This is very useful when you want to share
 * a buffer across many views
 */
class Buffer
{
    protected $contents = '';

    /**
     * @return string
     */
    public function getContents()
    {
        return $this->contents;
    }

    /**
     * @param string $contents
     */
    public function setContents($contents)
    {
        $this->contents = $contents;
    }

    /**
     * @param string $contents
     */
    public function append($contents)
    {
        $this->contents .= $contents;
    }

    /**
     * Create an output buffer
     */
    public function start()
    {
        ob_start();
    }

    /**
     * Clean the buffer and append the contents
     */
    public function end()
    {
        $this->append(ob_get_clean());
    }
}
