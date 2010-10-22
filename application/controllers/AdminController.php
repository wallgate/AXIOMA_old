<?php

class AdminController extends App_Controller_Action
{
    public function indexAction()
    {      
        $this->view->userForm = new Form_UserAdvanced();
        $this->view->sections = $this->view->userForm->getDisplayGroupNames();

        if ($this->getRequest()->isPost())
        {
            if ($this->view->userForm->isValid($this->getRequest()->getParams()))
            {
                $userTable = new Table_User();
                $userTable->insertUser($this->getRequest()->getParams());
            }
        }
    }
}