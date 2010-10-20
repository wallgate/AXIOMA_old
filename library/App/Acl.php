<?php

class App_Acl extends Zend_Acl
{
    public function __construct($auth = null)
    {
        $this->deny();

        $resources = new App_Acl_Resources(Table_Resource::getAllResources());
        foreach ($resources->getResources() as $resource)
            $this->add(new Zend_Acl_Resource($resource['id']));

        $roles = Table_Role::getRoles();
        foreach ($roles as $role)
        {
            $this->addRole(new Zend_Acl_Role($role['id']));

            // @todo явно требуется какой-то рефакторинг
            $refs = $role['Rules'];
            foreach ($refs as $resource)
                $this->allow($role['id'], $resource['id']);
        }

        // доступ только для автора материала
        // if ($auth)
        //     $this->allow('member', 'forum', 'update', new MyAcl_Forum_Assertion($auth));
    }
}