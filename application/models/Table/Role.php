<?php

class Table_Role extends Table_Base_Role
{
    protected static $roles;

    /**
     * @return Table_Role
     */
    public static function getRoles()
    {
        self::$roles = Doctrine_Query::create()
                                     ->from('Table_Role u')
                                     ->leftJoin('u.Rules')
                                     ->fetchArray();
        return self::$roles;
    }

    public static function getRolesFromCache()
    {
        return self::$roles;
    }
}