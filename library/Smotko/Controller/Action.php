<?php

/**
 * Scaffolding controller
 *
 * @author smotko
 */
class Smotko_Controller_Action extends Zend_Controller_Action{

    protected $table = null;
    protected $form  = null;
    protected $db    = null;
    protected $dbView= null;
    protected $_controllerName;
    protected $_redirectPath;

    public function __construct(Zend_Controller_Request_Abstract $request, Zend_Controller_Response_Abstract $response, array $invokeArgs = array())
    {
        parent::__construct($request, $response, $invokeArgs);
        $this->postInit();
        
    }

    /**
     * Initialize links to the database
     *
     * Called from {@link __construct()} as final step of object instantiation.
     *
     * @return void
     */
    private function postInit()
    {

        

        /* Set path for redirecting: */
        $this->_controllerName = $this->getRequest()->getControllerName();
        $moduleName = $this->getRequest()->getModuleName();

        if($moduleName == "default"){
           $this->_redirectPath = '/' . $this->_controllerName . '/';
        } else {
           $this->_redirectPath = '/'.$moduleName . '/' . $this->_controllerName . '/';
        }
        
        /* Set table name of the controller if none is set: */
        if(null === $this->table)
            $this->table = $this->_controllerName;

        /* Loads the default form: */
        if(null === $this->form)
            $this->form = new Smotko_Form(array('tableName' => $this->table));

        /* Loads default db_table class: */
        if(null === $this->db)
            $this->db = new Zend_Db_Table(array('name' => $this->table, 'primary'=>'id'));

        
        /* TODO: Support for table views
        try{
        $this->dbView = new Zend_Db_Table(array('name' => $this->table.'View', 'primary'=>'id'));
        }
        catch(Exception $e){
            $this->dbView = null;
        }
         * */
        
    }

    /**
     * Sets the default view for auto generated actions
     *
     * Loads views form library/Smotko/views/:action.:suffix
     *
     * @return void
     */
    protected function setView()
    {

        $this->view->setBasePath(realpath(dirname(__FILE__)) . '/../views/');
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setViewScriptPathSpec(':action.:suffix');
        $this->view->addHelperPath(realpath(dirname(__FILE__)) . '/../views/helpers');
        
    }

    /**
     * Action lists database table contents and provides links for deleting, editing and adding new items.
     *
     * @return void
     */
    public function indexAction()
    {

        
        $this->view->test = $this->table;
        $this->view->tableName = $this->table;
        $this->view->path = $this->_redirectPath;

        /* If dbView is set, load the list from it: */
        if(null !== $this->dbView){
            $this->view->tableHead = $this->dbView->info();

            $this->view->tableBody = $this->dbView->fetchAll(null, 'id DESC');
        }
        else{
            $paginator = Zend_Paginator::factory($this->db->fetchAll(null, 'id DESC')->toArray());
            $this->view->tableInfo = $this->db->info();            
            
        }
        $paginator->setCurrentPageNumber($this->_getParam('page'));
	$paginator->setDefaultItemCountPerPage(10);
        $this->view->tableBody = $paginator;
        //Zend_Debug::dump($paginator->getCurrentItems()->toArray());
        
        $this->setView();
        
    }

    /**
     * Displays the add form and adds the item to the database when the form is submitted
     *
     * @return void
     */
    public function addAction()
    {
        
        $this->view->form = $this->form;
        $this->view->path = $this->_redirectPath;
        
        if($this->getRequest()->isPost()){
            
            $formData = $this->getRequest()->getPost();
            
            if ($this->view->form->isValid($formData)) {
                $this->db->insert($this->prepareForInsert($formData));
                $this->_redirect($this->_redirectPath);
            } else {
                $this->view->form->populate($formData);
            }
        }


        $this->setView();
    }

    /**
     * Delete the record from the database
     *
     * @return void
     */
    public function deleteAction()
    {
        $id = (int)$this->getRequest()->getParam('id');
        $this->db->delete('id = '.$id);
        $this->_redirect($this->_redirectPath);

    }

    /**
     * Edit selected item
     *
     * @return void
     */
    public function editAction()
    {

        $this->view->form = $this->form;
        $this->view->path = $this->_redirectPath;
        $id = (int)$this->getRequest()->getParam('id');
        $row = $this->db->fetchRow('id = '.$id);

        $this->view->form->populate($this->prepareForPopulate($row->toArray()));

        if($this->getRequest()->isPost()){

            $formData = $this->getRequest()->getPost();
            if ($this->view->form->isValid($formData)) {
                $this->db->update($this->prepareForInsert($formData), 'id = ' . $formData[$this->table . '_id']);
                $this->_redirect($this->_redirectPath);
            } else {
                $this->view->form->populate($formData);
            }
        }
        $this->setView();
    }
    /* TODO: No parsing for populating
     * TODO: Date parsing
     */
    protected function prepareForPopulate(array $array)
    {
        $arr = array();
        foreach($array as $name=>$data){
            
            if($this->form->isTime($this->table . '_' . $name)){
                $arr[$this->table . '_' .$name] = date("d. m. Y H:i", strtotime($data));
            } 
            else if($this->form->isDate($this->table . '_' . $name)){
                $arr[$this->table . '_' .$name] = date("d. m. Y", strtotime($data));
            }
            else{
                $arr[$this->table . '_' .$name] = $data;
            }

            
        }
        return $arr;

    }
    protected function prepareForInsert(array $array)
    {
        $arr = array();
        foreach($array as $name=>$data){
            //REMOVE TABLE PREFIX:
            if(strstr($name, 'submit')) continue;


            if($this->form->isTime($name)){
                $arr[str_replace($this->table . '_', '', $name)] = new Zend_Db_Expr("STR_TO_DATE('$data', '%d. %m. %Y %H:%i:%s')");
            }
            else if($this->form->isDate($name)){
                $arr[str_replace($this->table . '_', '', $name)] = new Zend_Db_Expr("STR_TO_DATE('$data', '%d. %m. %Y')");
            }
            else{
                $arr[str_replace($this->table . '_', '', $name)] = $data;
            }
        }
        
        return $arr;
    }
    
}
