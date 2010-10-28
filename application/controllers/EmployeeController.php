<?php

class EmployeeController extends Zend_Controller_Action
{
    public function  preDispatch()
    {
        $this->view->headlink()->appendStylesheet('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/themes/ui-lightness/jquery-ui.css');
        $this->view->headScript()->appendFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js');
        $this->view->headScript()->appendFile('/public/js/jquery.maskedinput.js');
    }

    public function indexAction()
    {
        $userTable = new Table_User();
        $status = $this->_getParam('status');
        $this->view->users = $userTable->getUsers($status);
    }

    public function formAction()
    {
        $login = $this->_getParam('login');

        $userTable = new Table_User();
        if ($login) $user = $userTable->getUserByLogin($login);
        $userForm  = new Form_UserAdvanced($user);

        if ($this->getRequest()->isPost())
        {
            if ($userForm->isValid($this->getRequest()->getParams()))
            {
                if ($user instanceof Table_User)
                    $userTable->updateUser($user, $userForm->getValues());
                else
                    $userTable->insertUser($userForm->getValues());

                return $this->_redirect('/employee');
            }
        }

        $this->view->userForm = $userForm;
        $this->view->sections = $this->view->userForm->getDisplayGroupNames();
    }

    public function deleteAction()
    {
        $login = $this->_getParam('login');
        Table_User::deleteUser($login);
        $this->_redirect('/employee');
    }
}