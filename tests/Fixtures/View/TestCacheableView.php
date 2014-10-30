<?php

namespace Krak\Tests\Fixtures\View;

use Krak\Presenter\View\CacheableView;

class TestCacheableView implements CacheableView
{
    public function getCacheTuple()
    {
        return array('key', 3600);
    }
}
