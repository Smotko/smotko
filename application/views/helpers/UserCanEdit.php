<?php

class Zend_View_Helper_UserCanEdit {
    function userCanEdit($id){

       $user = Zend_Registry::get('User');
       if($user != null && ($user['id'] == $id && $user['password'] != null || $user['role'] == 'admin') )
           return true;
       return false;

    }

}