<?php

class App_Acl_Resources
{
    const ERROR_ROADMAP_INVALID_FORMAT = -99;

    /**
     * @var array
     *
     * ресурсы системы, где ключ - псевдоним ресурса, значение - массив,
     * содержащий label и uri
     */
    private static $resources;
    
    public static function initResources($resourcesConfig)
    {
        if (!is_array($resourcesConfig))
        {
            if (method_exists($resourcesConfig, 'toArray'))
                $resourcesConfig = $resourcesConfig->toArray();
            else
                throw new Exception(self::ERROR_ROADMAP_INVALID_FORMAT);
        }

        $instance = new self();
        self::$resources = $instance->processRoadmap($resourcesConfig);
    }


    private function processRoadmap(array $resources)
    {
        $out = array();

        foreach ($resources as $name=>$resource)
        {
            if (is_array($resource['pages']))
            {
                $inner = $this->processRoadmap($resource['pages']);
                foreach ($inner as $innername=>$page) $out[$innername] = $page;
                unset($resource['pages']);
            }

            $out[$name] = $resource;
        }
        return $out;
    }




    
    public static function getResources()
    {
        return self::$resources;
    }

    public static function getResource($alias)
    {
        return self::$resources[$alias];
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
     * @param Zend_Controller_Request_Abstract $request запрос
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

        foreach (self::$resources as $alias=>$resource)
            if ($resource['uri'] == $request)
            {
                $resourceAlias = $alias;
                break;
            }

        return $resourceAlias;
    }
}