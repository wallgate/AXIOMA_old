<?php

class LoginTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    protected $form;

    public function setUp()
    {
        $this->form = new Form_Login();
    }

    public function testLoginForm()
    {
        $elements = $this->form->getElements();
        $this->assertEquals(3, count($elements));
        $this->assertType('Zend_Form_Element_Text', $elements['login']);
        $this->assertType('Zend_Form_Element_Password', $elements['password']);
        $this->assertType('Zend_Form_Element_Submit', $elements['Войти']);

        $this->assertEquals('post', $this->form->getMethod());
    }
}