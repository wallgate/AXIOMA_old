<?php

class App_View_Helper_Navigation extends Zend_View_Helper_Navigation
{
    protected $config;

    public function navigation($config)
    {
        $this->config = $config;
        return parent::navigation(new App_Navigation($config));
    }

    public function headline()
    {
        return false;
    }
}