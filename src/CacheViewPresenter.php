<?php

namespace Krak\Presenter;

use Doctrine\Common\Cache\Cache;
use Krak\Presenter\View\CacheableView;

class CacheViewPresenter implements Presenter
{
    /**
     * @var Presenter
     */
    protected $presenter;

    /**
     * @var Cache
     */
    protected $cache;

    public function __construct(Presenter $presenter, Cache $cache)
    {
        $this->presenter = $presenter;
        $this->cache = $cache;
    }

    public function present($view)
    {
        if ($view instanceof CacheableView == false) {
            return $this->presenter->present($view);
        }

        list($key, $ttl) = $view->getCacheTuple();

        $contents = $this->cache->fetch($key);

        if ($contents === false) {
            return $contents;
        }

        $contents = $this->presenter->present($view);

        $this->cache->save($key, $contents, $ttl);

        return $contents;
    }
}
