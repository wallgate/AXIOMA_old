<?php

class RolesController extends Zend_Controller_Action
{
    public function indexAction()
    {
        $this->view->roles = App_Acl_Roles::getRoles();
    }

    public function permissionsAction()
    {
        $roles    = App_Acl_Roles::getRoles();
        $role     = $roles[$this->_getParam('role')];
        $roleForm = new Form_Permissions();

        if ($this->getRequest()->isPost())
        {
            if ($roleForm->isValid($this->getRequest()->getParams()))
            {
                $roleTable = new Table_Role();

                if ($role)
                    $roleTable->updateRole($role, $this->getRequest()->getParams());
                else
                    $roleTable->insertRole($roleForm->getValues());

                return $this->_redirect('/roles');
            }
        }

        if ($role instanceof Table_Role)
            $roleForm->populate($role->getData());
        $this->view->roleForm = $roleForm;
    }

    public function deleteAction()
    {
        
    }
}