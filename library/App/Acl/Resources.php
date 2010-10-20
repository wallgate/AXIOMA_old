<?php

class App_Acl_Resources
{
    const ERROR = -101;

    private static $resources;
    
    public function __construct($resources)
    {
        self::$resources = $resources;
    }

    public function getResources()
    {
        return self::$resources;
    }


    /**
     * @param Zend_Controller_Request_Abstract $request
     */
    public static function getResourceType($request)
    {
        $controller = $request->getControllerName();
        $action     = $request->getActionName();

        $url = $controller.'/'.$action;
        return self::$resources[$url]['rule'];

        throw new Exception(self::ERROR);
    }
}