<?php

class IndexControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    public function setUp()
    {
        $adapter = new App_Auth_Adapter('user', 'root');
        Zend_Auth::getInstance()->authenticate($adapter);
    }

    public function testIndexAction()
    {
        $this->dispatch('/');

        $this->assertTrue(Zend_Auth::getInstance()->hasIdentity());
        $this->assertController('index');
        $this->assertAction('index');
        $this->assertResponseCode(200);
        // @todo добавить какой-нибудь assertQuery
    }
}