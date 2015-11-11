-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Ноя 11 2015 г., 23:14
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

--
-- База данных: `combodb`
--

-- --------------------------------------------------------

--
-- Структура таблицы `articles`
--

CREATE TABLE IF NOT EXISTS `articles` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(255) NOT NULL,
  `content` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=11 ;

--
-- Дамп данных таблицы `articles`
--

INSERT INTO `articles` (`id`, `title`, `content`) VALUES
(9, 'Замечательная статья', '<p>Это самая замечательная статья в мире.</p><p>Она содержит множество полезной информации.</p><p>Посетители сайта приходят в восторг, прочитав эту статью, и сохраняют её себе в закладки.</p>'),
(10, 'Шаганэ', '<p>Шаганэ ты моя, Шаганэ!<br />Потому что я с севера, что ли,<br />Я готов рассказать тебе поле,<br />Про волнистую рожь при луне.<br />Шаганэ ты моя, Шаганэ.</p><p>Потому что я с севера, что ли,<br />Что луна там огромней в сто раз,<br />Как бы ни был красив Шираз,<br />Он не лучше рязанских раздолий.<br />Потому что я с севера, что ли?</p><p>Я готов рассказать тебе поле,<br />Эти волосы взял я у ржи,<br />Если хочешь, на палец вяжи &mdash;<br />Я нисколько не чувствую боли.<br />Я готов рассказать тебе поле.</p><p>Про волнистую рожь при луне<br />По кудрям ты моим догадайся.<br />Дорогая, шути, улыбайся,<br />Не буди только память во мне<br />Про волнистую рожь при луне.</p><p>Шаганэ ты моя, Шаганэ!<br />Там, на севере, девушка тоже,<br />На тебя она страшно похожа,<br />Может, думает обо мне...<br />Шаганэ ты моя, Шаганэ!</p><p><em>1924</em></p>');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE IF NOT EXISTS `users` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `username` varchar(255) NOT NULL,
  `password` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `username`, `password`) VALUES
(1, 'admin', '202cb962ac59075b964b07152d234b70'),
(5, 'test', '098f6bcd4621d373cade4e832627b4f6');
