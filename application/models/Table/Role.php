<?php

class Table_Role extends Table_Base_Role
{
    /**
     * @return Table_Role
     */
    public static function getRoles()
    {
        return Doctrine_Query::create()
                             ->from('Table_Role u')
                             ->leftJoin('u.Rules')
                             ->fetchArray();
    }
}