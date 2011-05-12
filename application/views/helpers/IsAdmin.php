<?php

class Zend_View_Helper_IsAdmin {
    function isAdmin(){

       $user = Zend_Registry::get('User');
       if($user != null && $user['role'] == 'admin')
           return true;
       return false;

    }

}