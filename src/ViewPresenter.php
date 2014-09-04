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
    public function setFile($file)
    {
        $this->view_file = $file;
        return $thsi;
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
        if (!static::$cfg) {
            throw new RuntimeException('ViewPresenter config has not been set');
        }
        
        $file = $this->getViewFilePath();
        
        if (!file_exists($file))
        {
            throw new RuntimeException(
                sprintf(
                    "View file '%s' does not exist.",
                    $file
                )
            );
        }
        
        ob_start();
        
        include $file;
        
        $this->view_output = ob_get_clean();
        return $this;
    }
    
    protected function getViewFilePath()
    {
        return sprintf(
            "%s/%s.%s",
            static::$cfg['view_path'],
            $this->view_file,
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
