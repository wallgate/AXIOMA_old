<?php

class App_Controller_ActionTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    public function setUp()
    {
        Zend_Controller_Front::getInstance()->setControllerDirectory(APPLICATION_PATH.'/controllers');
    }

    public function testNoIdentityRedirect()
    {
        $this->dispatch('/');
        $this->assertFalse(Zend_Auth::getInstance()->hasIdentity());
        $this->assertResponseCode(302);
    }

    public function testUserHasAccess()
    {
        $adapter = new App_Auth_Adapter('admin', 'root');
        Zend_Auth::getInstance()->authenticate($adapter);
        
        $this->dispatch('/admin');
        $this->assertResponseCode(200);
    }


    public function testAccessRestricted()
    {
        $adapter = new App_Auth_Adapter('user', 'root');
        Zend_Auth::getInstance()->authenticate($adapter);

        $this->dispatch('/admin');
        $this->assertController('error');
        $this->assertResponseCode(500);
    }

}