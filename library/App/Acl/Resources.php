<?php

class App_Acl_Resources
{
    private static $resources;
    
    public function __construct($navConfig)
    {
        if (!is_array($navConfig))
        {
            // @todo поставить сюда try-catch
            $navConfig = $navConfig->toArray();
        }
        self::$resources = $this->processNavigation($navConfig);
    }


    private function processNavigation(array $resources)
    {
        $out = array();

        foreach ($resources as $resource)
        {
            if (is_array($resource['pages']))
            {
                $inner = $this->processNavigation($resource['pages']);
                foreach ($inner as $page)
                    $out[$page['uri']] = $page;
                unset($resource['pages']);
            }

            $out[$resource['uri']] = $resource;
        }
        return $out;
    }


    public static function getResources()
    {
        return self::$resources;
    }


    /**
     * @param Zend_Controller_Request_Abstract $request
     */
    public static function getResourceType($request)
    {
        if ($request instanceof Zend_Controller_Request_Abstract)
        {
            $controller = $request->getControllerName();
            $action     = $request->getActionName();
            $url = '/'.$controller.'/'.$action;
        }
        elseif (is_string($request))
            $url = $request;

        return self::$resources[$url]['rule'];
    }
}