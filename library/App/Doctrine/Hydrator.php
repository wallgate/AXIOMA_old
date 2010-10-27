<?php

/**
 * При извлечении данных из базы преобразует поля типа 'data' и 'datetime' в
 * объекты Zend_Date.
 *
 * Работает только при извлечении единственной записи
 */
class App_Doctrine_Hydrator extends Doctrine_Hydrator_RecordDriver
{
    public function hydrateResultSet($stmt)
    {
        $result = parent::hydrateResultSet($stmt)->getData();

        if ($result)
        {
            $record = $result[0];

            $data    = $record->getData();
            $columns = $record->getTable()->getColumns();

            foreach ($columns as $column=>$definition)
            {
                if ($definition['type'] == 'date'
                        || $definition['type'] == 'datetime'
                        || $definition['type'] == 'timestamp')
                    if ($data[$column])
                        $record->$column = new Zend_Date($data[$column], 'Y-m-d H:i:s');
            }

            return $record;
        }

        return FALSE;
    }
}