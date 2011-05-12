<?php

class BlogController extends Zend_Controller_Action
{

    public function init()
    {
        /* Initialize action controller here */
    }

    public function indexAction()
    {
        $slug = $this->getRequest()->getParam('slug');
        $this->view->headTitle('Blog', 'PREPEND');
        ;
        
        if(isset($slug))
        {
            $this->view->blogs = Model_Post::findBySlug($slug);
           
            $this->view->headTitle($this->view->blogs[0]['title'], 'PREPEND');
            if(empty($this->view->blogs))
            {
                $this->_helper->FlashMessenger(array('Navedeni blog ne obstaja', 'info'));
                $this->_redirect('/blogs');
            }
            $this->view->form = new Form_Comment();
            $this->view->form->setAction('/comments/add');
            $this->view->form->post_id->setValue($this->view->blogs[0]['id']);
            
            
            
        }
        else{
            $this->_helper->FlashMessenger(array('Navedeni blog ne obstaja', 'info'));
            $this->_redirect('/blogs');
        }
        
    }
}



