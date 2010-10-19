<?php

class App_Auth_AdapterTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    public function testAuth()
    {
        $adapter = new App_Auth_Adapter('user', 'root');
        $result = $adapter->authenticate();
        $this->assertEquals(Zend_Auth_Result::SUCCESS, $result->getCode());

        $adapter = new App_Auth_Adapter('user', 'wrongpassword');
        $result = $adapter->authenticate();
        $this->assertEquals(Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID, $result->getCode());

        $adapter = new App_Auth_Adapter('nouser', 'wrongpassword');
        $result = $adapter->authenticate();
        $this->assertEquals(Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND, $result->getCode());
    }
}