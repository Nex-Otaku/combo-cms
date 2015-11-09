DROP TABLE IF EXISTS articles;
CREATE TABLE articles
(
  id              int unsigned NOT NULL auto_increment,
  title           varchar(255) NOT NULL,                      # Заголовок
  content         text NOT NULL,                              # Текст статьи

  PRIMARY KEY     (id)
);

DROP TABLE IF EXISTS users;
CREATE TABLE users
(
  id              int unsigned NOT NULL auto_increment,
  username           varchar(255) NOT NULL,                   # Имя пользователя
  password           varchar(32) NOT NULL,                    # Пароль

  PRIMARY KEY     (id)
);
