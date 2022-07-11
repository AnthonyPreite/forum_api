-- phpMyAdmin SQL Dump
-- version 4.8.3
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jul 11, 2022 at 02:33 PM
-- Server version: 5.7.23
-- PHP Version: 7.2.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `forumticket`
--

-- --------------------------------------------------------

--
-- Table structure for table `ticket`
--

CREATE TABLE `ticket` (
  `id_ticket` int(10) UNSIGNED NOT NULL,
  `id_user` int(11) NOT NULL,
  `ticket_content` text NOT NULL,
  `title` varchar(200) NOT NULL,
  `id_question` int(11) NOT NULL,
  `date` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ticket`
--

INSERT INTO `ticket` (`id_ticket`, `id_user`, `ticket_content`, `title`, `id_question`, `date`) VALUES
(1, 2, 'Idk how to find the book about the necessary skills to be a great president ... Someone can tell me where i can find it in the white house pls ? it\'s so big here ', 'Donald trump can be a great president ?', 1, '2022-07-11');

-- --------------------------------------------------------

--
-- Stand-in structure for view `ticket_user`
-- (See below for the actual view)
--
CREATE TABLE `ticket_user` (
`id_user` int(11)
,`id_ticket` int(10) unsigned
,`ticket_content` text
,`title` varchar(200)
,`id_question` int(11)
,`date` date
,`user_iden` int(10) unsigned
,`name` varchar(200)
,`email` varchar(200)
);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id_user` int(10) UNSIGNED NOT NULL,
  `name` varchar(200) NOT NULL,
  `email` varchar(200) NOT NULL,
  `password` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id_user`, `name`, `email`, `password`) VALUES
(1, 'Barack', 'barackobama@gmail.com', 'presidence'),
(2, 'Donald', 'donaldvschina@gmail.com', 'china');

-- --------------------------------------------------------

--
-- Structure for view `ticket_user`
--
DROP TABLE IF EXISTS `ticket_user`;

CREATE ALGORITHM=UNDEFINED DEFINER=`root`@`localhost` SQL SECURITY DEFINER VIEW `ticket_user`  AS  select `ticket`.`id_user` AS `id_user`,`ticket`.`id_ticket` AS `id_ticket`,`ticket`.`ticket_content` AS `ticket_content`,`ticket`.`title` AS `title`,`ticket`.`id_question` AS `id_question`,`ticket`.`date` AS `date`,`user`.`id_user` AS `user_iden`,`user`.`name` AS `name`,`user`.`email` AS `email` from (`ticket` left join `user` on((`ticket`.`id_user` = `user`.`id_user`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ticket`
--
ALTER TABLE `ticket`
  ADD PRIMARY KEY (`id_ticket`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ticket`
--
ALTER TABLE `ticket`
  MODIFY `id_ticket` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id_user` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
