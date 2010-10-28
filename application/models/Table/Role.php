<?php

class Table_Role extends Table_Base_Role
{
    public function getRoles()
    {
        $roles = Doctrine_Query::create()
                               ->from('Table_Role u')
                               ->leftJoin('u.Permissions')
                               ->orderBy('u.name')
                               ->execute(array(), Doctrine::HYDRATE_RECORD);

        $records = $roles->getData();
        foreach ($records as $record)
            $out[$record->name] = $record;

        return $out;
    }



    public function insertRole($data)
    {
        $role = new self();
        $role->name = $data['name'];
        $role->save();
    }

    public function updateRole($role, $data)
    {
        $role->name = $data['name'];
        $role->save();
    }
}