<?php

/**
 * Контейнер для элементов меню
 *
 * Класс отличается от Zend_Navigation тем, что формирует меню не изо всех
 * без разбора переданных ему элементов, а лишь из тех, к которым у пользователя
 * есть доступ
 */
class App_Navigation extends Zend_Navigation
{
    private $acl;

    // @todo разобраться как следует с навигацией

    public function __construct($pages = null)
    {
        if (!is_array($pages))
        {
            if (method_exists($pages, 'toArray'))
                $pages = $pages->toArray();
            else return false;
        }

        $this->acl = Zend_Registry::get('ACL');
        $role  = Zend_Auth::getInstance()->getIdentity()->role;


        $pages = $this->filter($role, $pages);


        parent::__construct($pages);
    }

    /**
     * Выбирает из массива pages только те ресурсы, доступ к которым открыт для пользователей с заданной ролью
     * @param int $role роль
     * @param array $pages массив ресурсов
     * @return array
     */
    private function filter($role, array $pages, $level=0)
    {
        $out = array();
        foreach ($pages as $page)
        {
            if ($level) unset($page['pages']);
            if (is_array($page['pages']))
                $page['pages'] = $this->filter ($role, $page['pages'], $level+1);
            if (!count($page['pages'])) unset($page['pages']);

            $type = App_Acl_Resources::getResourceType($page['uri']);
            if ($this->acl->isAllowed($role, $type)) $out[] = $page;
        }
        return $out;
    }
}