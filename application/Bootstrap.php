<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
    protected function _initView()
    {
        $this->bootstrap('layout');
        $layout = $this->getResource('layout');

        $view = $layout->getView();

        $view->doctype('XHTML1_STRICT');
        $view->headMeta()->appendHttpEquiv('Content-Type', 'text/html;charset=utf-8');
        $view->headlink()->appendStylesheet('/public/css/main.css');
        $view->headScript()->appendFile('http://ajax.googleapis.com/ajax/libs/jquery/1.4.3/jquery.min.js');
        $view->headScript()->appendFile('/public/js/jquery.hoverIntent.js');
        $view->headScript()->appendFile('/public/js/main.js');

        $view->addHelperPath('App/View/Helper', 'App_View_Helper');

        return $view;
    }

    protected function _initControllerPlugins()
    {
        $front = Zend_Controller_Front::getInstance();

        $acPlugin = new App_Controller_Plugin_AccessControl();
        $acPlugin->setExceptions(array('login', 'error'));
        $front->registerPlugin($acPlugin);
        Zend_Controller_Action_HelperBroker::addHelper(new App_Controller_Action_Helper_Acl());

        $front->registerPlugin(new App_Controller_Plugin_AssetGrabber());
    }


    protected function _initDoctrine()
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

        $manager->registerHydrator('app_hydrator', 'App_Doctrine_RecordHydrator');

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


    protected function _initAcl()
    {
        $this->bootstrap('view');
        $view = $this->view;

        $view->navConfig = new Zend_Config_Xml(APPLICATION_PATH.'/configs/Roadmap.xml', 'nav');
        App_Acl_Resources::initResources($view->navConfig);
        App_Acl_Roles::initRoles();
    }


    protected function _initValidators()
    {
        $translate = new Zend_Translate('array', array(
            Zend_Validate_NotEmpty::IS_EMPTY             => 'поле не может быть пустым',
            Zend_Validate_StringLength::TOO_SHORT        => 'строка не должна быть короче %min% символов',
            Zend_Validate_StringLength::TOO_LONG         => 'строка не должна быть длиннее %max% символов',
            Zend_Validate_Identical::NOT_SAME            => 'пароли должны совпадать',
            App_Validate_EmailAddress::INVALID_FORMAT    => 'введён некорректный адрес e-mail',
            App_Validate_LoginUnique::ERROR_RECORD_FOUND => 'этот логин уже занят'
        ), 'ru');

        Zend_Validate::setDefaultTranslator($translate);

        return $translate;
    }


    protected function _initRouter()
    {
        $router = Zend_Controller_Front::getInstance()->getRouter();

        // логаут
        $router->addRoute('logout', new Zend_Controller_Router_Route(
            '/logout', array('controller'=>'login', 'action'=>'logout')
        ));

        // сотрудники
        $router->addRoute('showUsers', new Zend_Controller_Router_Route(
            '/employee/:status', array('controller'=>'employee', 'action'=>'index', 'status'=>$status)
        ));
        $router->addRoute('viewUser', new Zend_Controller_Router_Route(
            '/employee/view/:login', array('controller'=>'employee', 'action'=>'view', 'login'=>$login)
        ));
        $router->addRoute('editUser', new Zend_Controller_Router_Route(
            '/employee/form/:login', array('controller'=>'employee', 'action'=>'form', 'login'=>$login)
        ));
        $router->addRoute('deleteUser', new Zend_Controller_Router_Route(
            '/employee/delete/:login', array('controller'=>'employee', 'action'=>'delete', 'login'=>$login)
        ));

        // должности
        $router->addRoute('newRole', new Zend_Controller_Router_Route(
            '/roles/new', array('controller'=>'roles', 'action'=>'permissions')
        ));
        $router->addRoute('editRole', new Zend_Controller_Router_Route(
            '/roles/:role/permissions', array('controller'=>'roles', 'action'=>'permissions', 'role'=>$role)
        ));
        $router->addRoute('deleteRole', new Zend_Controller_Router_Route(
            '/roles/delete/:role', array('controller'=>'roles', 'action'=>'delete', 'role'=>$role)
        ));


        return $router;
    }


    protected function _initAssets()
    {
        $assetsConfig = $this->getOption('assets');
        $assetsConfig['summaryPath'] = $assetsConfig['path'] . '/summary';

        if (!is_dir($assetsConfig['path']))
            mkdir($assetsConfig['path']);
        if (!is_dir($assetsConfig['summaryPath']))
            mkdir($assetsConfig['summaryPath']);

        Zend_Controller_Front::getInstance()->setParam('assetsConfig', $assetsConfig);
    }
}
