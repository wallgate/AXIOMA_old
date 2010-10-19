<?php

abstract class App_Controller_Action extends Zend_Controller_Action
{
    public function init()
    {
        if (Zend_Auth::getInstance()->hasIdentity()) return;
        
        if ($this->getRequest()->isPost())
        {
            $login    = $this->_getParam('login');
            $password = $this->_getParam('password');

            $adapter = new App_Auth_Adapter($login, $password);
            $result  = Zend_Auth::getInstance()->authenticate($adapter);

            if (Zend_Auth::getInstance()->hasIdentity()) return;

            $this->view->errorMessages = implode('<br/>', $result->getMessages());
        }

        $this->_helper->layout()->setLayout('login');
        $this->view->loginForm = new Form_Login($login);
    }
}