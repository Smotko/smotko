<?php

class PnpController extends Zend_Controller_Action
{

    public function init()
    {
        $this->view->headTitle('PNPji', 'PREPEND');
    }

    public function indexAction()
    {
        $paginator = Zend_Paginator::factory(Model_Pnp::getAll());
        $paginator->setCurrentPageNumber($this->_getParam('stran'));
        $paginator->setDefaultItemCountPerPage(30);
        $this->view->pnp = $paginator;
        $form = new Form_Comment();
        $form->removeElement('user_url');
        if($form->getElement('captcha'))
            $form->getElement('captcha')->setAttrib('style', 'width:40px;')
                                        ->setOptions(array('captcha' => array('captcha' => 'Figlet','wordLen' => 2)));
        if($form->getElement('password'))
                $form->getElement('password')->setAttrib ('style', 'width:60px;');
        $form->getElement('submit')->setAttrib('style', 'width: 60px');
        $form->setAttrib('style', 'text-align:right;');
        $form->setAction('/pnp/add');

        $todayPnp = Model_Pnp::getPnpOnDate(date('Y-m-d'));
        if(!$todayPnp)
        {
            $dateElement = new Zend_Form_Element_Hidden('date');
            $date = new Zend_Date();

            $dateElement->setValue($date->toString(Zend_Date::DATE_MEDIUM));
            $form->addElement($dateElement);
        }

        $this->view->form = $form;
    }
    public function addAction()
    {
        if($this->getRequest()->isPost()){

            $form = new Form_Comment();
            if($form->isValid($this->getRequest()->getParams())){

                $pnp = new Model_Pnp();
                $pnp->fromArray($form->getValues());
                if($this->_hasParam('date'))
                {
                    $date = new Zend_Date();
                    $date->set($this->_getParam('date'), Zend_Date::DATE_MEDIUM);
                    $pnp->date = $date->get(Zend_Date::ISO_8601);
                    $this->_helper->FlashMessenger(array('Tvoj PNP je bil sprejet!', 'success'));

                }
                else{
                    $this->_helper->FlashMessenger(array('Tvoj PNP je bil dodan, ampak ga mora avtor strani še potrdit.', 'success'));
                }
                $pnp->User = Model_User::setUser($form->getValues());
                $pnp->save();
                $this->_redirect('/pnp/');
            }
            else
            {
                $this->_helper->FlashMessenger(array('Med dodajanjem PNPja je prišlo do napake. Si izpolnil vsa polja?', 'error'));
            }
        }
        $this->_redirect('/pnp/' . $pnp->Post->slug);
        



    }


}

