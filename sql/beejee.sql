-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1
-- Время создания: Июл 19 2020 г., 20:25
-- Версия сервера: 10.4.11-MariaDB
-- Версия PHP: 7.4.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `beejee`
--
CREATE DATABASE IF NOT EXISTS `beejee` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci;
USE `beejee`;

-- --------------------------------------------------------

--
-- Структура таблицы `list_tasks`
--

CREATE TABLE `list_tasks` (
  `id` int(11) NOT NULL,
  `name_user` varchar(50) DEFAULT NULL,
  `e_mail` varchar(50) DEFAULT NULL,
  `text_task` text DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `login` varchar(20) NOT NULL,
  `hash_pass` varchar(100) NOT NULL,
  `role` int(10) UNSIGNED NOT NULL,
  `access` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `login`, `hash_pass`, `role`, `access`) VALUES
(1, 'admin', '$2y$10$Ko93.UHZHQiSbHfcva7yGu/S.IfD85VSdDadqJfwKVxwxDwDhwPPC', 1, 1);

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `list_tasks`
--
ALTER TABLE `list_tasks`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `list_tasks`
--
ALTER TABLE `list_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
