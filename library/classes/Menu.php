<?php

class Menu {
    /**
     *
     * @var string Заголовок пункта меню
     */
    public $label;
    /**
     *
     * @var array Действия, выполняемые в пределах пункта меню
     */
    private $actions;
    /**
     *
     * @var string Основное действие для данного пункта меню
     */
    private $baseAction;
    
    public function __construct($label, array $actions = array(), $baseAction) {
        $this->label = $label;
        $this->actions = $actions;
        $this->baseAction = $baseAction;
    }
    
    private static $menuList = null;

    /**
     * Заполняем меню.
     * @return array
     */
    public static function getMenuList() {
        if (Menu::$menuList === null) {
            // Заполняем пункты меню.
            $list = array();
            $list[] = new Menu(
                    "Главная",
                    array(''),
                    ''
                    );
            $list[] = new Menu(
                    "Пользователи",
                    array('users'),
                    'users'
                    );
            $list[] = new Menu(
                    "Страницы",
                    array('archive', 'newArticle', 'editArticle', 'deleteArticle', 'viewArticle'),
                    'archive'
                    );
            Menu::$menuList = $list;
        }
        return Menu::$menuList;
    }

    /**
     * 
     * @return boolean Пункт меню выбран
     */
    public function isSelected() {
        // Разбираем запрос, ищем текущий элемент меню.
        $pageAction = Route::getCurrentRoute()->action;
        
        foreach ($this->actions as $action) {
            if ($pageAction == $action) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * 
     * @return string URL для перехода в пункт меню
     */
    public function getUrl() {
        return Route::getUrl($this->baseAction);
    }
}
