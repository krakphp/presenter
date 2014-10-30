<?php

namespace Krak\Presenter;

use Krak\Presenter\Exception\FileNotFoundException;
use Krak\Presenter\View\View;
use InvalidArgumentException;
use Symfony\Component\Config\FileLocator;

class ViewPresenter implements Presenter
{
    /**
     * @var FileLocator
     */
    protected $locator;

    /**
     * @var string
     */
    protected $ext;

    /**
     * @var string
     */
    protected $view_alias;

    public function __construct(FileLocator $locator, $ext = '', $view_alias = 'view')
    {
        $this->locator = $locator;
        $this->setExtension($ext);
        $this->setViewAlias($view_alias);
    }

    public function setViewAlias($alias)
    {
        if (!preg_match('/[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*/', $alias)) {
            throw new InvalidArgumentException(
                sprintf("alias '%s' is not a valid alias", $alias)
            );
        }

        $this->view_alias = $alias;
    }

    public function getViewAlias()
    {
        return $this->view_alias;
    }

    public function setExtension($ext)
    {
        $this->ext = ($ext) ? '.' . $ext : '';
    }

    public function getExtension()
    {
        return $this->ext;
    }

    /**
     * Presents a View object
     * @var View $view
     * @return string
     */
    public function present($view)
    {
        if ($view instanceof View == false) {
            throw new InvalidArgumentException(
                'expected view to be an instance of Krak\\Presenter\\View'
            );
        }

        $file = $view->getViewFile() . $this->ext;

        try {
            $file = $this->locator->locate($file);
        } catch (InvalidArgumentException $e) {
            throw new FileNotFoundException($e->getMessage());
        }

        /* we have the file, so let's load up the view */
        return self::loadView($file, $view, $this->view_alias);
    }

    /**
     * self contained view loader to minimize
     * any state or variables being included in the view
     * @param
     */
    protected static function loadView($file, $view, $alias)
    {
        ob_start();

        $$alias = $view;

        include $file;

        return ob_get_contents();
    }
}
