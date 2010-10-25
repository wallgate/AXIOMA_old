<?php

class EmployeeController extends App_Controller_Action
{
    public function  preDispatch()
    {
        $this->view->headlink()->appendStylesheet('/public/css/jquery-ui-1.8.5.css');
        $this->view->headScript()->appendFile('/public/js/jquery-ui-1.8.5.min.js');
        $this->view->headScript()->appendFile('/public/js/jquery.maskedinput.js');
    }

    public function listAction()
    {
        $userTable = new Table_User();
        $status = $this->_getParam('status');
        $this->view->users = $userTable->getUsers($status);
    }

    public function formAction()
    {
        $userTable = new Table_User();
        $login = $this->_getParam('login');
        if ($login)
            $user = $userTable->getUserByLogin($login);
        $userForm  = new Form_UserAdvanced($user);

        if ($this->getRequest()->isPost())
        {
            if ($userForm->isValid($this->getRequest()->getParams()))
            {
                if ($user instanceof Table_User)
                    $userTable->updateUser($login, $userForm->getValues());
                else
                    $userTable->insertUser($userForm->getValues());

                return $this->_redirect('/employee/list');
            }
        }

        $this->view->userForm = $userForm;
        $this->view->sections = $this->view->userForm->getDisplayGroupNames();
    }

    public function deleteAction()
    {
        $login = $this->_getParam('login');
        Table_User::deleteUser($login);
        $this->_redirect('/employee/list');
    }
}