<?php

class Zend_View_Helper_StatusMessage {

    private $_flashMessenger = null;
    
    function statusMessage(){

        //the status message is rendered only once
        
        $this->_flashMessenger =
            Zend_Controller_Action_HelperBroker::getStaticHelper('FlashMessenger');
        
        $messages = $this->_flashMessenger->getMessages();
        
        foreach($messages as $msg)
            echo '<div class="message '. $msg[1] .' boxshadow grid_12"><p>' . $msg[0] . '<img class="hide_msg" alt="dismiss" src="/images/icons/dismiss.png" /></p></div>';
        



    }

}