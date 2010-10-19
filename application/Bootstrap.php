<?php

class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{

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
}

