<?php

class Admin_SettingsController extends Zend_Controller_Action
{

    public function init()
    {

    }

    public function indexAction()
    {
    	
    	$settings = Doctrine_Core::getTable('Model_Settings')->findAll();
        $this->view->list = $settings->toArray();

        $id = $this->getRequest()->getParam('id') ? (int)$this->getRequest()->getParam('id') : 0;
        $settings = Model_Settings::findActive($id);

        $arr = array('id' => $settings['id']);
        
        foreach($settings['SettingsMeta'] as $meta){
          
            $arr[$meta['metaKey']] = $meta['metaValue'];

        }


        $this->view->form = new Form_Settings();
        $this->view->form->populate($arr);

        $this->view->formAdd = new Form_SettingsAdd();
    }
    public function saveAction()
    {
        if($this->getRequest()->isPost())
        {
            $params = $this->getRequest()->getParams();
            $id = array_pop(&$params);
            $sub = array('module' => 0, 'controller' => 0, 'action' => 0, 'submit' => 0);
            $params = array_diff_key($params, $sub);
            $settings = Doctrine_Core::getTable('Model_Settings')->findOneBy('id', $id);

            $settings->SettingsMeta->delete();
            
            foreach($params as $key=>$value){
                $sm = new Model_SettingsMeta();
                $sm->metaKey = $key;
                $sm->metaValue = $value;

                $settings->SettingsMeta->add($sm);
            }
            $settings->save();
            $this->_redirect('/admin/settings/index/id/'.$id);
            

        }
        else{
            
        }

    }
    public function addAction()
    {
        if($this->getRequest()->isPost())
        {
            $settings = new Model_Settings();
            $settings->name = $this->getRequest()->getParam('name');
            $settings->save();

            $this->_redirect('/admin/settings/index/id/'.$settings->id);
        }
    }

    public function deleteAction()
    {
        $id = $this->getRequest()->getParam('id');
        if(isset ($id)){
            Model_Settings::deleteId($id);
        }
        $this->_redirect('/admin/settings/');
    }
    public function activeAction()
    {
        $id = $this->getRequest()->getParam('id');
        if(isset ($id)){
            Model_Settings::setPrimary($id);            
        }
        $this->_redirect('/admin/settings/');
    }


}

