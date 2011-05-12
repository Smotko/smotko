<?php

class Zend_View_Helper_DateFormat {
    function dateFormat($value){
        
        $date = new Zend_Date($value);
        return $date->toString(Zend_Date::DATE_MEDIUM);
	//$value = substr($value, 0, 10);
	//return substr($value, 8) . '.' . substr($value, 5, 2) . '.' . substr($value, 0, 4);
        
    }
    
}

