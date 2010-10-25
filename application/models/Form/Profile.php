<?php

class Form_Profile extends Zend_Form
{
    public function __construct()
    {
        // учётная запись
        $login = new Zend_Form_Element_Text('login');
        $login->setLabel('Логин')
              ->setDescription('от 5 до 20 символов')
              ->addFilter(new Zend_Filter_StringTrim())
              ->addValidator(new Zend_Validate_StringLength(5,20))
              ->addValidator(new App_Validate_LoginUnique(array(
                  'table'   => 'Table_User',
                  'field'   => 'login',
                  'exclude' => array($user['login'])
              )))
              ->setRequired();

        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Сменить пароль')
                 ->setDescription('от 6 до 20 символов')
                 ->addFilter(new Zend_Filter_StringTrim())
                 ->addValidator(new Zend_Validate_StringLength(6,20));

        $confirmation = new Zend_Form_Element_Password('confirmation');
        $confirmation->setLabel('Подтверждение пароля')
                     ->addFilter(new Zend_Filter_StringTrim())
                     ->addValidator(new Zend_Validate_Identical('password'))
                     ->getIgnore(true);

        $submit = new Zend_Form_Element_Submit('Сохранить');
        $submit->setIgnore(true)
               ->setAttribs(array('id'=>'submit', 'class'=>'submit'));

        $this->addPrefixPath('App_Form', 'App/Form');

        $this->setDecorators(App_Form_Decorators::formDecorators())
             ->setAttrib('class', 'contentForm')
             ->addElements(array($login, $password, $confirmation, $submit))
             ->setElementDecorators(App_Form_Decorators::inputDecorators())
             ->setAttrib('id', 'formProfile')
             ->populate(Zend_Auth::getInstance()->getIdentity()->toArray());

        $submit->setDecorators(App_Form_Decorators::buttonDecorators());
    }
}