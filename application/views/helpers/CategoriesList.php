<?php

class Zend_View_Helper_CategoriesList {
    function categoriesList(){

        $str = "";
        foreach(Model_Categories::getAll() as $cat){
            $str .= ', ' . $cat['name'];
        }
        return $str;
    }
    
}

