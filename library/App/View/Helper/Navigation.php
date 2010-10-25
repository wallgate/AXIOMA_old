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
        $request = Zend_Controller_Front::getInstance()->getRequest();
        $controller = $request->getControllerName();
        $action     = $request->getActionName();

        $resources = App_Acl_Resources::getResources();
        $resource = $resources['/'.$controller.'/'.$action];

        return $resource['label'];
    }
}