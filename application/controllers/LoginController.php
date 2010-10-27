<?php

class LoginController extends Zend_Controller_Action
{
    public function indexAction()
    {
        if ($this->getRequest()->isPost())
        {
            $login    = $this->_getParam('login');
            $password = $this->_getParam('password');

            $adapter = new App_Auth_Adapter($login, $password);
            $result  = Zend_Auth::getInstance()->authenticate($adapter);

            if (Zend_Auth::getInstance()->hasIdentity())
                return $this->_redirect('/');

            $this->view->errorMessages = implode('<br/>', $result->getMessages());
        }

        $this->view->loginForm = new Form_Login($login);
        $this->_helper->layout()->disableLayout(true);
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('/');
    }
}