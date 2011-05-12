<?php
/**
 * Description of Smotko_Form
 * extands Zend_Form
 * @author smotko
 */
class Smotko_Form extends Zend_Form
{
    protected $_elementDecorators = array(
        'ViewHelper',
        array('Errors', array( 'class' => 'grid_3 omega')),
        'Description',
        array('Label', array( 'class' => 'grid_3 alpha')),
        array('htmlTag', array('style'=>'clear:left'))
    );
    protected $_buttonDecorators = array(
        'ViewHelper',
        'Errors',
        'Description',
        array('htmlTag', array('style'=>'clear:left'))
    );
    protected $_groupDecorators = array(
        'FormElements',
        'Fieldset'
    );

    public function loadDefaultDecorators() {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return;
        }

        $decorators = $this->getDecorators();
        if (empty($decorators)) {
            $this->addDecorator('FormElements')
                 //->addDecorator('HtmlTag', array('tag' => 'dl', 'class' => 'zend_form'))
                 ->addDecorator('Form', array('class' => 'smotko_form'));

        }
    }


}
