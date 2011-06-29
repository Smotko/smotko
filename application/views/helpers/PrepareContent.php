<?php
include "markdown.php";
class Zend_View_Helper_PrepareContent {
    
    private $length = 320;
    private $newLines = 5;
    
    private $_view;
    
    public function prepareContent($text, $markdown)
    {
        $text = $this->_view->escape($text);
        if($markdown)
            $text = Markdown($text);
        else{
            
            $text = nl2br(trim($this->_view->addLink($text)));
        }
        $text = trim($text);
        return $text; 
    }
    public function setView($view) {
        $this->_view = $view;
    }

}

