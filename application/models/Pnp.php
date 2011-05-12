<?php

/**
 * Model_Pnp
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Model_Pnp extends Model_Base_Pnp
{

    public static function getPnpOnDate($date)
    {


        $q = Doctrine_Query::create()
                ->select()
                ->from('Model_Pnp p')
                ->leftJoin('p.User u')
                ->where('date = ?', $date)
                ->fetchOne();

        return $q;
    }
    public static function findById($id)
    {

        return Doctrine_Query::create()
                    ->select()
                    ->from('Model_Pnp p')
                    ->leftJoin('p.User u')
                    ->where('id = ?', $id)
                    ->fetchOne();
    }
    public static function getAll()
    {

        return Doctrine_Query::create()
                    ->select()
                    ->from('Model_Pnp p')
                    ->leftJoin('p.User u')
                    ->orderBy('date DESC')
                    ->where('date <= ?', array(date('Y-m-d')))
                    ->fetchArray();

    }
    public static function getUnconfirmed()
    {
        return Doctrine_Query::create()
                    ->select()
                    ->from('Model_Pnp p')
                    ->leftJoin('p.User u')
                    ->orderBy('date DESC')
                    ->where('date IS NULL')
                    ->fetchArray();
    }

}