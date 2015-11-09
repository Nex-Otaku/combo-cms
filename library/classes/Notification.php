<?php

class Notification {
    /**
     * Сохраняем сообщение об ошибке в объекте сессии.
     * @param string $message
     */
    public static function setError($message) {
        $_SESSION['error'] = $message;
    }
    
    /**
     * Сохраняем сообщение системы в объекте сессии.
     * @param string $message
     */
    public static function setStatus($message) {
        $_SESSION['status'] = $message;
    }
    
    /**
     * Есть ли сообщение об ошибке.
     * @return bool
     */
    public static function hasError() {
        return isset($_SESSION['error']);
    }
    
    /**
     * Есть ли системное сообщение.
     * @return bool
     */
    public static function hasStatus() {
        return isset($_SESSION['status']);
    }
    
    /**
     * Извлекаем сообщение об ошибке из объекта сессии.
     * @return string
     */
    public static function getError() {
        if (!isset($_SESSION['error'])) {
            return '';
        }
        $error = $_SESSION['error'];
        unset($_SESSION['error']);
        
        $message = "";
        switch ($error) {
            case "articleNotFound":
                $message = "Ошибка: Статья не найдена.";
                break;
            case "articleDeleted":
                $message = "Статья удалена.";
                break;
            case "wrongPassword":
                $message = "Неправильное имя пользователя или пароль. Попробуйте ещё раз.";
                break;
            case "emptyPassword":
                $message = "Необходимо задать пароль для нового пользователя.";
                break;
            default:
                $message = "Неизвестный тип ошибки! Проверьте код.";
                break;
        }
        
        return $message;
    }
    
    /**
     * Извлекаем сообщение системы из объекта сессии.
     * @return string
     */
    public static function getStatus() {
        if (!isset($_SESSION['status'])) {
            return '';
        }
        $status = $_SESSION['status'];
        unset($_SESSION['status']);
        
        $message = "";
        switch ($status) {
            case "changesSaved":
                $message = "Изменения сохранены.";
                break;
            case "articleDeleted":
                $message = "Статья удалена.";
                break;
            case "userDeleted":
                $message = "Пользователь удалён.";
                break;
        }
        
        return $message;
    }
}