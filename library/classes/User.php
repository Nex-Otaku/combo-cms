<?php

class User {
    public $id;
    public $username;
    
    public function __construct($data = array()) {
        if (isset($data['id']))
            $this->id = (int) $data['id'];
        if (isset($data['username']))
            $this->username = $data['username'];
    }
    
    public static function get() {
        $user = isset($_SESSION['user']) ? $_SESSION['user'] : new User();
        return $user;
    }
    
    public static function isLoggedIn() {
        return !empty(User::get()->username);
    }
    
    public static function getList() {
        $db = Db::get();
        $sql = "SELECT id, username FROM users
            ORDER BY id";

        $st = $db->query($sql);
        $list = array();

        while ($row = $st->fetch()) {
            $user = new User($row);
            $list[] = $user;
        }
        return $list;
    }
    
    /**
     * Пытаемся выполнить вход в систему.
     * @param string $username
     * @param string $password
     * @return bool Успешный вход
     */
    public static function login($username, $password) {
        $db = Db::get();
        $sql = "SELECT id, username FROM users WHERE username = :username AND password = :password";
        $st = $db->prepare($sql);
        $st->bindValue(":username", $username, PDO::PARAM_STR);
        $st->bindValue(":password", md5($password), PDO::PARAM_STR);
        $st->execute();
        $row = $st->fetch();
        if (!$row) {
            return false;
        }
        
        // Успешная авторизация: сохраняем данные в сессии и отправляем пользователя на главную страницу.
        $_SESSION['user'] = new User($row);
        return true;
    }
    
    /**
     * Выход из системы.
     */
    public static function logout() {
        unset($_SESSION['user']);
    }

    /**
     * Заполняем объект пользователя согласно данным формы.
     *
     * @param assoc Данные формы
     */
    public function storeFormValues($params) {
        // Обрабатываем параметры.
        $this->__construct($params);
    }
    
    /**
     * Возвращаем объект пользователя по значению ID
     *
     * @param int ID пользователя
     * @return User|false Пользователь, либо "false" если пользователь не найден или произошла другая ошибка
     */
    public static function getById($id) {
        $db = Db::get();
        $sql = "SELECT id, username FROM users WHERE id = :id";
        $st = $db->prepare($sql);
        $st->bindValue(":id", $id, PDO::PARAM_INT);
        $st->execute();
        $row = $st->fetch();
        if ($row) {
            return new User($row);
        }
    }
    
    /**
     * Создаём запись в БД и устанавливаем ID пользователя.
     */
    public function insert($password) {
        // Есть ли у пользователя ID?
        if (!is_null($this->id)) {
            trigger_error("User::insert(): Попытка создать пользователя, у которого уже есть ID ($this->id).", E_USER_ERROR);
        }
        
        // Создаём пользователя.
        $db = Db::get();
        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";
        $st = $db->prepare($sql);
        $st->bindValue(":username", $this->username, PDO::PARAM_STR);
        $st->bindValue(":password", md5($password), PDO::PARAM_STR);
        if (!$st->execute()) {
            trigger_error("User::insert(): Ошибка при записи в БД. " 
                    . implode(":", $st->errorInfo()) 
                    . " Запрос: " . $st->queryString, 
                    E_USER_ERROR);
        }
        $this->id = $db->lastInsertId();
    }

    /**
     * Обновляем пользователя в БД.
     */
    public function update($password = null) {
        // Есть ли у пользователя ID?
        if (is_null($this->id)) {
            trigger_error("User::update(): Попытка обновить статью без ID.", E_USER_ERROR);
        }

        // Обновляем пользователя.
        $db = Db::get();
        $hasPassword = !empty($password);
        $sql = "UPDATE users SET username=:username"
                . ($hasPassword ? ", password=:password" : "")
                ." WHERE id = :id";
        $st = $db->prepare($sql);
        $st->bindValue(":username", $this->username, PDO::PARAM_STR);
        if (!empty($password)) {
            $st->bindValue(":password", md5($password), PDO::PARAM_STR);
        }
        $st->bindValue(":id", $this->id, PDO::PARAM_INT);
        $st->execute();
    }

    /**
     * Удаляем пользователя из БД.
     */
    public function delete() {
        // Есть ли у пользователя ID?
        if (is_null($this->id)) {
            trigger_error("User::delete(): Попытка удалить пользователя без ID.", E_USER_ERROR);
        }

        // Удаляем пользователя.
        $db = Db::get();
        $st = $db->prepare("DELETE FROM users WHERE id = :id");
        $st->bindValue(":id", $this->id, PDO::PARAM_INT);
        $st->execute();
    }
}