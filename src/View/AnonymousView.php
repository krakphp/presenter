<?php

namespace Krak\Presenter\View;

/**
 * Anonymous View
 * Implements a view that can be created at runtime
 */
class AnonymousView implements View
{
    use ViewTrait;

    public function __construct($view_file, $data)
    {
        $this->setViewFile($view_file);

        foreach ($data as $key => $val) {
            $this->{$key} = $val;
        }
    }

    public static function create($view_file, $data = [])
    {
        return new self($view_file, $data);
    }
}
