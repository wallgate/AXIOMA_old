<?php

abstract class App_Controller_Action extends Zend_Controller_Action
{
    const ERROR_RESTRICTED = -99;


    public function init()
    {
        if (Zend_Auth::getInstance()->hasIdentity())
            return $this->accessControl(Zend_Auth::getInstance()->getIdentity());
        
        if ($this->getRequest()->isPost())
        {
            $login    = $this->_getParam('login');
            $password = $this->_getParam('password');

            $adapter = new App_Auth_Adapter($login, $password);
            $result  = Zend_Auth::getInstance()->authenticate($adapter);

            if (Zend_Auth::getInstance()->hasIdentity())
                return $this->accessControl(Zend_Auth::getInstance()->getIdentity());

            $this->view->errorMessages = implode('<br/>', $result->getMessages());
        }

        $this->_helper->layout()->setLayout('login');
        $this->view->loginForm = new Form_Login($login);
    }

    protected function accessControl($auth)
    {
        $acl      = new App_Acl($auth);

        $role     = $auth->role;
        $resource = App_Acl_Resources::getResourceType($this->getRequest());
echo 'ROLE '.$role; echo '<br/>RESOURCE '.$resource;
        if ( !$acl->isAllowed($role, $resource) )
            throw new Exception(self::ERROR_RESTRICTED);
    }
}