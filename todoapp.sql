-- phpMyAdmin SQL Dump
-- version 4.4.12
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 
-- Версия на сървъра: 5.6.25
-- PHP Version: 5.5.27

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `todoapp`
--

-- --------------------------------------------------------

--
-- Структура на таблица `list_of_tasks`
--

CREATE TABLE IF NOT EXISTS `list_of_tasks` (
  `id` int(11) NOT NULL,
  `title` varchar(300) NOT NULL,
  `user_id` int(11) NOT NULL,
  `archived` varchar(20) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=25 DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `list_of_tasks`
--

INSERT INTO `list_of_tasks` (`id`, `title`, `user_id`, `archived`) VALUES
(16, 'List 123', 1, 'archived'),
(18, 'new list', 1, 'archived'),
(21, 'Sport activities', 3, NULL),
(22, 'Other tasks', 3, NULL),
(23, 'Appointments 17 - 23 Oct', 1, NULL);

-- --------------------------------------------------------

--
-- Структура на таблица `task`
--

CREATE TABLE IF NOT EXISTS `task` (
  `id` int(11) NOT NULL,
  `text` varchar(1000) NOT NULL,
  `list_id` int(11) NOT NULL,
  `status` varchar(10) NOT NULL DEFAULT 'open',
  `date_added` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=66 DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `task`
--

INSERT INTO `task` (`id`, `text`, `list_id`, `status`, `date_added`) VALUES
(50, 'task 1234', 16, 'completed', '2016-10-13 15:46:52'),
(54, 'new task between 17 and 23 october', 15, 'completed', '2016-10-13 17:35:51'),
(56, 'fdfdgdfg', 19, 'open', '2016-10-13 18:35:23'),
(57, 'task 123', 18, 'open', '2016-10-13 18:45:18'),
(58, 'fdsfsfsd', 20, 'completed', '2016-10-13 18:56:18'),
(59, 'aewewewew', 20, 'open', '2016-10-13 18:56:21'),
(60, 'Football match on monday', 21, 'open', '2016-10-13 19:27:51'),
(61, 'Tennis with Pesho on sunday', 21, 'open', '2016-10-13 19:28:14'),
(62, 'Buy mom a gift for her birthday', 22, 'open', '2016-10-13 19:29:10'),
(63, 'Go to the dentist on Monday at 6 PM', 23, 'open', '2016-10-13 19:30:28'),
(64, 'Go to the gym on tuesday', 23, 'open', '2016-10-13 22:12:40'),
(65, 'New task', 23, 'open', '2016-10-13 22:14:15');

-- --------------------------------------------------------

--
-- Структура на таблица `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(50) NOT NULL,
  `role` varchar(5) NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

--
-- Схема на данните от таблица `user`
--

INSERT INTO `user` (`id`, `email`, `password`, `role`) VALUES
(1, 'mimi@abv.bg', '1111', 'user'),
(2, 'admin@todoapp.com', 'pass', 'admin'),
(3, 'ivan@gmail.com', '2222', 'user');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `list_of_tasks`
--
ALTER TABLE `list_of_tasks`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `task`
--
ALTER TABLE `task`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `id` (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `list_of_tasks`
--
ALTER TABLE `list_of_tasks`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=25;
--
-- AUTO_INCREMENT for table `task`
--
ALTER TABLE `task`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=66;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=4;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
