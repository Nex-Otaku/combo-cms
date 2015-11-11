<?php

// Устанавливаем переменные окружения.
require 'setup.php';

// Сессия нужна для хранения данных авторизации, а также системных сообщений.
session_start();

// Определяем действие для текущего маршрута.
$route = Route::getCurrentRoute();
$action = $route->action;

// Проверяем авторизацию.
// Если пользователь не авторизован, выводим форму авторизации.
if ($action != "login" && $action != "logout" && !User::isLoggedIn()) {
    login();
    exit;
}

switch ($action) {
    case 'login':
        login();
        break;
    case 'logout':
        logout();
        break;
    case 'newArticle':
        newArticle();
        break;
    case 'editArticle':
        editArticle();
        break;
    case 'deleteArticle':
        deleteArticle();
        break;
    case 'viewArticle':
        viewArticle();
        break;
    case 'archive':
        archive();
        break;
    case 'newUser':
        newUser();
        break;
    case 'editUser':
        editUser();
        break;
    case 'deleteUser':
        deleteUser();
        break;
    case 'viewUser':
        viewUser();
        break;
    case 'users':
        users();
        break;
    default:
        homepage();
}

function login() {

    $results = array();
    $results['pageTitle'] = "Вход";

    if (isset($_POST['login'])) {

        // Пользователь отправил данные через форму авторизации, пытается войти в систему.

        if (User::login($_POST['username'], $_POST['password'])) {
            // Успешная авторизация: отправляем пользователя на главную страницу.
            Route::redirectTo();
        } else {

            // Авторизация не прошла: показываем сообщение об ошибке
            Notification::setError('wrongPassword');
            require( TEMPLATE_PATH . "/loginForm.php" );
        }
    } else {

        // Пользователь не отправил данные: показываем форму авторизации.
        require( TEMPLATE_PATH . "/loginForm.php" );
    }
}

function logout() {
    User::logout();
    Route::redirectTo();
}

function newArticle() {

    $results = array();
    $results['pageTitle'] = "Новая статья";
    $results['formAction'] = "newArticle";
    $results['formActionParams'] = array();

    if (isset($_POST['saveChanges'])) {

        // Пользователь заполнил форму ввода статьи: сохраняем новую статью.
        $article = new Article();
        $article->storeFormValues($_POST);
        $article->insert();
        //header("Location: index.php?action=archive&status=changesSaved");
        Notification::setStatus('changesSaved');
        Route::redirectTo('archive');
    } elseif (isset($_POST['cancel'])) {

        // Пользователь отменил правку. Возвращаемся в список статей.
        Route::redirectTo('archive');
    } else {

        // Пользователь ещё не отправил форму. Показываем форму.
        $results['article'] = new Article();
        require( TEMPLATE_PATH . "/editArticle.php" );
    }
}

function editArticle() {

    $results = array();
    $results['pageTitle'] = "Редактирование статьи";
    $route = Route::getCurrentRoute();
    $results['formAction'] = $route->action;
    $results['formActionParams'] = $route->values;

    if (isset($_POST['saveChanges'])) {

        // Пользователь заполнил форму ввода статьи: сохраняем правки в статье.

        if (!$article = Article::getById((int) $_POST['articleId'])) {
            //header("Location: index.php?error=articleNotFound");
            Notification::setError('articleNotFound');
            Route::redirectTo();
            return;
        }

        $article->storeFormValues($_POST);
        $article->update();
        Notification::setStatus('changesSaved');
        Route::redirectTo('archive');
    } elseif (isset($_POST['cancel'])) {

        // Пользователь отменил правку. Возвращаемся в список статей.
        Route::redirectTo('archive');
    } else {

        // Пользователь ещё не отправил форму. Показываем форму.
        $results['article'] = Article::getById((int) Route::getCurrentRoute()->values['articleId']);
        require( TEMPLATE_PATH . "/editArticle.php" );
    }
}

function deleteArticle() {

    if (!$article = Article::getById((int) Route::getCurrentRoute()->values['articleId'])) {
        Notification::setError('articleNotFound');
        Route::redirectTo();
        return;
    }

    $article->delete();
    Notification::setStatus('articleDeleted');
    Route::redirectTo('archive');
}

