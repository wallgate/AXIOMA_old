<?php

class App_View_Helper_Identity extends Zend_View_Helper_Abstract
{
    public function identity()
    {
        if (Zend_Auth::getInstance()->hasIdentity())
        {
            return Zend_Auth::getInstance()->getIdentity()->login;
        }
        return false;
    }
}