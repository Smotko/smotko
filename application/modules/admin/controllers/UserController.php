<?php

class Admin_UserController extends Zend_Controller_Action
{

    protected $storage;

    public function init()
    {
        $this->storage = Zend_Auth::getInstance()->getStorage();
    }

    public function indexAction()
    {
        
        $this->storage->read();
    }

    public function loginAction()
    {
        $form = new Form_Login();

        $this->view->form = $form;
        if($this->getRequest()->isPost()){

            $formData =  $this->getRequest()->getPost();
            if($form->isValid($formData)){
                if($this->getRequest()->getParam('remember') == "1")
                    Zend_Session::rememberMe();

                $adapter = new Smotko_Auth_Adapter($this->_getParam('user_name'), md5($this->_getParam('password')));
                $result = Zend_Auth::getInstance()->authenticate($adapter);
                
                if (Zend_Auth::getInstance()->hasIdentity())
                    $this->_redirect('/admin');

                
            }
            $this->getResponse()->setHttpResponseCode(401);     
        }        
    }

    public function logoutAction()
    {
        setcookie('smotko_id', '', time() - 666, '/');
        Zend_Auth::getInstance()->clearIdentity();
        $this->_redirect('/');
    }
}





