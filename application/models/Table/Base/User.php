<?php

/**
 * Table_Base_User
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $login
 * @property string $password
 * @property integer $role
 * @property Table_Role $Role
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Table_Base_User extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('sys_users');
        $this->hasColumn('login', 'string', 20, array(
             'type' => 'string',
             'length' => '20',
             ));
        $this->hasColumn('password', 'string', 200, array(
             'type' => 'string',
             'length' => '200',
             ));
        $this->hasColumn('role', 'integer', null, array(
             'type' => 'integer',
             'default' => 1,
             ));

        $this->option('type', 'INNODB');
        $this->option('collate', 'utf8_general_ci');
        $this->option('charset', 'utf8');
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Table_Role as Role', array(
             'local' => 'role',
             'foreign' => 'id'));
    }
}