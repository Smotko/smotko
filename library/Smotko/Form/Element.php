<?php
/**
 * Description of Element
 *
 * @author Smotko
 */
class Smotko_Form_Element extends Zend_Form_Element{

    public function loadDefaultDecorators()
    {
        if ($this->loadDefaultDecoratorsIsDisabled()) {
            return;
        }

        $decorators = $this->getDecorators();
        if (empty($decorators)) {
            $this->addDecorator('ViewHelper')
                ->addDecorator('Errors')
                ->addDecorator('Description') //, array('tag' => 'p', 'class' => 'description')
                //->addDecorator('HtmlTag', array('tag' => 'dd',
                //                                'id'  => $this->getName() . '-element'))
                ->addDecorator('Label'); //, array('tag' => 'dt')
        }
    }
}

