<?php
/**
 * Description of Login
 *
 * @author Smotko
 */
class Form_Settings extends Zend_Form
{
    public function init(){

        $this->setName('settings');
        $this->setAction('/admin/settings/save');

        $title = new Zend_Form_Element_Text('site_title');
        $title->setLabel('Site title:');
              
        $description = new Zend_Form_Element_Textarea('site_description');
        $description->setLabel('Site description:')
                    ->setAttrib('rows', '2');
        $css = new Zend_Form_Element_Textarea('site_css');
        $css->setLabel('Site css:')
                    ->setAttrib('rows', '2');

        $keywords = new Zend_Form_Element_Textarea('keywords');
        $keywords->setLabel('Keywords:')
                 ->setAttrib('rows', '4')
                 //->setAttrib('cols', '95')
                ;
        $meta_description = new Zend_Form_Element_Textarea('meta_description');
        $meta_description->setLabel('Meta description:')
                 ->setAttrib('rows', '4')
                 //->setAttrib('cols', '95')
                ;
        $id = new Zend_Form_Element_Hidden('id');
        

        $save = new Zend_Form_Element_Submit('submit');
        $save->clearDecorators()
             ->addDecorators(array('ViewHelper', array('HtmlTag', array('tag'=>'dd', 'class' => 'fli'))));
        $reset = new Zend_Form_Element_Reset('reset');
        $reset->clearDecorators()
             ->addDecorators(array('ViewHelper', array('HtmlTag', array('tag'=>'dd', 'class' => 'fli'))));

        
        $this->addElements(array($title, $description, $css, $keywords, $meta_description, $save, $reset, $id));


        
    }
}

