<?php

class DebateController extends Zend_Controller_Action
{

    public function init()
    {
        $this->msg = $this->_helper->getHelper('FlashMessenger');
        $this->view->headTitle('Debate', 'PREPEND');
    }

    public function indexAction()
    {
        $paginator = Zend_Paginator::factory(Model_Debate::getDebate());
        $paginator->setCurrentPageNumber($this->_getParam('stran'));
        $paginator->setDefaultItemCountPerPage(30);
        $this->view->debate = $paginator;

        $this->view->debateForm = new Form_Comment();
        $this->view->users = Model_User::getActiveUsers();
    }

    public function addAction()
    {
        $debate = new Form_Comment();
        if($this->getRequest()->isPost()){

            if($debate->isValid($this->getRequest()->getParams())){

                if($this->getRequest()->getParam('contentlongr') != ""){
                
                    return;
                }
                $editing = $this->getRequest()->getParam('id') != "";
                $debata = new Model_Debate();
                if($editing){
                    $debata->assignIdentifier($this->getRequest()->getParam('id'));
                    $this->msg->addMessage(array('Tvoj komentar je bil popravljen.', 'success'));
                }
                
                $debata->fromArray($debate->getValues());
                
                if($debata->user_url == null)
                        $debata->user_url = 'http://';
                if(!$editing){
                    
                    $debata->User = Model_User::setUser($debate->getValues());
                    $debata->User->debateCount++;
                    $debata->User->save();
                    $this->msg->addMessage(array('Tvoj komentar je bil dodan.', 'success'));
                }
                //Zend_Debug::dump($debata->User->toArray());die;
               
                $debata->save();
                
                $this->_redirect('/');
            }
            else{
                $debate->populate($this->getRequest()->getParams());
                $this->view->form = $debate;
                
            }

        }

    }
    public function editAction()
    {
        if(!$this->_hasParam('id')){
            $this->_helper->FlashMessenger(array('Prišlo je do napake.', 'error'));
            $this->_redirect('/');
            return;
        }

        $user = Zend_Registry::get('User');

        $debate = Model_Debate::getDebateById($this->_getParam('id'));
        if($user['id'] != $debate->User->id && $user['role'] != 'admin'){
            $this->_helper->FlashMessenger(array('Urejaš lahko samo svoje komentarje.', 'error'));
            $this->_redirect('/');
            return;
        }

        $form = new Form_Comment();
        $form->setAction('/debate/add');
        $arr = $debate->toArray();
        
        $arr['user_url'] = $arr['User']['user_url'];
        if($arr['user_url'] == 'http://')
            $arr['user_url'] = '';
        $form->populate($arr);

        $this->view->form = $form;
    }
    public function deleteAction()
    {
        Model_Comments::deleteDebate($this->_getParam('id'));
        $this->_helper->FlashMessenger(array('Tvoj komentar je bil izbrisan', 'success'));
        $this->_redirect('/');
    }
    public function userAction()
    {
        if(!$this->_hasParam('id')){
            $this->_redirect('/debate');
        }

        $paginator = Zend_Paginator::factory(Model_Debate::getDebateByUser($this->_getParam('id')));
        $paginator->setCurrentPageNumber($this->_getParam('stran'));
        $paginator->setDefaultItemCountPerPage(30);
        $this->view->debate = $paginator;
        $this->view->users = Model_User::getActiveUsers();

    }




}



