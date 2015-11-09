<?php

class Db {
    /**
     * Объект PDO для работы с БД.
     * @return \PDO
     */
    public static function get() {
        return new PDO("mysql:host=localhost;dbname=" . DB_NAME, DB_USER, DB_PASS);
    }
}