<?php

class Form_Login extends Zend_Form
{
    public function __construct($login='')
    {
        $loginElement = new Zend_Form_Element_Text('login');
        $loginElement->setLabel('Логин')
                     ->setRequired()
                     ->setDecorators(App_Form_Decorators::inputDecorators())
                     ->setValue($login);

        $passwElement = new Zend_Form_Element_Password('password');
        $passwElement->setLabel('Пароль')
                     ->setRequired()
                     ->setDecorators(App_Form_Decorators::inputDecorators());

        $submit = new Zend_Form_Element_Submit('Войти');
        $submit->setDecorators(App_Form_Decorators::buttonDecorators());

        $this->addElements(array($loginElement, $passwElement, $submit));
        $this->setMethod('POST')
             ->setDecorators(App_Form_Decorators::formDecorators());
    }


}