<?php

class Table_User extends Table_Base_User
{
    const ERROR_USER_NOT_FOUND = 1;
    const ERROR_WRONG_PASSWORD = 2;

    /**
     * Ищет пользователя по логину и паролю.
     * Выбрасывает исключение, если пользователь не найден или пароль не совпадает
     * @param string $login
     * @param string $password
     * @throws Exception
     * @return Table_User
     */
    public static function authenticate($login, $password)
    {
        $user = Doctrine_Query::create()
                              ->from('Table_User')
                              ->where('login=?', $login)
                              ->limit(1)
                              ->fetchOne();

        if ($user)
        {
            if ($user->password == $password)
                return $user;

            throw new Exception(self::ERROR_WRONG_PASSWORD);
        }
        throw new Exception(self::ERROR_USER_NOT_FOUND);
    }
}