<?php

class BlogsController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->headTitle('Blog', 'PREPEND');
    }

    public function indexAction()
    {
        
        $paginator = Zend_Paginator::factory( Model_Post::getLatestBlogs());
        $paginator->setCurrentPageNumber($this->_getParam('stran'));
        $paginator->setDefaultItemCountPerPage(10);
        $this->view->blogs = $paginator;

        $this->view->categories = Model_Categories::getAll();
    }

    public function categoriesAction()
    {
        if(!$this->_hasParam('categorie')){
            $this->_redirect('/blogs/');
        }
        $paginator = Zend_Paginator::factory(Model_Post::getBlogsByCategories($this->_getParam('categorie')));
        $paginator->setCurrentPageNumber($this->_getParam('stran'));
        $paginator->setDefaultItemCountPerPage(10);
        $this->view->blogs = $paginator;
        $cat = Model_Categories::findNameForSlug($this->_getParam('categorie'));
        $this->view->categorie = $cat['name'];
        $this->view->headTitle($cat['name'], 'PREPEND');
        $this->view->categories = Model_Categories::getAll();
    }
    public function rssAction(){

        //Disable view/layout:
        $this->_helper->viewRenderer->setNoRender(true);
        $this->_helper->layout()->disableLayout();

        //Create array to store the RSS feed entrie:
        $entries = array();
        $blog = new Model_Post();

        $feed = Zend_Feed::importArray($blog->getFeed(), 'rss');

        //Show feed:
        $feed->send();
    }


}



