<?php

class Form_UserAdvanced extends Zend_Form
{
    public function __construct($user)
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
        $password->setLabel('Пароль')
                 ->setDescription('от 6 до 20 символов')
                 ->addFilter(new Zend_Filter_StringTrim())
                 ->addValidator(new Zend_Validate_StringLength(6,20));

        $confirmation = new Zend_Form_Element_Password('confirmation');
        $confirmation->setLabel('Подтверждение пароля')
                     ->addFilter(new Zend_Filter_StringTrim())
                     ->addValidator(new Zend_Validate_Identical('password'))
                     ->getIgnore(true);

        if (!$user)
        {
            $password->setRequired();
            $confirmation->setRequired();
        }

        // служебные данные
        $roles = Table_Role::getRolesFromCache();
        foreach ($roles as $role)
            $roleOptions[$role['id']] = $role['name'];
        $role = new Zend_Form_Element_Select('role');
        $role->setLabel('Должность')
             ->setMultiOptions($roleOptions);

        $email = new Zend_Form_Element_Text('email');
        $email->setLabel('Служебный e-mail')
              ->addValidator(new App_Validate_EmailAddress());

        $hiredate = new Zend_Form_Element_Text('hiredate');
        $hiredate->setLabel('Дата приёма на работу')
                 ->setOptions(array('class'=>'datePicker'));

        $retiredate = new Zend_Form_Element_Text('retiredate');
        $retiredate->setLabel('Дата увольнения')
                   ->setOptions(array('class'=>'datePicker'));

        $summary = new Zend_Form_Element_File('summary');
        $summary->setLabel('Файл резюме')
                ->setDestination(ROOT.'/public/uploads/summary');

        // личные данные
        $firstname = new Zend_Form_Element_Text('firstname');
        $firstname->setLabel('Имя')
                  ->addFilter(new Zend_Filter_StringTrim())
                  ->setRequired();

        $midname = new Zend_Form_Element_Text('midname');
        $midname->setLabel('Отчество')
                ->addFilter(new Zend_Filter_StringTrim())
                ->setRequired();

        $lastname = new Zend_Form_Element_Text('lastname');
        $lastname->setLabel('Фамилия')
                 ->addFilter(new Zend_Filter_StringTrim())
                 ->setRequired();

        $birthdate = new Zend_Form_Element_Text('birthdate');
        $birthdate->setLabel('Дата рождения')
                  ->setOptions(array('class'=>'datePicker'));

        $cellphone = new Zend_Form_Element_Text('cellphone');
        $cellphone->setLabel('Сотовый телефон')
                  ->setOptions(array('class'=>'cellphone'));

        $homephone = new Zend_Form_Element_Text('homephone');
        $homephone->setLabel('Домашний телефон')
                  ->setOptions(array('class'=>'homephone'));

        $addressreg = new Zend_Form_Element_Text('addressreg');
        $addressreg->setLabel('Адрес прописки');

        $addressfact = new Zend_Form_Element_Text('addressfact');
        $addressfact->setLabel('Адрес проживания');

        $marital = new Zend_Form_Element_Text('marital');
        $marital->setLabel('Семейное положение');

        $children = new Zend_Form_Element_Textarea('children');
        $children->setLabel('Дети')
                 ->setAttrib('rows', 4);



        $this->addPrefixPath('App_Form', 'App/Form');

        $this->setEnctype('multipart/form-data')
             ->setDecorators(array('FormElements', 'Form'))
             ->setAttrib('class', 'contentForm')
             ->addElements(array(
                    $login, $password, $confirmation,
                    $role, $email, $hiredate, $retiredate, $summary,
                    $firstname, $midname, $lastname, $birthdate,
                    $cellphone, $homephone, $addressreg, $addressfact,
                    $marital, $children
                ));

        $this->setElementDecorators(App_Form_Decorators::inputDecorators())
             ->setAttrib('id', 'formUserAdvanced')
             ->defineDisplayGroups();

        if ($user)
        {
            if ($user instanceof Table_User) $user = $user->toArray();

            if (is_array($user))
            {
                if (!empty($user['birthdate']))
                    $user['birthdate'] = $this->dateToString($user['birthdate']);
                if (!empty($user['hiredate']))
                    $user['hiredate'] = $this->dateToString($user['hiredate']);
                if (!empty($user['retiredate']))
                    $user['retiredate'] = $this->dateToString($user['retiredate']);

                $this->populate($user);
            }
        }

        $summary->setDecorators(App_Form_Decorators::fileDecorators());

        $submit = new Zend_Form_Element_Submit('Сохранить');
        $submit->setDecorators(array('ViewHelper'))
               ->setIgnore(true)
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
            'password', 'confirmation',
        ), 'basic', array('legend' => 'Учётная запись'));
        
        $this->addDisplayGroup(array(
            'role',
            'email',
            'hiredate', 'retiredate',
            'summary'
        ), 'job', array('legend' => 'Служебные данные'));

        $this->addDisplayGroup(array(
            'firstname', 'midname', 'lastname',
            'birthdate',
            'cellphone', 'homephone', 'addressreg', 'addressfact',
            'marital', 'children'
        ), 'private', array('legend' => 'Личные данные'));

        
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





    
    private function dateToString($date)
    {
        $tempDate = array_reverse(explode('-', $date));
        return implode('.', $tempDate);
    }
}