<?php

namespace Krak\Presenter;

use RuntimeException;

class ViewPresenter extends AbstractPresenter
{
    private static $cfg;
    
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
        if (!self::$cfg) {
            throw new RuntimeException('ViewPresenter config has not been set');
        }
    
        $file = sprintf(
            "%s/%s.%s",
            static::$cfg['view_path'],
            $file,
            static::$cfg['file_ext']
        );
        
        ob_start();
        
        require $file;
        
        $this->view_ouput = ob_get_clean();
        return $this;
        
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
