<?php

namespace Krak\Tests\Fixtures\View;

use Krak\Presenter\View\View,
    Krak\Presenter\View\ViewTrait;

class TestView implements View
{
    use ViewTrait;

    public function getDynamicContent()
    {
        return 'dynamic-content';
    }
}
