<?php
/**
 * Description of Login
 *
 * @author Smotko
 */
class Form_Pnp extends Zend_Form
{
    public function init(){

        $this->setName('pnp');
        $this->setAction('/admin/pnp/add');

        $id = new Zend_Form_Element_Hidden('id');
        $user_id = new Zend_Form_Element_Hidden('user_id');
        

        $name = new Zend_Form_Element_Text('user_name');
        $name->setLabel('Ime:')
             ->setAttrib('readonly', 'readonly');

        $date = new Zend_Form_Element_Text('date');
        $date->setLabel('Date:')
                 ;
        $content = new Zend_Form_Element_Textarea('content');
        $content->setLabel('Content:')
                ->setAttrib('id', 'pnp_content')
                ->setAttrib('rows', '3')
                ;
        
        $save = new Zend_Form_Element_Submit('submit');
        $save->clearDecorators()
             ->addDecorators(array('ViewHelper', array('HtmlTag', array('tag'=>'dd', 'class' => 'fli'))));
        $reset = new Zend_Form_Element_Reset('reset');
        $reset->clearDecorators()
             ->addDecorators(array('ViewHelper', array('HtmlTag', array('tag'=>'dd', 'class' => 'fli'))));
        $this->addElements(array($date, $user_id, $name, $content, $save, $reset, $id));
        
                
        
        //Zend_Debug::dump($grp->getDecorator('DtDdWrapper'));die;
        //$grp->clearDecorators();
        

        
    }
}

