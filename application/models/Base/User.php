<?php

/**
 * Model_Base_User
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $password
 * @property string $user_name
 * @property string $user_url
 * @property string $user_email
 * @property string $user_ip
 * @property string $user_agent
 * @property string $role
 * @property integer $debateCount
 * @property integer $commentCount
 * @property Doctrine_Collection $Posts
 * @property Doctrine_Collection $Comments
 * @property Doctrine_Collection $Debate
 * @property Doctrine_Collection $Pnp
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Model_Base_User extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('user');
        $this->hasColumn('password', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('user_name', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('user_url', 'string', 500, array(
             'type' => 'string',
             'length' => '500',
             ));
        $this->hasColumn('user_email', 'string', 500, array(
             'type' => 'string',
             'length' => '500',
             ));
        $this->hasColumn('user_ip', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('user_agent', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('role', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('debateCount', 'integer', null, array(
             'type' => 'integer',
             'default' => 0,
             ));
        $this->hasColumn('commentCount', 'integer', null, array(
             'type' => 'integer',
             'default' => 0,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('Model_Post as Posts', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $this->hasMany('Model_Comments as Comments', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $this->hasMany('Model_Debate as Debate', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $this->hasMany('Model_Pnp as Pnp', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $versionable0 = new Doctrine_Template_Versionable(array(
             'versionColumn' => 'version',
             'className' => '%CLASS%Version',
             'auditLog' => true,
             ));
        $this->actAs($versionable0);
    }
}