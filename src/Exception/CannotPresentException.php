<?php

namespace Krak\Presenter\Exception;

class CannotPresentException extends \InvalidArgumentException
{
    public function __construct($presenter_class, $msg)
    {
        parent::__construct(
            sprintf(
                'Presenter "%s" cannot present the given data: %s',
                $presenter_class,
                $msg
            )
        );
    }
}
