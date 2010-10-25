<?php

class LoginControllerTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    public function setUp()
    {
        Zend_Controller_Front::getInstance()->addControllerDirectory(APPLICATION_PATH.'/controllers');
    }

    public function testIndexAction()
    {
        $this->dispatch('/login');
        $this->assertTrue(true);
    }
}