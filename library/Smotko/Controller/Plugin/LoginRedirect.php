<?php
/*
 * Loads different layout based on current module
 * 
 */
class Smotko_Controller_Plugin_LoginRedirect
    extends Zend_Controller_plugin_Abstract
{
    public function preDispatch(Zend_Controller_Request_Abstract $request)
    {


        //set active view:
        $view = Zend_Layout::getMvcInstance()->getView();
        $controller = $request->getControllerName();
        $module = $request->getModuleName();

        $uri = "/";
        if($controller == 'index')
            $controller = '';

        if($module == 'default')        
            $uri .= $controller;
        
        else
            $uri .= $module . '/' . $controller;
        
        $activeNav = $view->navigation()->findByUri($uri);
        if($activeNav !== null){            
            $activeNav->active = true;
            $activeNav->setClass("active");
        }
        //redirect if needed:
        if($request->getModuleName() != 'admin')
                return;
        if($request->getControllerName() == 'user' && $request->getActionName() == 'login')
                return;
        if(Zend_Auth::getInstance()->hasIdentity())
                return;
        $redirector = Zend_Controller_Action_HelperBroker::getStaticHelper('redirector');

        

        $redirector->gotoUrl('/admin/user/login');

        
        


    }
}