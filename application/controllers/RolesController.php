<?php

class RolesController extends Zend_Controller_Action
{
    public function  preDispatch()
    {
        $this->view->headlink()->appendStylesheet('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/themes/ui-lightness/jquery-ui.css');
        $this->view->headScript()->appendFile('http://ajax.googleapis.com/ajax/libs/jqueryui/1.8.5/jquery-ui.min.js');
    }


    public function indexAction()
    {
        $this->view->roles = App_Acl_Roles::getRoles();
    }

    public function permissionsAction()
    {
        $roles    = App_Acl_Roles::getRoles();
        $role     = $roles[$this->_getParam('role')];
        $roleForm = new Form_Permissions($role);

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

        $this->view->roleForm = $roleForm;
    }

    public function deleteAction()
    {
        $roleName = $this->_getParam('role');

        try
        {
            App_Acl_Roles::getRole($roleName)->delete();
            $this->_redirect('/roles');
        }
        catch (Doctrine_Connection_Mysql_Exception $e)
        {
            throw new Exception('Должность нельзя удалить, поскольку к ней привязаны сотрудники');
        }
    }
}