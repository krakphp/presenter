<?php

namespace Krak\Presenter;

/**
 * Abstract Presenter
 * This implements a few helper functions
 */
abstract class AbstractPresenter implements Presenter
{
    /**
     * Mass assigns an array of data to hydrate the presenter
     * @param array $data
     * @return $this
     */
    public function hydrate($data)
    {
        foreach ($data as $key => $val)
        {
            $this->{$key} = $val;
        }
        return $this;
    }
    
    /**
     * Factory method for creating and hydrating
     * @param array $data Data to be hydrated on the created presenter
     * @return AbstractPresenter
     */
    public static function create($data = array())
    {
        $self = new static();
        return $self->hydrate($data);
    }
    
    /**
     * @inheritDoc
     */
    abstract public function build();
    
    /**
     * @inheritDoc
     */
    abstract public function clear();
    
    /**
     * @inheritDoc
     */
    abstract public function __toString();
}
