<?php

class Form_Permissions extends Zend_Form
{
    public function __construct()
    {
        $this->addPrefixPath('App_Form', 'App/Form');

        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Должность')
             ->setRequired();

        $this->addElements(array($name))
             ->setElementDecorators(App_Form_Decorators::inputDecorators())
             ->setDecorators(App_Form_Decorators::formDecorators());

        $submit = new Zend_Form_Element_Submit('Сохранить');
        $submit->setDecorators(App_Form_Decorators::buttonDecorators())
               ->setIgnore(true)
               ->setAttribs(array('id'=>'submit', 'class'=>'submit'));
        $this->addElement($submit);
    }
}