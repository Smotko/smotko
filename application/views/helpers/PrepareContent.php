<?php
include "markdown.php";
class Zend_View_Helper_PrepareContent {
    
    private $length = 320;
    private $newLines = 5;
    
    private $_view;
    
    public function prepareContent($text)
    {
        //if(Zend_Controller_Front::getInstance()->getRequest()->getControllerName() == 'blog')
                //$this->length *= 4;
        $text = nl2br(Markdown($this->_view->escape($text)));
//        $noLines = split("\n", $text);
//
//        if(count($noLines) > $this->newLines){
//            $text = join("\n", array_slice($noLines, 0, 5)) . '<span class="comment_dots"> (...)</span><span class="full_comment">' . join("\n", array_slice($noLines, 5)) . '</span>';
//        }
//        else if(strlen($this->_view->addLink($text)) > $this->length){
//            $text = utf8_decode(substr(utf8_encode($text), 0, $this->length - 40)) . '<span class="comment_dots"> (...)</span><span class="full_comment">' . utf8_decode(substr(utf8_encode($text), $this->length - 40)) . '</span>';
//            
//        } 
        $text = nl2br(trim($this->_view->addLink($text)));
        return $text; 
    }
    public function setView($view) {
        $this->_view = $view;
    }

}

