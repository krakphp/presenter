<?php

namespace Krak\Presenter\Exception;

class FileNotFoundException extends \RuntimeException
{
    public function __construct($path)
    {
        parent::__construct(sprintf("The file '%s' was not found", $path));
    }
}
