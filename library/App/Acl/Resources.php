<?php

class App_Acl_Resources
{
    const ERROR_ROADMAP_INVALID_FORMAT = -99;

    /**
     * @var Zend_Config
     */
    private static $resources;

    /**
     * @param App_Config_Decorator_TreeExtended_Interface $resourcesConfig
     */
    public static function setResources($resourcesConfig)
    {
        //var_dump($resourcesConfig->get('admin'));
        self::$resources = $resourcesConfig;

        //$xml = simplexml_load_file(APPLICATION_PATH.'/configs/Roadmap.xml');
        //var_dump($xml->resources->admin->children());
//die();
        var_dump($resourcesConfig->getChildren('admin'));
    }



    
    public static function getResources()
    {
        return self::$resources;
    }

    public static function getResource($alias)
    {
        return self::$resources->get($alias);
    }

    public static function findResource($request)
    {
        $alias = self::getResourceAlias($request);
        return self::$resources[$alias];
    }

    /**
     * Возвращает псевдоним ресурса, под которым тот значится в Roadmap.xml.
     * В качестве запроса можно также передавать строку в формате
     * /имя_контроллера/имя_действия
     *
     * @param Zend_Controller_Request_Abstract | string $request запрос
     * @return string
     */
    public static function getResourceAlias($request)
    {
        if ($request instanceof Zend_Controller_Request_Abstract)
            $request = sprintf('/%s/%s',
                $request->getControllerName(),
                $request->getActionName()
            );

        if (!is_string($request)) throw new Exception();
        // @todo уточнить, что методу не понравилось

        $resources = self::$resources;

        foreach (self::$resources as $alias=>$resource)
            if ($resource['uri'] == $request)
            {
                $resourceAlias = $alias;
                break;
            }

        return $resourceAlias;
    }
}