<?php

class App_Controller_Plugin_AccessControl extends Zend_Controller_Plugin_Abstract
{
    protected $acl;


    public function dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        $controller = $request->getParam('controller');
        $action     = $request->getParam('action');

        if (in_array($controller, array('login', 'error'))) return;

        if (!Zend_Auth::getInstance()->hasIdentity())
        {
            $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');
            $redirector->gotoUrl('/login');
        }

        $this->acl = $this->initAcl();
        $role      = Zend_Auth::getInstance()->getIdentity()->role;
        $resource  = App_Acl_Resources::getResourceAlias($request);

        // временная мера: суперпользователь
        //if ($role == 2) return;

        if ( !$this->acl->isAllowed($role, $resource) )
        {
            $request->setControllerName('error')
                    ->setActionName('restricted')
                    ->setDispatched(false);

            //$this->_response->setException(new App_Exception_Restricted());
        }
    }


    
    protected function initAcl()
    {
        $acl = new Zend_Acl();

        $acl->deny();

        $resourceList = App_Acl_Resources::getResources();
        foreach (array_keys($resourceList) as $resource)
            $acl->add(new Zend_Acl_Resource($resource));

        $roleList = Table_Role::getRoles();
        foreach ($roleList as $role)
        {
            $acl->addRole(new Zend_Acl_Role($role['id']));

            foreach ($role['Permissions'] as $permission)
                $acl->allow($role['id'], $permission);
        }

        return $acl;
    }

    

    public function getAcl()
    {
        return $this->acl;
    }
}