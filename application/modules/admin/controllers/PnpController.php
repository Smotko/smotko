<?php

class Admin_PnpController extends Zend_Controller_Action
{

    public function init()
    {

    }

    public function indexAction()
    {
        $dates = array();
        
        $zdate = new Zend_Date();
        $zdate->addDay(-1);

        $user = Zend_Auth::getInstance()->getIdentity();
            //$pnp->user_id = $user->id;
        $availableDate;
        $this->view->form = new Form_Pnp();
        for($i = 0; $i < 30; $i++)
        {
            $arr = array();
            $arr['current'] = $zdate->addDay(1)->compare(time()) ? 0 : 1;

            $arr['date'] = $zdate->get(Zend_Date::DATE_MEDIUM);
            $pnp = Model_Pnp::getPnpOnDate($zdate->toString('yyyy-M-d'));
            if($pnp){
                $arr['added'] = $pnp->id;
            }
            else{
                $arr['added'] = 0;
                
                if(is_null($this->view->form->getValue('date'))){
                    $availableDate = $arr['date'];
                    $this->view->form->date->setValue($availableDate);
                    $this->view->form->user_id->setValue($user->id);
                    $this->view->form->user_name->setValue($user->user_name);
                }
            }

            $arr['added'] = $pnp ? $pnp->id : 0;
            array_push($dates, $arr);
        }
        $date = $this->getRequest()->getParam('date');
        $id = $this->getRequest()->getParam('id');
        if(isset($date))
        {
            $zdate = new Zend_Date($date);
            if($pnp = Model_Pnp::getPnpOnDate($zdate->toString('yyyy-M-d'))){
                $date = new Zend_Date($pnp->date);
                $pnp = $pnp->toArray();
                
                $pnp['user_name'] = $pnp['User']['user_name'];
                $pnp['date'] = $date->get(Zend_Date::DATE_MEDIUM);

                $this->view->form->populate($pnp);
            }
            else{
                $this->view->form->date->setValue($date);
                $this->view->form->user_id->setValue($user->id);
                $this->view->form->user_name->setValue($user->user_name);
            }
        }
        if(isset($id))
        {
            if($pnp = Model_Pnp::findById($id)){
                $pnp = $pnp->toArray();
                $pnp['user_name'] = $pnp['User']['user_name'];
                $pnp['date'] = $pnp['date'] ? $pnp['date'] : $availableDate;
                
                $this->view->form->populate($pnp);
            }
            
        }

        $this->view->dates = $dates;
        $this->view->unconfirmed = Model_Pnp::getUnconfirmed();

        
        
    }
    public function addAction()
    {
        if($this->getRequest()->isPost()){

            $params = $this->getRequest()->getParams();

            if(!empty($params['id']))
                $pnp = Model_Pnp::findById($params['id']);
            else
                $pnp = new Model_Pnp();

            if(!empty($params['date']))
            {
                $date = new Zend_Date();
                $date->set($params['date'], Zend_Date::DATE_MEDIUM);
                $pnp->date = $date->get(Zend_Date::ISO_8601);


            }
            $pnp->content = $params['content'];
            //$user = Zend_Auth::getInstance()->getIdentity();
            $pnp->user_id = $params['user_id'];
            $pnp->save();



            $this->_redirect('/admin/pnp/');

        }
    }
    public function listAction()
    {
        $pnp = Doctrine_Query::create()
                    ->select()
                    ->from('Model_Pnp p')
                    ->leftJoin('p.User u')
                    ->fetchArray();
        $this->view->pnps = $pnp;
    }


}

