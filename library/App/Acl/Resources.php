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


    public static function getResourceAlias(Zend_Controller_Request_Abstract $request)
    {
        $controller = $request->getControllerName();
        $action     = $request->getActionName();

        $uri = '/' . $controller . '/' . $action;

        foreach (self::$resources as $alias=>$resource)
            if ($resource['uri'] == $uri)
            {
                $resourceAlias = $alias;
                break;
            }

        return $resourceAlias;
    }
}