<?php

class CommentsController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->headTitle('Komentar', 'PREPEND');
    }

    public function indexAction()
    {
        // action body
    }

    public function addAction()
    {
        if($this->getRequest()->isPost()){
                    
            $form = new Form_Comment();
            if($form->isValid($this->getRequest()->getParams())){
                if($this->getRequest()->getParam('contentlongr') != ""){
                
                    return;
                }
                $comment = new Model_Comments();
                if($this->getRequest()->getParam('id') != ""){
                    $comment->assignIdentifier($this->getRequest()->getParam('id'));
                    $this->_helper->FlashMessenger(array('Tvoj komentar je bil popravljen.', 'success'));
                }
                $comment->fromArray($form->getValues());
                if($comment->user_url == null)
                        $comment->user_url = 'http://';

                if($this->getRequest()->getParam('id') == ""){                    
                    $comment->User = Model_User::setUser($form->getValues());
                    $comment->User->commentCount++;
                    $comment->Post->commentCount++;
                    $this->_helper->FlashMessenger(array('Tvoj komentar je bil dodan.', 'success'));
                }
                $comment->save();
                
                $this->_redirect('/blog/' . $comment->Post->slug);
            }
            else{
                $form->setAction('/comments/add');
                $this->view->form = $form;

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
        
        $comment = Model_Comments::getCommentById($this->_getParam('id'));

        if($user['id'] != $comment->User->id && $user['role'] != 'admin'){
            $this->_helper->FlashMessenger(array('Urejaš lahko samo svoje komentarje.', 'error'));
            $this->_redirect('/');
            return;
        }
        $comment = $comment->toArray();


        $comment['user_url'] = $comment['User']['user_url'];
        if($comment['user_url'] == 'http://')
            $comment['user_url'] = '';
        $form = new Form_Comment();
        $form->setAction('/comments/add');
        $form->populate($comment);

        $this->view->form = $form;
    }
    public function saveAction()
    {
        
    }
    public function deleteAction()
    {
        $blog = Model_Post::findById($this->_getParam('post_id'));
        Model_Comments::deleteComment($this->_getParam('id'));
        $this->_helper->FlashMessenger(array('Tvoj komentar je bil izbrisan', 'success'));
        $this->_redirect('/blog/' . $blog['slug']);
    }
}


