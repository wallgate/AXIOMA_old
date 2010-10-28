<?php

class Table_Role extends Table_Base_Role
{
    protected static $roles;

    /**
     * @return Table_Role
     */
    public static function getRoles()
    {
        $roles = Doctrine_Query::create()
                               ->from('Table_Role u')
                               ->leftJoin('u.Permissions')
                               ->fetchArray();

        foreach ($roles as $role)
        {
            $newperms = array();
            foreach ($role['Permissions'] as $permission)
                $newperms[] = $permission['resource'];
            $role['Permissions'] = $newperms;
            $newroles[$role['name']] = $role;
        }

        return self::$roles = $newroles;
    }

    public static function getRolesFromCache()
    {
        return self::$roles;
    }
}