<?php

class Table_Rule extends Table_Base_Rule
{
    public static function getRules()
    {
        return Doctrine_Query::create()
                             ->from('Table_Rule')
                             ->fetchArray();
    }
}