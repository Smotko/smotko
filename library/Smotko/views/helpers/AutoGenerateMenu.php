<?php

class Zend_View_Helper_AutoGenerateMenu {
    function autoGenerateMenu(){
        
        $dir = opendir(APPLICATION_PATH . '/controllers');

        /* LOL HACK TO SKIP . & .. */
        readdir($dir); readdir($dir);

        /* TODO: Check if admin module */
        $menu = '<li><a href="/admin/" title="Index">Index</a></li>';
        
        while($controller = readdir($dir)){

            $name = str_replace('Controller.php', '', $controller);
            if(strcmp($name, 'Index') != 0 && strcmp($name, 'Error') != 0)
                $menu .= '<li><a href="/admin/' . strtolower($name) . '" title="' . $name . '">' . $name . '</a></li>';
        }
        return $menu;
        
    }
    
}

