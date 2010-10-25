<?php

class App_Validate_EmailAddress extends Zend_Validate_EmailAddress
{
    public function isValid($value)
    {
        $this->_setValue($value);

        if ((strpos($value, '..') !== false) ||
            (!preg_match('/[a-zA-Z0-9_]+@[a-zA-Z0-9-_]+\.[a-zA-Z]{2,6}/is', $value)))
        {
            $this->_error(self::INVALID_FORMAT);
            return false;
        }

        return true;
    }
}