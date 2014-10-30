<?php

namespace Krak\Presenter\View;

/**
 * Anonymous View
 * Implements a view that can be created at runtime
 */
class AnonymousView implements View
{
    use ViewTrait;

    /**
     * @param string $view_file
     * @param array $data
     */
    public function __construct($view_file, $data)
    {
        $this->setViewFile($view_file);

        foreach ($data as $key => $val) {
            $this->{$key} = $val;
        }
    }

    /**
     * factory method for creating an anonymous view
     * @param string $view_file
     * @param array $data
     * @return AnonymousView
     */
    public static function create($view_file, $data = array())
    {
        return new self($view_file, $data);
    }
}
