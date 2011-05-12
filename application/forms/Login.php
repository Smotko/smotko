<?php
/**
 * Description of Login
 *
 * @author Smotko
 */
class Form_Login extends Zend_Form
{
    public function init(){

        $this->setName('login');

        $username = new Zend_Form_Element_Text('user_name');
        $username->setRequired()
                 ->addValidator(new Zend_Validate_Alpha())
                 //->setDecorators($this->_elementDecorators)
                 ->setLabel('Uporabnik:')
                 //->setAttrib('class','grid_3')
        ;

        $password = new Zend_Form_Element_Password('password');
        $password->setRequired()
                //->setDecorators($this->_elementDecorators)
                 ->setLabel('Geslo:')
                //->setAttrib('class','grid_3')
        ;

        $remember = new Zend_Form_Element_Checkbox('remember');
        $remember->setLabel('Zapomni:')
                //->setDecorators($this->_elementDecorators)
                  //      ->setAttrib('class','grid_3')
        ;
        $submit = new Zend_Form_Element_Submit('login_submit');
        $submit->setLabel('Prijavi')
                //->setDecorators($this->_buttonDecorators)
                //->setAttrib('class', 'alpha grid_3 push_3')
        ;

        $this->addElements(array($username, $password, $remember, $submit));
        
        $this->setLegend('Login');

        
    }
}

