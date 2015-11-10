<?php

// Файл настроек хоста.

// Включаем отображение ошибок.
// Отключить в продакшене!
ini_set("display_errors", true);

// Кодировка.
header('Content-type: text/html; charset=utf-8');

// Настройки хоста.
define("DB_USER", "combouser");
define("DB_NAME", "combodb");
define("DB_PASS", "combopass");
define("LIBRARY_PATH", "../library/");

// Основные папки движка.
define("CLASS_PATH", LIBRARY_PATH . "classes");
define("TEMPLATE_PATH", LIBRARY_PATH . "templates");

// Строковые константы.
define("SITE_NAME", "Combo CMS");
define("AUTHOR_NAME", "Nex Otaku");

// Загружаем классы движка.
require(CLASS_PATH . "/Article.php");
require(CLASS_PATH . "/Db.php");
require(CLASS_PATH . "/Menu.php");
require(CLASS_PATH . "/Notification.php");
require(CLASS_PATH . "/Route.php");
require(CLASS_PATH . "/User.php");

// Обработчик ошибок.
function handleException($exception) {
    ?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>Ошибка</title>
</head>
<body><?php
    echo "error Произошла ошибка. Перезагрузите страницу.";
    error_log($exception->getMessage());
}

set_exception_handler('handleException');
