-- phpMyAdmin SQL Dump
-- version 3.4.10.1deb1
-- http://www.phpmyadmin.net
--
-- Хост: localhost
-- Время создания: Июн 16 2014 г., 14:53
-- Версия сервера: 5.5.37
-- Версия PHP: 5.5.12-2+deb.sury.org~precise+1

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `demoapimovies`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cinema`
--

DROP TABLE IF EXISTS `cinema`;
CREATE TABLE IF NOT EXISTS `cinema` (
  `id_cinema` tinyint(3) unsigned NOT NULL AUTO_INCREMENT,
  `sysname` varchar(100) NOT NULL,
  `title` varchar(100) NOT NULL,
  `description` text NOT NULL,
  PRIMARY KEY (`id_cinema`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `cinema`
--

INSERT INTO `cinema` (`id_cinema`, `sysname`, `title`, `description`) VALUES
(1, 'Movie1Rostov', 'Кинотеатр номер 1', 'Группа компаний «Люксор» – один из лидеров современного российского кинорынка, объединяет ряд компаний по основным направлениям: дистрибьюция, кинопрокат, развитие собственной кинотеатральной сети, производство анимационных фильмов.'),
(2, 'Azov3', 'Кинотеатр номер 2', 'На сегодняшний день, киносеть Чарли представлена 6 кинотеатрами и более 21 зала в 4 городах России: Ростове-на-Дону, Черкесске, Старом Осколе, Таганроге. Общая вместимость залов киносети насчитывает свыше 3000 мест!');

-- --------------------------------------------------------

--
-- Структура таблицы `hall`
--

DROP TABLE IF EXISTS `hall`;
CREATE TABLE IF NOT EXISTS `hall` (
  `id_hall` tinyint(3) unsigned NOT NULL,
  `id_cinema` tinyint(3) unsigned NOT NULL,
  `title` varchar(100) NOT NULL,
  `seats` smallint(6) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id_hall`,`id_cinema`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `hall`
--

INSERT INTO `hall` (`id_hall`, `id_cinema`, `title`, `seats`) VALUES
(1, 1, 'Большой зал', 100),
(1, 2, 'Красный зал', 50),
(2, 1, 'Малый зал', 30);

-- --------------------------------------------------------

--
-- Структура таблицы `movie`
--

DROP TABLE IF EXISTS `movie`;
CREATE TABLE IF NOT EXISTS `movie` (
  `id_movie` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `title` varchar(100) NOT NULL,
  `year` char(4) NOT NULL,
  PRIMARY KEY (`id_movie`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `movie`
--

INSERT INTO `movie` (`id_movie`, `title`, `year`) VALUES
(1, 'Малефисента', '2014'),
(2, 'Люди-Икс: Дни минувшего будущего ', '2014');

-- --------------------------------------------------------

--
-- Структура таблицы `session`
--

DROP TABLE IF EXISTS `session`;
CREATE TABLE IF NOT EXISTS `session` (
  `id_session` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_movie` int(10) unsigned NOT NULL,
  `id_cinema` tinyint(3) unsigned NOT NULL,
  `id_hall` tinyint(3) unsigned NOT NULL,
  `start_date` datetime NOT NULL,
  `status` enum('waiting','active','suspended','done') NOT NULL DEFAULT 'waiting',
  PRIMARY KEY (`id_session`),
  KEY `id_theater` (`id_cinema`,`id_hall`,`start_date`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `session`
--

INSERT INTO `session` (`id_session`, `id_movie`, `id_cinema`, `id_hall`, `start_date`, `status`) VALUES
(1, 1, 1, 1, '2014-06-08 18:00:00', 'waiting'),
(2, 1, 2, 1, '2014-06-10 21:00:00', 'waiting'),
(3, 2, 1, 2, '2014-06-11 19:00:00', 'waiting'),
(4, 1, 1, 1, '2014-06-16 18:00:00', 'waiting'),
(5, 1, 2, 1, '2014-06-16 21:00:00', 'waiting'),
(6, 2, 1, 1, '2014-06-16 22:00:00', 'waiting'),
(7, 2, 1, 2, '2014-06-16 23:00:00', 'waiting');

-- --------------------------------------------------------

--
-- Структура таблицы `session_seat`
--

DROP TABLE IF EXISTS `session_seat`;
CREATE TABLE IF NOT EXISTS `session_seat` (
  `id_session` int(10) unsigned NOT NULL,
  `seat` smallint(5) unsigned NOT NULL,
  `id_ticket` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id_session`,`seat`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `ticket`
--

DROP TABLE IF EXISTS `ticket`;
CREATE TABLE IF NOT EXISTS `ticket` (
  `id_ticket` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `code` varchar(24) NOT NULL,
  `id_session` int(10) unsigned NOT NULL,
  `created` datetime NOT NULL,
  `status` enum('active','reject') NOT NULL,
  PRIMARY KEY (`id_ticket`),
  UNIQUE KEY `Code` (`code`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=16 ;

--
-- Дамп данных таблицы `ticket`
--

INSERT INTO `ticket` (`id_ticket`, `code`, `id_session`, `created`, `status`) VALUES
(1, '3kIjXhEG', 4, '2014-06-11 11:38:07', 'active'),
(3, 'NGIOX', 4, '2014-06-11 11:41:31', 'active'),
(4, 'yLIO8tWW', 4, '2014-06-11 11:42:26', 'active'),
(5, 'OLI5HOFR', 4, '2014-06-11 11:43:34', 'active'),
(6, '3kIDwSPZ', 4, '2014-06-11 11:57:38', 'active'),
(7, 'AnIo', 3, '2014-06-11 11:58:07', 'active'),
(8, 'R5IrcPSV', 5, '2014-06-11 11:58:51', 'active'),
(9, 'OLIJHJ', 5, '2014-06-11 12:02:34', 'active'),
(10, 'nKIDHjF0c3', 5, '2014-06-11 12:03:11', 'active'),
(11, 'zjIxHdFrcXS0TZfA', 5, '2014-06-11 12:03:17', 'active'),
(12, 'd1IJt5', 3, '2014-06-11 12:04:41', 'active'),
(13, '4GIYcGS7IXU1h5', 3, '2014-06-11 12:04:47', 'active'),
(14, 'zjIjCP', 3, '2014-06-11 12:05:01', 'active'),
(15, 'NGIRu4', 4, '2014-06-11 12:13:25', 'active');

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
