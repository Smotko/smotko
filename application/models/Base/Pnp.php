<?php

/**
 * Model_Base_Pnp
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $user_id
 * @property string $content
 * @property date $date
 * @property boolean $markdown
 * @property Model_User $User
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class Model_Base_Pnp extends Doctrine_Record
{
    public function setTableDefinition()
    {
        $this->setTableName('pnp');
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('content', 'string', 255, array(
             'type' => 'string',
             'length' => '255',
             ));
        $this->hasColumn('date', 'date', null, array(
             'type' => 'date',
             ));
        $this->hasColumn('markdown', 'boolean', null, array(
             'type' => 'boolean',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Model_User as User', array(
             'local' => 'user_id',
             'foreign' => 'id'));
    }
}