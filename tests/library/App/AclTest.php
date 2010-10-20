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
        $this->assertTrue($this->acl->has(1));
        $this->assertTrue($this->acl->has(2));
    }

    public function testGuestAccess()
    {
        $user = 1;
        $this->assertTrue($this->acl->hasRole($user));
        $this->assertTrue($this->acl->isAllowed($user, 1));
        $this->assertFalse($this->acl->isAllowed($user, 2));
    }

    public function testWebmasterAccess()
    {
        $webmaster = 2;
        $this->assertTrue($this->acl->hasRole($webmaster));
        $this->assertTrue($this->acl->isAllowed($webmaster, 1));
        $this->assertTrue($this->acl->isAllowed($webmaster, 2));
    }
}