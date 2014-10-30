<?php

namespace Krak\Presenter\View;

/**
 * Cacheable View
 * A view that is able to be cached.
 */
interface CacheableView
{
    /**
     * Returns a tuple of the cache key and ttl
     * @return array
     */
    public function getCacheTuple();
}
