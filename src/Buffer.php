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
}
