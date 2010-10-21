<?php

class App_View_Helper_Navigation extends Zend_View_Helper_Navigation
{
    public function navigation($config)
    {
        return parent::navigation(new App_Navigation($config));
    }
}