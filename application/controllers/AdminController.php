<?php

class AdminController extends App_Controller_Action
{
    public function  preDispatch()
    {
        $this->view->headScript()->appendFile('/public/js/jquery-ui-1.8.5.min.js');
        $this->view->headScript()->appendFile('/public/js/jquery.maskedinput.js');
    }

    public function indexAction() {}

    public function employeelistAction()
    {
        $userTable = new Table_User();
        $this->view->users = $userTable->getUsers();
        
    }

    public function employeeAction()
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

                return $this->_redirect('/admin/employeelist');
            }
        }

        $this->view->userForm = $userForm;
        $this->view->sections = $this->view->userForm->getDisplayGroupNames();
    }

    public function delemployeeAction()
    {
        $login = $this->_getParam('login');
        Table_User::deleteUser($login);
        $this->_redirect('/admin/employeelist');
    }
}