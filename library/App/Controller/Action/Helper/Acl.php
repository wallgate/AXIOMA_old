<?php

class App_Controller_Action_Helper_Acl extends Zend_Controller_Action_Helper_Redirector
{
    public function denyAccess()
    {
        $this->gotoUrlAndExit('/error/restricted');
    }
}