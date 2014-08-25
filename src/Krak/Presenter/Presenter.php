<?php

namespace Krak\Presenter;

/**
 * Basic inteface to implement a presenter
 */
interface Presenter
{
    /**
     * Builds the internal view output. 
     */
    public function build();
        
    /**
     * clears the internal view output
     */
    public function clear();
    
    /**
     * returns the internal view output
     */
    public function __toString();
}
