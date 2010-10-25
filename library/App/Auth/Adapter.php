<?php

class App_Auth_Adapter implements Zend_Auth_Adapter_Interface
{
    const USER_NOT_FOUND_MESSAGE = 'Пользователь с таким именем не зарегистрирован';
    const WRONG_PASSWORD_MESSAGE = 'Вы ввели неверный пароль';

    /**
     * @var string
     */
    protected $login;
    /**
     * @var string
     */
    protected $password;


    public function __construct($login, $password)
    {
        $this->login    = $login;
        $this->password = $password;
    }

    /**
     * Попытка авторизации
     * @throws Zend_Auth_Adapter_Exception если авторизация не увечалась успехов
     * @return Zend_Auth_Result
     */
    public function authenticate()
    {
        try
        {
            $user = Table_User::authenticate($this->login, $this->password);
            $user->last_login_at = date('Y-m-d H:i:s');
            $user->save();
            return new Zend_Auth_Result(Zend_Auth_Result::SUCCESS, $user);
        }
        catch (Exception $e)
        {
            switch ($e->getMessage())
            {
                case Table_User::ERROR_USER_NOT_FOUND:
                    $code    = Zend_Auth_Result::FAILURE_IDENTITY_NOT_FOUND;
                    $message = self::USER_NOT_FOUND_MESSAGE;
                    break;
                case Table_User::ERROR_WRONG_PASSWORD:
                    $code    = Zend_Auth_Result::FAILURE_CREDENTIAL_INVALID;
                    $message = self::WRONG_PASSWORD_MESSAGE;
                    break;
            }
            return new Zend_Auth_Result($code, NULL, array($message));
        }
    }
}