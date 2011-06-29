<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    /*
     * @type: Zend_Acl
     */
    
    private $_acl;

    protected function _initAppAutoload()
    {
        $moduleLoad = new Zend_Application_Module_Autoloader(array(
           'namespace' => '',
           'basePath'   => APPLICATION_PATH
        ));
    }
    protected function _initDoctrine()
    {
        $this->getApplication()->getAutoloader()
             ->pushAutoloader(array('Doctrine', 'autoload'));
        spl_autoload_register(array('Doctrine', 'modelsAutoload'));

        
        $doctrineConfig = $this->getOption('doctrine');
        
        $manager = Doctrine_Manager::getInstance();
        
        $manager->setAttribute(Doctrine::ATTR_AUTO_ACCESSOR_OVERRIDE, true);

        $manager->setAttribute(Doctrine_Core::ATTR_USE_DQL_CALLBACKS, true);
        Doctrine::loadModels($doctrineConfig['models_path']);
        Doctrine::loadModels($doctrineConfig['models_path'].'/Base');

        $conn = Doctrine_Manager::connection($doctrineConfig['dsn'],'doctrine');
        $conn->setAttribute(Doctrine::ATTR_USE_NATIVE_ENUM, true);


        
        return $conn;
    }
    protected function _initUser(){


        $user = null;
        if(Zend_Auth::getInstance()->hasIdentity()){

            $user = Zend_Auth::getInstance()->getIdentity();

            $user = Model_User::getUserId($user->id)->toArray();
        }

        else if(isset($_COOKIE['smotko_id']))
        {
           //Zend_Debug::dump(unserialize($_COOKIE['smotko_id']));

            $user = Model_User::getUserId(unserialize($_COOKIE['smotko_id']));
            if($user){
                if($user->role == 'admin'){
                    $adapter = new Smotko_Auth_Adapter($user->user_name, $user->password);
                    $result = Zend_Auth::getInstance()->authenticate($adapter);
                    //Zend_Debug::dump($result);die;
                }
                $user = $user->toArray();
            }
            else{
                $user = null;
            }

        }
        
        //Zend_Debug::dump($user);die;
        //Zend_Debug::dump($user->toArray());die;
        Zend_Registry::set('User', $user);


    }
    protected function _initAcl()
    {
        //TODO: move to better location
        $acl = new Zend_Acl();
        $acl->addRole(new Zend_Acl_Role('guest'));
        $acl->addRole(new Zend_Acl_Role('member'), 'guest');
        $acl->addRole(new Zend_Acl_Role('admin'), 'member');

        $acl->addResource(new Zend_Acl_Resource('admin'));
        $acl->addResource(new Zend_Acl_Resource('register'));
        $acl->addResource(new Zend_acl_Resource('login'));

        
        $acl->allow('admin', 'admin');
        $acl->allow('guest', 'register');
        $acl->allow('guest', 'login');
        $acl->deny('admin', 'register');
        $this->_acl = $acl;
        Zend_Registry::set('acl', $acl);
    }
    protected function _initViewHelpers(){


        $this->bootstrap('layout');

        $layout = $this->getResource('layout');

        $view = $layout->getView();

        $view->setEscape(array('Bootstrap', 'escape'));
        $view->addHelperPath(APPLICATION_PATH . '/views/helpers');
        $view->addHelperPath(APPLICATION_PATH . '/modules/admin/views/helpers');

        $view->setEncoding('UTF-8');
        $view->doctype('XHTML1_STRICT');
        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8');
        $view->headTitle()->setSeparator(' - ');
        $view->headTitle('Smotko.si');
        $arr = include APPLICATION_PATH . '/configs/navigation.php';
        
        $role = 'guest';
        if(Zend_Auth::getInstance()->hasIdentity()){
            $user = Zend_Auth::getInstance()->getIdentity();
            $role = $user->role;
        }
        $view->navigation(new Zend_Navigation($arr))->setAcl($this->_acl)->setRole($role);
    }
    protected function _initLocale(){
        $locale = new Zend_Locale('sl_SI');
        Zend_Registry::set('Zend_Locale', $locale);

        $frontendOptions = array(
                        'lifetime' => 600, // 10 minutes
                        'automatic_serialization' => true
        );

        $backendOptions = array(
                        //'cache_dir' => APPLICATION_PATH . '/cache/'
                        );

        // getting a Zend_Cache_Core object
        $cache = Zend_Cache::factory('Core',
                                     'File',
                                      $frontendOptions,
                                      $backendOptions);
        Zend_Date::setOptions(array(//'format_type' => 'php',
                                    'cache' => $cache));
    }
    protected function _initRoute(){

        $this->bootstrap('frontController');

        $router = $this->frontController->getRouter();
        $router->addRoute('blog', new Zend_Controller_Router_Route('blog/:slug/*',
                                     array(
                                           'controller' => 'blog',
                                           'module' => 'default',
                                           'action' => 'index')));



    }
    
    public function escape($str){
        return htmlspecialchars($str);
    }

}

