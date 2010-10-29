<?php

interface App_Config_Decorator_TreeExtended_Interface
{
    public function getChildren($parentNode);

    public function getParent();
}