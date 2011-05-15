<?php

class ApiController extends Zend_Controller_Action
{

    public function debateAction() {
        
        /* COPY PASTED CODE FROM INDEX CONTROLLER! IF YOU ARE READING THIS YOU SHOULD REFACTOR IT! :p */
        $paginator = Zend_Paginator::factory(Model_Debate::getDebate());
        $paginator->setCurrentPageNumber($this->_getParam('stran'));
        $paginator->setItemCountPerPage(8);
        $this->view->debate = $paginator;
        $this->_helper->layout->disableLayout();        
    }
    
    public function debatehighestAction(){

        //$id = $this->_getParam('id');
        //Zend_Debug::dump(Model_Debate::getNumNew($id));die;
        $this->_helper->json(array('num' => Model_Debate::getHighest()->id));
        
    }
    


}



