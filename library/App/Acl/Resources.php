<?php

class App_Acl_Resources
{
    const ERROR_ROADMAP_INVALID_FORMAT = -99;

    private static $resources;
    
    public function __construct($navConfig)
    {
        if ($navConfig instanceof Zend_Config)
            $navConfig = $navConfig->toArray();

        if (!is_array($navConfig))
            throw new Exception(self::ERROR_ROADMAP_INVALID_FORMAT);

        self::$resources = $this->processRoadmap($navConfig);
    }


    private function processRoadmap(array $resources)
    {
        $out = array();

        foreach ($resources as $resource)
        {
            if (is_array($resource['pages']))
            {
                $inner = $this->processRoadmap($resource['pages']);
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
     * @param array $request
     */
    public static function getResourceType($request)
    {
        if (is_array($request))
            $url = '/'.$request['controller'].'/'.$request['action'];
            elseif (is_string($request)) $url = $request;
        return self::$resources[$url]['rule'];
    }
}