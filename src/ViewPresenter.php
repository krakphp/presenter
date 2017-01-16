<?php

namespace Krak\Presenter;

use RuntimeException;

class ViewPresenter extends AbstractPresenter
{
    protected static $cfg;

    protected $view_file    = '';
    protected $view_output  = '';

    /**
     * Sets the view file name
     * @return $this
     */
    public function setViewFile($file)
    {
        $this->view_file = $file;
        return $this;
    }

    /**
     * Returns the view file name
     * @return string
     */
    public function getViewFile()
    {
        return $this->view_file;
    }

    /**
     * Set the necessary config for the ViewFilePresenter
     */
    public static function setConfig(array $cfg)
    {
        /* @TODO - validate config */
        self::$cfg = $cfg;
    }

    /**
     * @inheritDoc
     */
    public function build()
    {
        $path = $this->getViewPath($this->getViewFile());
        $_alias = isset(self::$cfg['view_alias']) ? self::$cfg['view_alias'] : '';

        if (!file_exists($path)) {
            throw new Exception\FileNotFoundException($path);
        }

        ob_start();

        if ($_alias) {
            $$_alias = $this;
        }

        // don't want it to show up in the template
        unset($_alias);

        include $path;

        $this->view_output = ob_get_clean();
        return $this;
    }

    /**
     * Gets the full path for a view file name
     * @return string
     */
    public function getViewPath($view_file)
    {
        if (!static::$cfg) {
            throw new RuntimeException('ViewPresenter config has not been set');
        }

        return sprintf(
            "%s/%s.%s",
            static::$cfg['view_path'],
            $view_file,
            static::$cfg['file_ext']
        );
    }

    /**
     * @inheritDoc
     */
    public function clear()
    {
        unset($this->view_output);
        $this->view_output = '';
        return $this;
    }

    /**
     * @inheritDoc
     */
    public function __toString()
    {
        return $this->view_output;
    }
}
