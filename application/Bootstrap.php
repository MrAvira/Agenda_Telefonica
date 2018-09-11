<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initView()
    {
        // Initialize view
        $view = new Zend_View();
        $view->doctype('HTML5');
        $view->headMeta()->setCharset('UTF-8');
        $view->headMeta()->appendHttpEquiv('Content-Type','text/html; charset=UTF-8');
        $view->headTitle('Agenda Telefônica');
        $view->headScript()->appendFile(
            'https://code.jquery.com/jquery-3.2.1.slim.min.js',
            'text/javascript',
            array(
                'integrity'=>'sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN',
                'crossorigin'=>'anonymous')
        );
        $view->headScript()->appendFile(
            'https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js',
            'text/javascript',
            array(
                'integrity'=>'sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q',
                'crossorigin'=>'anonymous'
            )
        );
        $view->headScript()->appendFile('/agenda_telefonica/public/js/bootstrap.min.js','text/javascript');
        $view->headLink()->appendStylesheet('/agenda_telefonica/public/css/bootstrap.min.css');
        
        // Add it to the ViewRenderer
        $viewRenderer = Zend_Controller_Action_HelperBroker::getStaticHelper('ViewRenderer');
        $viewRenderer->setView($view);
 
        // Return it, so that it can be stored by the bootstrap
        return $view;
    }

}

