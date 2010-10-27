<?php

class App_View_Helper_Navigation extends Zend_View_Helper_Navigation
{
    public function navigation($config)
    {
        return parent::navigation(new App_Navigation($config));
    }

    public function headline()
    {
        $request  = Zend_Controller_Front::getInstance()->getRequest();
        $resource = App_Acl_Resources::findResource($request);
        return $resource['label'];
    }
}