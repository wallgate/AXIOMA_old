<?php

class IndexController extends App_Controller_Action
{
    public function indexAction()
    {
        $login = Zend_Auth::getInstance()->getIdentity()->login;
        $userTable = new Table_User();
        $user = $userTable->getUserByLogin($login);

        echo '<h3>' . $user->login . '</h3>';

        echo $user->birthdate instanceof Zend_Date ?
            '<b>дата рождения</b>: ' . $user->birthdate->get(Zend_Date::DATE_FULL) :
            '<b>дата рождения</b>: не указана';

        echo '<br/>';

        echo $user->hiredate instanceof Zend_Date ?
            '<b>дата трудоустройства</b>: ' . $user->hiredate->get(Zend_Date::DATE_FULL) :
            '<b>дата трудоустройства</b>: не указана';

        echo '<br/>';

        echo $user->retiredate instanceof Zend_Date ?
            '<b>дата увольнения</b>: ' . $user->retiredate->get(Zend_Date::DATE_FULL) :
            '<b>дата увольнения</b>: не указана';
    }

}