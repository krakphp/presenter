<?php

namespace Krak\Tests\Fixtures\View;

use Krak\Presenter\View\TreeView;
use Krak\Presenter\View\TreeViewTrait;

class TestTreeView implements TreeView
{
    use TreeViewTrait;

    private $child;

    public function __construct()
    {
        $this->child = new TestTreeChildView();
    }

    public function getChildren()
    {
        return array($this->child);
    }
}
