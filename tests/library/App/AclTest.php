<?php

class App_AclTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    protected $acl;

    public function setUp()
    {
        $this->acl = new App_Acl();
    }

    public function testResources()
    {
        $this->assertTrue($this->acl->has(App_Acl_Resources::PUBLIC_PAGE));
        $this->assertTrue($this->acl->has(App_Acl_Resources::PRIVATE_PAGE));
    }

    public function testGuestAccess()
    {
        $guest = App_Acl_Roles::USER;
        $this->assertTrue($this->acl->hasRole($guest));
        $this->assertTrue($this->acl->isAllowed($guest, App_Acl_Resources::PUBLIC_PAGE));
        $this->assertFalse($this->acl->isAllowed($guest, App_Acl_Resources::PRIVATE_PAGE));
    }

    public function testWebmasterAccess()
    {
        $webmaster = App_Acl_Roles::WEBMASTER;
        $this->assertTrue($this->acl->hasRole($webmaster));
        $this->assertTrue($this->acl->isAllowed($webmaster, App_Acl_Resources::PUBLIC_PAGE));
        $this->assertTrue($this->acl->isAllowed($webmaster, App_Acl_Resources::PRIVATE_PAGE));
    }
}