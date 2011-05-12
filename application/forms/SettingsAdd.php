<?php
/**
 * Description of Login
 *
 * @author Smotko
 */
class Form_SettingsAdd extends Zend_Form
{
    public function init(){

        $this->setName('settingsAdd');
        $this->setAction('/admin/settings/add');

        $name = new Zend_Form_Element_Text('name');
        $name->removeDecorator('label');
        
        $save = new Zend_Form_Element_Submit('addSetting');
        $save->clearDecorators()
             ->setLabel('Add')
             ->addDecorators(array('ViewHelper', array('HtmlTag', array('tag'=>'dd', 'class' => 'fli'))));

        $this->addElements(array($name, $save));


        
    }
}

