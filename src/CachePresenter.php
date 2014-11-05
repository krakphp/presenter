<?php

namespace Krak\Presenter;

use Doctrine\Common\Cache\Cache,
    Krak\Presenter\View\CacheableView;

/**
 * Cache Presenter
 * A presenter decorator that will cache any object that implements
 * the CacheableView interface
 */
class CachePresenter implements Presenter
{
    /**
     * @var Presenter
     */
    protected $presenter;

    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @param Presenter $presenter
     * @param Cache $cache
     */
    public function __construct(Presenter $presenter, Cache $cache)
    {
        $this->presenter = $presenter;
        $this->cache = $cache;
    }

    /**
     * @param mixed $view
     * @return string
     */
    public function present($view)
    {
        if ($view instanceof CacheableView == false) {
            return $this->presenter->present($view);
        }

        list($key, $ttl) = $view->getCacheTuple();

        $contents = $this->cache->fetch($key);

        if ($contents !== false) {
            return $contents;
        }

        $contents = $this->presenter->present($view);

        $this->cache->save($key, $contents, $ttl);

        return $contents;
    }

    /**
     * @inheritDoc
     */
    public function canPresent($data)
    {
        return $this->presenter->canPresent($data);
    }
}
