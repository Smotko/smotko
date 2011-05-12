<?php

class RController extends Zend_Controller_Action
{
    public function init(){
        $this->_redirect("http://reddit.com" . getenv("REQUEST_URI"));
    }
}

