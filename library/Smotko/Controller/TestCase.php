<?php
/**
 * Base Controller Test Class
 * 
 * All controller test should extend this
 */
abstract class Smotko_Controller_TestCase extends Zend_Test_PHPUnit_ControllerTestCase {

    public $application;

    public function setUp() {

        $this->application = new Zend_Application(APPLICATION_ENV, APPLICATION_PATH . '/configs/application.ini');
        $this->bootstrap = array($this, 'appBootstrap');
        parent::setUp();
    }

    public function appBootstrap()
    {
        $this->application->bootstrap();
    }

}