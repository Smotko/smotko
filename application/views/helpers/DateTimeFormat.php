<?php

class Zend_View_Helper_DateTimeFormat {
    function dateTimeFormat($value){
        
        $date = new Zend_Date($value);
        return $date->toString(Zend_Date::DATETIME_MEDIUM);
	//$value = substr($value, 0, 10);
	//return substr($value, 8) . '.' . substr($value, 5, 2) . '.' . substr($value, 0, 4);
        
    }
    
}

