<?php

class RoleController extends Zend_Controller_Action
{
    public function listAction()
    {
        $this->view->roles = Table_Role::getRolesFromCache();
    }

    public function formAction()
    {

    }

    public function deleteAction()
    {
        
    }
}