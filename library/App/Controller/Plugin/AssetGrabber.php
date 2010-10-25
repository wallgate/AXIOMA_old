<?php

class App_Controller_Plugin_AssetGrabber extends Zend_Controller_Plugin_Abstract
{
    public function  dispatchLoopStartup(Zend_Controller_Request_Abstract $request)
    {
        $controller = $request->getControllerName();
        if ($controller != 'assets') return;

        $action   = $request->getActionName();
        $filename = APPLICATION_PATH . '/views/assets/summary/' . $action;

        $handle = @fopen($filename, "rb");
        if (!$handle) throw new Exception();

        header('Content-Disposition: attachment; filename="'.$filename.'"');
        while (!feof($handle))
        {
            $buf = fread($handle, 512);
            print($buf);
        }
        fclose($handle);

        exit();
    }
}