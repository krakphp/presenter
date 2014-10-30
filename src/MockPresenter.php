<?php

namespace Krak\Presenter;

use RuntimeException;
use SplObjectStorage;

/**
 * Mock Presenter
 * Used for testing other presenters and views
 */
class MockPresenter implements Presenter
{
    /**
     * @var SplObjectStorage
     */
    private $storage;

    public function __construct()
    {
        $this->storage = new SplObjectStorage();
    }

    /**
     * @return SplObjectStorage
     */
    public function getStorage()
    {
        return $this->storage;
    }

    /**
     * @param mixed $obj
     * @param string $data
     */
    public function mock($obj, $data)
    {
        $this->storage->attach($obj, $data);
    }

    /**
     * @param mixed $obj
     * @return string
     */
    public function present($obj)
    {
        if (!isset($this->storage[$obj])) {
            throw new RuntimeException('object provided was not in storage');
        }

        return $this->storage[$obj];
    }
}
