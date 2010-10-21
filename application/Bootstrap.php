<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    public function _initView()
    {
        $this->bootstrap('layout');
        $layout = $this->getResource('layout');

        $view = $layout->getView();

        $view->doctype('XHTML1_STRICT');
        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8');
        $view->headlink()->appendStylesheet('/public/css/main.css');
        $view->headScript()->appendFile('/public/js/jquery-1.4.3.min.js');
        $view->headScript()->appendFile('/public/js/jquery.hoverIntent.js');
        $view->headScript()->appendFile('/public/js/main.js');


        $view->addHelperPath('App/View/Helper', 'App_View_Helper');

        $view->navConfig = new Zend_Config_Xml(APPLICATION_PATH.'/configs/Navigation.xml', 'nav');

        return $view;
    }

    
    public function _initDoctrine()
    {
        $this->getApplication()
             ->getAutoloader()
             ->pushAutoloader(array('Doctrine', 'autoload'))
             ->pushAutoloader(array('Doctrine', 'modelsAutoload'));

        $dbConfig       = $this->getOption('db');
        $doctrineConfig = $this->getOption('doctrine');

        $manager = Doctrine_Manager::getInstance();
        $manager->setAttribute(Doctrine::ATTR_MODEL_LOADING, $doctrineConfig['models_loading']);
        $manager->setAttribute(Doctrine::ATTR_EXPORT, Doctrine::EXPORT_ALL);
        $manager->setAttribute(Doctrine::ATTR_VALIDATE, Doctrine::VALIDATE_ALL);
        $manager->setAttribute(Doctrine::ATTR_QUOTE_IDENTIFIER, true);

        $dsn = sprintf("mysql://%s:%s@%s/%s",
            $dbConfig['username'],
            $dbConfig['password'],
            $dbConfig['host'],
            $dbConfig['dbname']
        );

        $connection = $manager->connection($dsn);

        Doctrine::loadModels($doctrineConfig['models_path']);

        return $connection;
    }


    public function _initAcl()
    {
        Zend_Registry::set('ACL', new App_Acl());
    }
}
