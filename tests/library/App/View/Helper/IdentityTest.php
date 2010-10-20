<?php

class App_View_Helper_IdentityTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    public function testReturnIdentity()
    {
        $helper = new App_View_Helper_Identity();

        Zend_Auth::getInstance()->authenticate(new App_Auth_Adapter('user', 'root'));
        $this->assertType('string', $helper->identity());
        Zend_Auth::getInstance()->clearIdentity();

        Zend_Auth::getInstance()->authenticate(new App_Auth_Adapter('nouser', 'wrongpassword'));
        $this->assertSame(false, $helper->identity());
    }
}