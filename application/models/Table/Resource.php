<?php

class Table_Resource extends Table_Base_Resource
{
    public static function getAllResources()
    {
        $resources =  Doctrine_Query::create()
                                    ->from('Table_Resource')
                                    ->fetchArray();

        foreach ($resources as $resource)
        {
            $out[$resource['url']] = $resource;
            unset($out[$resource['url']]['url']);
        }

        return $out;
    }
}