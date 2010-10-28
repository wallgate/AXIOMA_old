<?php

class App_Acl_Roles
{
    private static $roles;

    public static function initRoles()
    {
        $roleTable = new Table_Role();
        self::$roles = $roleTable->getRoles();
    }

    public static function getRoles()
    {
        return self::$roles;
    }

    public static function getRole($name)
    {
        return self::$roles[$name];
    }
}