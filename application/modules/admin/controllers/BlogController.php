<?php

class Admin_BlogController extends Zend_Controller_Action
{

    public function init()
    {
        $this->msg = $this->_helper->getHelper('FlashMessenger');
    }

    public function indexAction()
    {

        $this->view->form = new Form_Blog();

        $id = $this->getRequest()->getParam('id');

        if(isset($id))
        {
            $blog = Model_Post::findById($id);
            $blog = $blog->toArray();

            $blog['categories'] = array();
            foreach($blog['Categories'] as $cat){
                array_push($blog['categories'], $cat['id']);

            }

           $this->view->form->populate($blog);
        }

        
        $blogs = Model_Post::getLatestBlogs();
        
        $this->view->blogs = $blogs;

        $categories = Doctrine_Query::create()
                    ->select()
                    ->from('Model_Categories c')
                    ->execute();
        $this->view->categories = $categories->toArray();
        
    }
    public function editAction()
    {
        $this->_forward('index');
    }
    public function addAction(){
        
        if($this->getRequest()->isPost()){
            
            $params = $this->getRequest()->getParams();
            
            if(!empty($params['id']))
                $blog = Model_Post::findById($params['id']);
            else
                $blog = new Model_Post();
            
            $blog->fromArray($params);
            $blog->status = 'published';
            $blog->type = 'blog';
            $blog->Categories->clear();
            $user = Zend_Auth::getInstance()->getIdentity();
            $blog->user_id = $user->id;

            foreach($params['categories'] as $cat)
            {
                $categorie = Doctrine_Core::getTable('Model_Categories')->find($cat);
                $blog->Categories->add($categorie);

            }
            //Zend_Debug::dump($params['categories']);die;

            $blog->save();
            $this->msg->addMessage(array('Tvoj komentar je bil dodan, hvala.', 'success'));
            

            $this->_redirect('/admin/blog/');

        }
    }
    public function addcategorieAction()
    {
        if($this->getRequest()->isPost()){

            $params = $this->getRequest()->getParams();
            $categorie = new Model_Categories();
            $categorie->fromArray($params);
            $categorie->save();



            $this->_redirect('/admin/blog/');

        }
    }
    public function deleteAction(){

        $id = $this->getRequest()->getParam('id');
        if(isset($id)){
            $q = Doctrine_Query::create()
                    ->delete('Model_PostCategories')
                    ->where('post_id = ?', $id)
                    ->execute();
            $q = Doctrine_Query::create()
                    ->delete('Model_Post')
                    ->where('id = ?', $id)
                    ->execute();
            $this->_redirect('/admin/blog');
        }
    }
    public function deletecategorieAction(){

        $id = $this->getRequest()->getParam('id');
        if(isset($id)){
            $q = Doctrine_Query::create()
                    ->delete('Model_Categories')
                    ->where('id = ?', $id)
                    ->execute();
            $this->_redirect('/admin/blog');
        }
    }
    public function listAction()
    {
        $blogs = Doctrine_Query::create()
                    ->select()
                    ->from('Model_Post p')
                    ->where('type = ?', 'blog')
                    ->execute();
        $this->view->blogs = $blogs->toArray();
    }


}

