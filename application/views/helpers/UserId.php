<?php

class Zend_View_Helper_UserId {
    function userId(){
        
       $user = Zend_Registry::get('User');
       if($user == null)
           return null;
       else
           return $user['id'];
        
    }
    
}