function viewArticle() {
    if (!isset(Route::getCurrentRoute()->values["articleId"]) || !Route::getCurrentRoute()->values["articleId"]) {
        homepage();
        return;
    }

    $results = array();
    $results['article'] = Article::getById((int) Route::getCurrentRoute()->values["articleId"]);
    $results['pageTitle'] = $results['article']->getTitle();
    require( TEMPLATE_PATH . "/viewArticle.php" );
}

function archive() {
    $results = array();
    $data = Article::getList();
    $results['articles'] = $data['results'];
    $results['totalRows'] = $data['totalRows'];
    $results['pageTitle'] = "Список статей";

    require( TEMPLATE_PATH . "/archive.php" );
}

function newUser() {

    $results = array();
    $results['pageTitle'] = "Новый пользователь";
    $results['formAction'] = "newUser";
    $results['formActionParams'] = array();

    if (isset($_POST['saveChanges'])) {

        // Пользователь заполнил форму ввода: сохраняем нового пользователя.
        $user = new User();
        $user->storeFormValues($_POST);
        
        $password = isset($_POST['password']) ? $_POST['password'] : null;
        if (empty($password)) {
            // Пароль обязателен.
            Notification::setError('emptyPassword');
            $results['user'] = $user;
            require( TEMPLATE_PATH . "/editUser.php" );
            return;
        }
        
        $user->insert($password);
        Notification::setStatus('changesSaved');
        Route::redirectTo('users');
    } elseif (isset($_POST['cancel'])) {

        // Пользователь отменил правку. Возвращаемся в список пользователей.
        Route::redirectTo('users');
    } else {

        // Пользователь ещё не отправил форму. Показываем форму.
        $results['user'] = new User();
        require( TEMPLATE_PATH . "/editUser.php" );
    }
}

function editUser() {

    $results = array();
    $results['pageTitle'] = "Редактирование пользователя";
    $route = Route::getCurrentRoute();
    $results['formAction'] = $route->action;
    $results['formActionParams'] = $route->values;

    if (isset($_POST['saveChanges'])) {

        // Пользователь заполнил форму ввода: сохраняем правки.

        if (!$user = User::getById((int) $_POST['userId'])) {
            Notification::setError('userNotFound');
            Route::redirectTo();
            return;
        }

        $password = isset($_POST['password']) ? $_POST['password'] : null;
        
        $user->storeFormValues($_POST);
        $user->update($password);
        Notification::setStatus('changesSaved');
        Route::redirectTo('users');
    } elseif (isset($_POST['cancel'])) {

        // Пользователь отменил правку. Возвращаемся в список пользователей.
        Route::redirectTo('users');
    } else {

        // Пользователь ещё не отправил форму. Показываем форму.
        $results['user'] = User::getById((int) Route::getCurrentRoute()->values['userId']);
        require( TEMPLATE_PATH . "/editUser.php" );
    }
}

function deleteUser() {

    if (!$user = User::getById((int) Route::getCurrentRoute()->values['userId'])) {
        Notification::setError('userNotFound');
        Route::redirectTo();
        return;
    }

    $user->delete();
    Notification::setStatus('userDeleted');
    Route::redirectTo('users');
}

function viewUser() {
    if (!isset(Route::getCurrentRoute()->values["userId"]) || !Route::getCurrentRoute()->values["userId"]) {
        homepage();
        return;
    }

    $results = array();
    $results['user'] = User::getById((int) Route::getCurrentRoute()->values["userId"]);
    $results['pageTitle'] = 'Пользователь ' . $results['user']->username;
    require( TEMPLATE_PATH . "/viewUser.php" );
}

function users() {
    $results = array();
    $results['users'] = User::getList();
    $results['pageTitle'] = "Список пользователей";

    require( TEMPLATE_PATH . "/users.php" );
}

function homepage() {
    $results = array();
    $data = Article::getList(HOMEPAGE_NUM_ARTICLES);
    $results['articles'] = $data['results'];
    $results['totalRows'] = $data['totalRows'];
    $results['pageTitle'] = "Главная";

    require( TEMPLATE_PATH . "/homepage.php" );
}
