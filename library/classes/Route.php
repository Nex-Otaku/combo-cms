<?php

class Route {
    /**
     *
     * @var string Действие
     */
    public $action;
    /**
     *
     * @var array Параметры
     */
    public $params;
    /**
     *
     * @var array Значения параметров
     */
    public $values;
    
    public function __construct($action, array $params) {
        $this->action = $action;
        $this->params = $params;
    }

    /**
     * Конструируем человекопонятный URL, по заданным параметрам.
     * @param string $action
     * @param array $values
     * @return string
     */
    public static function getUrl($action = '', array $values = array()) {
        $url = '/';
        if (!empty($action)) {
            $route = Route::getRouteForAction($action);
            if ($route == null) {
                trigger_error("Route::getUrl(): Не найден маршрут для действия ($action).", E_USER_ERROR);
            }
            $url .= $action;
            $route->validateParams($values, true);
            if (!empty($route->params)) {
                foreach ($route->params as $option) {
                    $url .= '/' . $values[$option];
                }
            }
        }
        return $url;
    }

    private static $routeList = null;

    /**
     * Заполняем маршруты.
     * @return array
     */
    public static function getRouteList() {
        if (Route::$routeList === null) {
            // Заполняем маршруты.
            $list = array();
            $list[] = new Route(
                    "login",
                    array()
                    );
            $list[] = new Route(
                    "logout",
                    array()
                    );
            $list[] = new Route(
                    "newArticle",
                    array()
                    );
            $list[] = new Route(
                    "editArticle",
                    array('articleId')
                    );
            $list[] = new Route(
                    "deleteArticle",
                    array('articleId')
                    );
            $list[] = new Route(
                    "viewArticle",
                    array('articleId')
                    );
            $list[] = new Route(
                    "archive",
                    array()
                    );
            $list[] = new Route(
                    "newUser",
                    array()
                    );
            $list[] = new Route(
                    "editUser",
                    array('userId')
                    );
            $list[] = new Route(
                    "deleteUser",
                    array('userId')
                    );
            $list[] = new Route(
                    "viewUser",
                    array('userId')
                    );
            $list[] = new Route(
                    "users",
                    array()
                    );
            Route::$routeList = $list;
        }
        return Route::$routeList;
    }
    
    /**
     * Возвращаем маршрут для указанного действия.
     * @param string $action
     * @return Route|null
     */
    public static function getRouteForAction($action) {
        $list = Route::getRouteList();
        foreach ($list as $route) {
            if ($route->action == $action) {
                return clone $route;
            }
        }
        return null;
    }
    
    public static function getCurrentRoute() {
        $list = Route::getRouteList();
        $found = false;
        $currentRoute = null;
        $uri = urldecode($_SERVER[ "REQUEST_URI" ]);
        $uri = ltrim($uri, '/');
        // Отсекаем лишние части URL.
        $uriSplitted = explode('#', $uri);
        $uri = $uriSplitted[0];
        $uriSplitted = explode('?', $uri);
        $uri = $uriSplitted[0];
        // Разбираем URL на параметры.
        $uriSplitted = explode('/', $uri);
        $action = array_shift($uriSplitted);
        // Если действие не задано, возвращаем пустой маршрут.
        if (empty($action)) {
            return new Route('', array());
        }
        $userValues = $uriSplitted;
        // Нашли маршрут с подходящим значением "action".
        $currentRoute = Route::getRouteForAction($action);
        if ($currentRoute == null) {
            trigger_error("Route::getCurrentRoute(): Несуществующий маршрут.", E_USER_ERROR);
        }
        // Заполняем значения параметров.
        $currentRoute->validateParams($userValues, false);
        if (!empty($currentRoute->params)) {
            $i = 0;
            foreach ($currentRoute->params as $option) {
                $currentRoute->values[$option] = $userValues[$i];
                $i++;
            }
        }
        return $currentRoute;
    }
    
    /**
     * Перенаправление на указанный маршрут.
     * @param string $action
     * @param array $values
     */
    public static function redirectTo($action = null, array $values = array()) {
        header("Location: " . Route::getUrl($action, $values));
    }
    
    /**
     * Проверяем список пользовательских параметров на соответствие параметрам маршрута.
     * @param array $userValues
     */
    private function validateParams(array $userParams, $checkNames = true) {
        $originalParamsCount = empty($this->params) ? 0 : count($this->params);
        $userParamsCount = empty($userParams) ? 0 : count($userParams);
        if ($originalParamsCount != $userParamsCount) {
            trigger_error("Route::validateParams(): Не совпадает количество параметров для действия ($this->action).", E_USER_ERROR);
        }
        // Для разбора URL, мы проверяем только общее количество параметров.
        // Порядок следования параметров должен совпадать с тем, что указан при создании маршрута.
        if (!$checkNames) {
            return;
        }
        foreach ($this->params as $option) {
            if (!array_key_exists($option, $userParams)) {
                trigger_error("Route::validateParams(): Не задан параметр ($option) для действия ($this->action).", E_USER_ERROR);
            }
        }
    }
}
