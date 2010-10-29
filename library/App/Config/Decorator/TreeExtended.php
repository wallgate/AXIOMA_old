<?php

class App_Config_Decorator_TreeExtended implements App_Config_Decorator_TreeExtended_Interface
{
    protected $xmlConfig;

    public function  __construct(Zend_Config_Xml $xmlConfig)
    {
        $this->xmlConfig = $xmlConfig;
    }

    public function __call($name, $arguments)
    {
        if (method_exists($this->xmlConfig, $name))
            $this->xmlConfig->$name($arguments);
    }

    public function getChildren($parentName)
    {
        $parentNode = $this->xmlConfig->$parentName;

        foreach (array_keys($parentNode->toArray()) as $node)
            if ($parentNode->$node instanceof Zend_Config)
                $children[] = $parentNode->$node;

        return $children;
    }

    public function getParent() {}
}