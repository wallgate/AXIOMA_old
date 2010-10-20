<?php

class App_Acl extends Zend_Acl
{
    public function __construct($auth = null)
    {
        $this->add(new Zend_Acl_Resource(App_Acl_Resources::PUBLIC_PAGE));
        $this->add(new Zend_Acl_Resource(App_Acl_Resources::PRIVATE_PAGE));

        $this->addRole(new Zend_Acl_Role(App_Acl_Roles::USER));
        $this->addRole(new Zend_Acl_Role(App_Acl_Roles::WEBMASTER), App_Acl_Roles::USER);

        $this->deny();
        $this->allow(App_Acl_Roles::USER, App_Acl_Resources::PUBLIC_PAGE);
        $this->allow(App_Acl_Roles::WEBMASTER, App_Acl_Resources::PRIVATE_PAGE);

        // доступ только для автора материала
        // if ($auth)
        //     $this->allow('member', 'forum', 'update', new MyAcl_Forum_Assertion($auth));
    }
}