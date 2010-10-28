<?php

/**
 * При извлечении данных из базы преобразует поля типа 'data' и 'datetime' в
 * объекты Zend_Date.
 */
class App_Doctrine_RecordHydrator extends Doctrine_Hydrator_RecordDriver
{
    /**
     * Гидратор.
     * Возвращает запись (потомка Doctrine_Record), если она единственная, или
     * массив таких записей, если их несколько
     *
     * @param mixed $stmt
     * @return Doctrine_Collection
     */
    public function hydrateResultSet($stmt)
    {
        $result  = parent::hydrateResultSet($stmt);
        $columns = $result->getTable()->getColumns();
        $data    = $result->getData();

        if (count($data))
        {
            foreach($data as $record)
            {
                foreach ($columns as $column=>$definition)
                {
                    if ($definition['type'] == 'date' || $definition['type'] == 'datetime')
                        if ($record->$column)
                            $record->$column = new Zend_Date($record->$column, 'Y-M-d H:m:s');
                }
                
                $rowset[] = $record;
            }

            return count($rowset)>1 ? $rowset : $rowset[0];
        }

        return NULL;
    }
}