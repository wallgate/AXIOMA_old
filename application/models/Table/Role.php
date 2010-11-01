<?php

class Table_Role extends Table_Base_Role
{
    public function getRoles()
    {
        // @todo неплохо было бы, если б привелегии гидрировались массивом, а роли - объектом
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
        $connection = Doctrine_Manager::connection();

        try
        {
            $connection->beginTransaction();

            $role = new self();
            $role->name = $data['name'];

            // @todo сделать проверку: если ничего не меняли, не править привелегии
            $q = Doctrine_Query::create()
                       ->delete()
                       ->from('Table_Permission')
                       ->where('role=?', $role->id)
                       ->execute();

            foreach ($data as $field=>$value)
            {
                if ($value === '1')
                {
                    $permission = new Table_Permission();
                    $permission->role     = $role->id;
                    $permission->resource = $field;
                    $permission->save();
                }
            }

            $role->save();

            $connection->commit();
        }
        catch(Doctrine_Exception $e)
        {
            $conn->rollback();
        }
    }

    public function updateRole($role, $data)
    {
        $connection = Doctrine_Manager::connection();

        try
        {
            $connection->beginTransaction();

            $role->name = $data['name'];
            
            // @todo сделать проверку: если ничего не меняли, не править привелегии
            $connection->createQuery()
                       ->delete()
                       ->from('Table_Permission')
                       ->where('role=?', $role->id)
                       ->execute();

            foreach ($data as $field=>$value)
            {
                if ($value === '1')
                {
                    $permission = new Table_Permission();
                    $permission->role     = $role->id;
                    $permission->resource = $field;
                    $permission->save();
                }
            }

            $role->save();

            $connection->commit();
        }
        catch(Doctrine_Exception $e)
        {
            $conn->rollback();
        }
    }
}