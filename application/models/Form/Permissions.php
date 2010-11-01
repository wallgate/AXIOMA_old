<?php

class Form_Permissions extends Zend_Form
{
    /**
     *
     * @param Table_Role $role
     */
    public function __construct($role)
    {
        $this->addPrefixPath('App_Form', 'App/Form');

        $name = new Zend_Form_Element_Text('name');
        $name->setLabel('Должность')
             ->setRequired();

        $this->addElements(array($name))
             ->setElementDecorators(App_Form_Decorators::inputDecorators())
             ->setDecorators(App_Form_Decorators::formDecorators());

        if ($role)
            $this->populate($role->getData());




        $myRole = Zend_Auth::getInstance()->getIdentity()->Role;

        $resources   = App_Acl_Resources::getResources();
        if ($role) $permissions = App_Acl_Roles::getPermettedResources($role);

        foreach (array_keys($resources) as $resource)
        {
            $elementName = 'permission'.ucfirst($resource);
            $$elementName = new Zend_Form_Element_Checkbox($resource);
            $$elementName->setDecorators(App_Form_Decorators::checkboxDecorators())
                         ->setLabel($resources[$resource]['label']);

            if (count($permissions))
                if (in_array($resource, $permissions))
                    $$elementName->setChecked(true);

            $this->addElement($$elementName)
                 ->setDecorators(App_Form_Decorators::formDecorators());
        }

        

        $submit = new Zend_Form_Element_Submit('Сохранить');
        $submit->setDecorators(App_Form_Decorators::buttonDecorators())
               ->setIgnore(true)
               ->setAttribs(array('id'=>'submit', 'class'=>'submit'));
        $this->addElement($submit);

    }
}