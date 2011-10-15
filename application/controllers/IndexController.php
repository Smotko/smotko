<?php

class IndexController extends Zend_Controller_Action
{

    public static function getDebatePaginator(){
        
        
    }
    public function indexAction()
    {
        $this->view->pnp = Model_Pnp::getPnpOnDate(date('Y-m-d'));
        
        $this->view->headScript()->appendFile('/scripts/index.js', $type = 'text/javascript');

        $paginator = Zend_Paginator::factory(Model_Debate::getDebate());
        $paginator->setCurrentPageNumber($this->_getParam('stran'));
        $paginator->setItemCountPerPage(8);

        $this->view->debate = $paginator;

        $this->view->debateForm = new Form_Comment();

        
        $paginator = Zend_Paginator::factory(Model_Comments::getComments());
        $paginator->setCurrentPageNumber($this->_getParam('stran_komentarjev'));
        $paginator->setDefaultItemCountPerPage(5);
        $this->view->comments = $paginator;
        $this->view->blogs = Model_Post::getLatestBlogs();

        //admin added PNPs:
        $pnps = Model_Pnp::getUnconfirmed();
        $this->view->unconfirmedPnps = count($pnps);
        
        if(!Zend_Auth::getInstance()->hasIdentity()){
            $this->view->user = new Form_Login();
            $this->view->user->setAction('/user/login');
        }

        $this->view->categories = Model_Categories::getAll();
        
        $this->view->users = Model_User::getActiveUsers();
        
        $pnp_form = new Form_Comment();
        $pnp_form->setPnp();
        $this->view->pnp_form = $pnp_form;
        
    }
    public function logoutAction()
    {
        setcookie('smotko_id', '', time() - 666, '/');
        if(Zend_Auth::getInstance()->hasIdentity()){
            Zend_Auth::getInstance()->clearIdentity();
            //Zend_Session::destroy();
        }
        
        $this->_helper->FlashMessenger(array('Uspešno sem te odjavil', 'success'));
        $this->_redirect('/');
    }
}

