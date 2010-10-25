<?php

class App_Acl extends Zend_Acl
{
    public function __construct($auth = null)
    {
        $this->deny();

        $resources = Table_Rule::getRules();
        foreach ($resources as $resource)
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
/*
        foreach ($roles as $role)
        {
            echo $role['name'].' : ';
            foreach ($role['Rules'] as $rule)
            {
                if ($this->isAllowed($role['id'], $rule['id']))
                echo $rule['name'].' ';
            }
            echo '<br/>';
        }
*/
        // доступ только для автора материала
        // if ($auth)
        //     $this->allow('member', 'forum', 'update', new MyAcl_Forum_Assertion($auth));
    }
}