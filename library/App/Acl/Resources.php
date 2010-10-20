<?php

class App_Acl_Resources
{
    const PUBLIC_PAGE = 1;
    const PRIVATE_PAGE = 2;

    /**
     * @param Zend_Controller_Request_Abstract $request
     */
    public static function getResourceType($request)
    {
        $controller = $request->getControllerName();
        $action     = $request->getActionName();

        $type = self::PRIVATE_PAGE;

        switch ($controller)
        {
            case 'index':
                switch ($action)
                {
                    case 'index': $type = self::PUBLIC_PAGE; break;
                    case 'admin': $type = self::PRIVATE_PAGE; break;
                }
                break;
        }

        return $type;
    }
}