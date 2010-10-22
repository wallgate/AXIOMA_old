<?php

class Form_UserAdvanced extends Zend_Form
{
    public function __construct()
    {
        $login = new Zend_Form_Element_Text('login');
        $login->setLabel('Логин')
              ->setDescription('от 5 до 20 символов')
              ->setRequired(true)
              ->addValidator('StringLength', false, array(5,30));

        $password = new Zend_Form_Element_Password('password');
        $password->setLabel('Пароль')
                 ->setDescription('от 6 до 20 символов')
                 ->addValidator('StringLength', false, array(6,20))
                 ->setRequired(true);

        $confirmation = new Zend_Form_Element_Password('confirmation');
        $confirmation->setLabel('Подтверждение пароля')
                     ->addValidator('StringLength', false, array(6,20))
                     ->setRequired(true);

        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Email')
              ->addValidator('StringLength', false, array(5,30))
              ->addValidator(new Zend_Validate_EmailAddress())
              ->setRequired(true);


        


        $firstname = new Zend_Form_Element_Text('firstname');
        $firstname->setLabel('Имя')
                  ->addValidator('StringLength', false, array(2,50))
                  ->addFilter(new Zend_Filter_StringTrim())
                  ->setRequired(true);

        $midname = new Zend_Form_Element_Text('midname');
        $midname->setLabel('Отчество')
                ->addValidator('StringLength', false, array(2,50))
                ->addFilter(new Zend_Filter_StringTrim());

        $lastname = new Zend_Form_Element_Text('lastname');
        $lastname->setLabel('Фамилия')
                 ->addValidator('StringLength', false, array(2,50))
                 ->addFilter(new Zend_Filter_StringTrim())
                 ->setRequired(true);

        $birthdate = new Zend_Form_Element_Text('birthdate');
        $birthdate->setLabel('Дата рождения')
                  ->setOptions(array('class'=>'datePicker'))
                  ->addValidator('StringLength', false, array(3,30));


        $this->addPrefixPath('App_Form', 'App/Form');

        $this->setDecorators(array('FormElements', 'Form'))
             ->setAttrib('class', 'contentForm')
             ->addElements(array(
                    $firstname,
                    $midname,
                    $lastname,
                    $email,
                    $login,
                    $password,
                    $confirmation,
                    $birthdate
                ));

        $this->setElementDecorators(App_Form_Decorators::inputDecorators())
             ->defineDisplayGroups();

        $submit = new Zend_Form_Element_Submit('Сохранить');
        $submit->setDecorators(array('ViewHelper'))
               ->setAttribs(array('id'=>'submit', 'class'=>'submit'));

        $this->addElement($submit);
    }


    /**
     * Разбивает добавленные на форму элементы на группы
     */
    protected function defineDisplayGroups()
    {
        $this->addDisplayGroup(array(
            'login',
            'password',
            'confirmation',
            'email'
        ), 'basic', array('legend' => 'Учётная запись'));
        
        $this->addDisplayGroup(array(
            'firstname',
            'midname',
            'lastname',
            'birthdate'
        ), 'full', array('legend' => 'Подробно'));

        $this->addDisplayGroup(array(
            'birthdate'
        ), 'avatar', array('legend' => 'Фото'));


        
        $this->setDisplayGroupDecorators(array(
            'FormElements',
            array('HtmlTag', array('tag'=>'table', 'class'=>'dispayGroup'))
        ));
    }

    /**
     * Возвращает массив строк, состоящий из названий вкладок формы
     * @return array
     */
    public function getDisplayGroupNames()
    {
        $displayGroups = $this->getDisplayGroups();
        
        foreach ($displayGroups as $displayGroup)
            $headlines[$displayGroup->getName()] = array('legend' => $displayGroup->getLegend());

        return $headlines;
    }
}