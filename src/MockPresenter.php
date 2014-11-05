<?php

namespace Krak\Presenter;

use Krak\Presenter\Exception\CannotPresentException;

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
        if (!$this->canPresent($obj)) {
            throw new CannotPresentException(
                'MockPresenter',
                'object was not found in storage'
            );
        }

        return $this->storage[$obj];
    }

    public function canPresent($obj)
    {
        if (!is_object($obj) || !isset($this->storage[$obj])) {
            return false;
        }

        return true;
    }
}
