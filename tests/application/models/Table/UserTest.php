<?php

class UserTest extends Zend_Test_PHPUnit_ControllerTestCase
{
    public function testCreateUser()
    {
        $user = new Table_User();
        $user->login = 'seconduser';
        $user->password = 'somepass';
        $user->save();

        $this->assertEquals(3, $user->id);
    }


    /**
     * @dataProvider credentialsProvider
     *
     * Тест аутентификации, когда переданы верные данные
     * @param string $login
     * @param string $password
     */
    public function testAuthenticationSuccess($login, $password)
    {
        $user = Table_User::authenticate($login, $password);
        $this->assertTrue($user instanceof Table_User);
    }

    public function credentialsProvider()
    {
        return array(
            array('user', 'root'),
            array('seconduser', 'somepass'),
        );
    }

    /**
     * Тест аутентификации с неверным логином
     */
    public function testAuthenticationUserNotFound()
    {
        try
        {
            Table_User::authenticate('nouser', 'nopassword');
        }
        catch (Exception $e)
        {
            if ($e->getMessage()==Table_User::ERROR_USER_NOT_FOUND) return;
        }
        $this->fail('Не тот ответ при аутентификации с неверным логином');
    }

    /**
     * Тест аутентификации с неверным паролем
     */
    public function testAuthenticationWrongPassword()
    {
        try
        {
            Table_User::authenticate('user', 'wrongpassword');
        }
        catch (Exception $e)
        {
            if ($e->getMessage()==Table_User::ERROR_WRONG_PASSWORD) return;
        }
        $this->fail('Не тот ответ при аутентификации с неверным паролем');
    }
}