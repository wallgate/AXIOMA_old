<?php

class ProfileController extends Zend_Controller_Action
{
    public function editAction()
    {
        $this->view->profileForm = new Form_Profile();

        if ($this->getRequest()->isPost())
        {
            if ($this->view->profileForm->isValid($this->getRequest()->getParams()))
            {
                //$this->
            }
        }
    }
}