<?php

class Table_User extends Table_Base_User
{
    const ERROR_USER_NOT_FOUND = 1;
    const ERROR_WRONG_PASSWORD = 2;

    const STATUS_ACTIVE  = 'active';
    const STATUS_RETIRED = 'retired';
    const STATUS_TRIAL   = 'trial';

    
    /**
     * Ищет пользователя по логину и паролю.
     * Выбрасывает исключение, если пользователь не найден или пароль не совпадает.
     * @param string $login
     * @param string $password
     * @throws Exception
     * @return Table_User
     */
    public static function authenticate($login, $password)
    {
        $user = Doctrine_Query::create()
                              ->select('password', 'firstname', 'role', 'salt')
                              ->from('Table_User')
                              ->where('login=?', $login)
                              ->limit(1)
                              ->fetchOne();

        if ($user)
        {
            if ($user->password == md5( md5($password).$user->salt ))
                return $user;

            throw new Exception(self::ERROR_WRONG_PASSWORD);
        }
        throw new Exception(self::ERROR_USER_NOT_FOUND);
    }


    /**
     * Формирует список пользователей, выбирая из по статусу (работающие,
     * бывшие сотрудники, на испытательном сроке)
     *
     * @param string $status статус искомых пользователей
     * @return array
     */
    public function getUsers($status = null)
    {
        $users = Doctrine_Query::create()
                               ->select('firstname, lastname, login, last_login_at, r.name')
                               ->from('Table_User u, u.Role r');

        switch ($status)
        {
            case self::STATUS_ACTIVE:
                $users = $users->where('u.hiredate IS NOT NULL')
                               ->addWhere('u.retiredate IS NULL');
                break;
            case self::STATUS_RETIRED:
                $users = $users->where('u.retiredate IS NOT NULL');
                break;
            case self::STATUS_TRIAL:
                $users = $users->where('u.hiredate IS NULL');
                break;
        }

        return $users->orderBy('lastname')
                     ->fetchArray();
    }

    public function getUserByLogin($login)
    {
        $user =  Doctrine_Query::create()
                               ->from('Table_User')
                               ->where('login=?', $login)
                               ->limit(1)
                               ->fetchOne();
        return $user;
    }


    public function insertUser($values)
    {
        foreach ($values as $key=>$value)
            if (empty($value)) unset($values[$key]);

        unset($values['confirmation']);

        if (!empty($values['birthdate']))
            $values['birthdate'] = $this->stringToDate($values['birthdate']);
        if (!empty($values['hiredate']))
            $values['hiredate'] = $this->stringToDate($values['hiredate']);
        if (!empty($values['retiredate']))
            $values['retiredate'] = $this->stringToDate($values['retiredate']);

        $user = new self;
        $user->setArray($values);
        $user->salt = time();
        $user->password = md5( md5($this->password) . $this->salt );

        $user->save();
    }

    public function  preInsert($event)
    {
        $this->salt = time();
        $this->password = md5( md5($this->password) . $this->salt );
    }




    public function updateUser($login, $values)
    {
        foreach ($values as $key=>$value)
            if (empty($value)) unset($values[$key]);

        unset($values['confirmation']);

        if (!empty($values['birthdate']))
            $values['birthdate'] = $this->stringToDate($values['birthdate']);
        if (!empty($values['hiredate']))
            $values['hiredate'] = $this->stringToDate($values['hiredate']);
        if (!empty($values['retiredate']))
            $values['retiredate'] = $this->stringToDate($values['retiredate']);

        // а точно ли здесь необходим запрос?
        $user = $this->getUserByLogin($login);
        $user->setArray($values);

        if ($values['password'])
        {
            $user->salt = time();
            $user->password = md5( md5($this->password) . $this->salt );
        }

        $user->save();
    }


    public static function deleteUser($login)
    {
        Doctrine_Query::create()->delete('Table_User')
                                ->where('login=?', $login)
                                ->limit(1)
                                ->execute();
    }




    
    // @todo перенести в плагин
    private function stringToDate($date)
    {
        $tempDate = array_reverse(explode('.', $date));
        return implode('-', $tempDate);
    }
}