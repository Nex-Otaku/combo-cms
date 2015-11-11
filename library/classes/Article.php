<?php

/**
 * Статьи.
 */
class Article {
    /**
     * @var int ID статьи
     */
    public $id = null;

    /**
     * @var string Заголовок
     */
    private $title = null;

    /**
     * @var string Содержимое
     */
    public $content = null;

    /**
     * Создаём объект статьи согласно параметрам
     *
     * @param assoc Параметры статьи
     */
    public function __construct($data = array()) {
        if (isset($data['id']))
            $this->id = (int) $data['id'];
        if (isset($data['title']))
            $this->title = $data['title'];
        if (isset($data['content']))
            $this->content = $data['content'];
    }

    /**
     * Заполняем объект статьи согласно данным формы.
     *
     * @param assoc Данные формы
     */
    public function storeFormValues($params) {
        // Обрабатываем параметры.
        $this->__construct($params);
    }

    /**
     * Возвращаем объект статьи по значению ID
     *
     * @param int ID статьи
     * @return Article|false Статья, либо "false" если статья не найдена или произошла другая ошибка
     */
    public static function getById($id) {
        $db = Db::get();
        $sql = "SELECT * FROM articles WHERE id = :id";
        $st = $db->prepare($sql);
        $st->bindValue(":id", $id, PDO::PARAM_INT);
        $st->execute();
        $row = $st->fetch();
        if ($row) {
            return new Article($row);
        }
    }

    /**
     * Возвращаем набор статей.
     *
     * @param int Optional Сколько статей вернуть. По умолчанию - все.
     * @return Array|false Массив: results => array, список объектов статей; totalRows => количество статей
     */
    public static function getList($numRows = 1000000) {
        $db = Db::get();
        $sql = "SELECT SQL_CALC_FOUND_ROWS * FROM articles
            ORDER BY id LIMIT :numRows";

        $st = $db->prepare($sql);
        $st->bindValue(":numRows", $numRows, PDO::PARAM_INT);
        $st->execute();
        $list = array();

        while ($row = $st->fetch()) {
            $article = new Article($row);
            $list[] = $article;
        }

        // Запрашиваем количество статей
        $sql = "SELECT FOUND_ROWS() AS totalRows";
        $totalRows = $db->query($sql)->fetch();
        return ( array("results" => $list, "totalRows" => $totalRows[0]) );
    }

    /**
     * Создаём запись в БД и устанавливаем ID статьи.
     */
    public function insert() {
        // Есть ли у статьи ID?
        if (!is_null($this->id)) {
            trigger_error("Article::insert(): Попытка создать статью, у которой уже есть ID ($this->id).", E_USER_ERROR);
        }

        // Создаём статью.
        $db = Db::get();
        $sql = "INSERT INTO articles (title, content) VALUES (:title, :content)";
        $st = $db->prepare($sql);
        $st->bindValue(":title", $this->title, PDO::PARAM_STR);
        $st->bindValue(":content", $this->content, PDO::PARAM_STR);
        $st->execute();
        $this->id = $db->lastInsertId();
    }

    /**
     * Обновляем статью в БД.
     */
    public function update() {
        // Есть ли у статьи ID?
        if (is_null($this->id)) {
            trigger_error("Article::update(): Попытка обновить статью без ID.", E_USER_ERROR);
        }

        // Обновляем статью.
        $db = Db::get();
        $sql = "UPDATE articles SET title=:title, content=:content WHERE id = :id";
        $st = $db->prepare($sql);
        $st->bindValue(":title", $this->title, PDO::PARAM_STR);
        $st->bindValue(":content", $this->content, PDO::PARAM_STR);
        $st->bindValue(":id", $this->id, PDO::PARAM_INT);
        $st->execute();
    }

    /**
     * Удаляем статью из БД.
     */
    public function delete() {
        // Есть ли у статьи ID?
        if (is_null($this->id)) {
            trigger_error("Article::delete(): Попытка удалить статью без ID.", E_USER_ERROR);
        }

        // Удаляем статью.
        $db = Db::get();
        $st = $db->prepare("DELETE FROM articles WHERE id = :id");
        $st->bindValue(":id", $this->id, PDO::PARAM_INT);
        $st->execute();
    }
    
    public function getTitle() {
        return htmlspecialchars($this->title);
    }
}
