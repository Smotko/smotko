<?php
// bootstrap.php

/**
 * Bootstrap Doctrine.php, register autoloader specify
 * configuration attributes and load models.
 */

require_once 'Doctrine.php';
spl_autoload_register(array('Doctrine', 'autoload'));
$manager = Doctrine_Manager::getInstance();

//$conn = Doctrine_Manager::connection('mysql://root:root@localhost/doc', $name);

/* PASSING PDO: allways connects, doctrine can't drop and create Databases:
$dsn = 'mysql:dbname=doctrine_test;host=127.0.0.1';
$user = 'root';
$password = 'root';

$dbh = new PDO($dsn, $user, $password);

$conn = Doctrine_Manager::connection($dbh);
 */

//lazy connection loading:
$conn = Doctrine_Manager::connection('mysql://root:root@localhost/doctrine_test', 'doctrine');


//Lazy load the models:
spl_autoload_register(array('Doctrine_Core', 'modelsAutoload')); //!!!
$manager->setAttribute(Doctrine_Core::ATTR_MODEL_LOADING, Doctrine_Core::MODEL_LOADING_CONSERVATIVE);
Doctrine_Core::loadModels('./../application/models');


$manager->setAttribute(Doctrine_Core::ATTR_AUTO_ACCESSOR_OVERRIDE, true);
$manager->setAttribute(Doctrine_Core::ATTR_AUTOLOAD_TABLE_CLASSES, true);
//aggressivly loads all models:

Doctrine_Core::dropDatabases();
Doctrine_Core::createDatabases();
Doctrine_Core::generateModelsFromYaml('./../application/configs/schema.yml', '../application/models/');
Doctrine_Core::createTablesFromModels('models');

