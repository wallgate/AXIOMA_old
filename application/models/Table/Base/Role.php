<?php

/**
 * Table_Base_Role
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property Doctrine_Collection $Users
 * @property Doctrine_Collection $Rules
 * @property Doctrine_Collection $Access
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Table_Base_Role extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('sys_roles');
        $this->hasColumn('name', 'string', 50, array(
             'type' => 'string',
             'length' => '50',
             ));

        $this->option('type', 'INNODB');
        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Table_User as Users', array(
             'local' => 'id',
             'foreign' => 'role'));

        $this->hasMany('Table_Rule as Rules', array(
             'refClass' => 'Table_Access',
             'local' => 'role_id',
             'foreign' => 'rule_id'));

        $this->hasMany('Table_Access as Access', array(
             'local' => 'id',
             'foreign' => 'role_id'));
    }
}