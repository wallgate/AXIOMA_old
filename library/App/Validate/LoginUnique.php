<?php

class App_Validate_LoginUnique extends Zend_Validate_Db_NoRecordExists
{
    public function isValid($value)
    {
        $valid = true;
        $this->_setValue($value);

        $table = new Table_User();
        $result = $table->getUserByLogin($value);
        if ($result)
        {
            $valid = false;
            $this->_error(self::ERROR_RECORD_FOUND);
        }

        return $valid;
    }
}