<?php

abstract class App_Controller_Action extends Zend_Controller_Action
{
    public function init()
    {
        if (!Zend_Auth::getInstance()->hasIdentity())
            return $this->_redirect('login');

        $acl = Zend_Registry::get('ACL');

        $role = Zend_Auth::getInstance()->getIdentity()->role;
        $rule = App_Acl_Resources::getResourceType($this->getRequest()->getParams());

        if ( !$acl->isAllowed($role, $rule) )
            throw new App_Exception_Restricted();
    }
}