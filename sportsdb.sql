-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Dec 07, 2016 at 03:19 AM
-- Server version: 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sportsdb`
--

-- --------------------------------------------------------

--
-- Table structure for table `events`
--

CREATE TABLE `events` (
  `id` int(11) NOT NULL,
  `title` varchar(100) NOT NULL,
  `creationTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `ownerId` int(11) NOT NULL,
  `ownerName` varchar(50) NOT NULL,
  `participantCount` int(11) DEFAULT NULL,
  `description` varchar(500) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL,
  `city` varchar(50) DEFAULT NULL,
  `state` varchar(30) DEFAULT NULL,
  `zip` int(12) DEFAULT NULL,
  `country` varchar(30) DEFAULT NULL,
  `closedDate` timestamp NULL DEFAULT NULL,
  `tags` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `events`
--

INSERT INTO `events` (`id`, `title`, `creationTime`, `ownerId`, `ownerName`, `participantCount`, `description`, `address`, `city`, `state`, `zip`, `country`, `closedDate`, `tags`) VALUES
(1, 'Intra Mural', '2016-12-10 15:00:00', 1, 'Rasagna Veeramallu', 20, 'Intra Murals held twice every quater', 'Werblin', 'New Brunswick', 'New Jersey', 8901, 'USA', '2016-12-11 15:00:00', '<Football>'),
(2, 'Club Games', '2016-12-07 02:58:38', 3, 'Abhijith Talakola', 10, 'Badminton club meets every Wednesday', 'Werblin Recreational Center', 'Piscataway', 'New Jersey', 8901, 'USA', '2016-12-15 00:00:00', '<badminton>'),
(3, 'Cricket', '2016-12-17 18:00:00', 4, 'Bharath Joginapally', 13, 'Cricket every Sunday', 'Buccleuch Park', 'New Brunswick', 'New Jersey', 8901, 'USA', '2016-12-17 23:00:00', '<cricket>'),
(4, 'Soccer', '2016-12-15 20:00:00', 2, 'Aditya Vikas Devarapalli', 10, 'Play Soccer every wednesday', 'Buccleuch Park', 'New Brunswick', 'New Jersey', 8901, 'USA', '2016-12-16 02:00:00', '<soccer>'),
(5, 'Basket Ball Club Game', '2016-12-23 20:00:00', 3, 'Abhijith Talakola', 12, 'Basketball club meets every thursday at Werblin recreational center', 'Werblin Recreational Center', 'New Brunswick', 'New Jersey', 8901, 'USA', '2016-12-16 01:00:00', '<basketball>'),
(6, 'Children Recreation', '2016-12-15 12:09:26', 1, 'Rasagna Veeramallu', 11, 'Fun for children and parents', 'Bucclech Park', 'New Brunswick', 'New Jersey', 8901, 'USA', '2016-12-16 05:00:00', '<Baseball>'),
(7, 'Disabled Tennis Matches', '2016-12-21 14:00:00', 2, 'Aditya Vikas Devarapalli', 8, 'Tennis matches for disabled', 'Bucclech Park', 'New Brunswick', 'New Jersey', 8901, 'USA', '2016-12-22 05:00:00', '<Tennis>'),
(8, 'Racket ball Meetup', '2016-12-27 20:21:35', 3, 'Abhijith Talakola', 8, 'Play for fun', 'Bucclech', 'New Brunswick', 'New Jersey', 8901, 'USA', '2016-12-29 05:00:00', '<RacketBall>'),
(9, 'Gym training 101', '2016-12-14 14:37:17', 4, 'Bharath Joginapally', 40, 'Event to learn about gym exercises', 'Werblin Recreational Center', 'New Brunswick', 'New Jersey', 8901, 'USA', '2016-12-15 13:35:18', '<Gym>'),
(10, 'Swimming Training', '2016-12-15 14:23:25', 1, 'Rasagna Veeramallu', 35, 'Learning Swimming', 'Werblin Recreational Center', 'New Brunswick', 'New Jersey', 8901, 'USA', '2016-12-15 17:44:51', '<Swimming>');

-- --------------------------------------------------------

--
-- Table structure for table `event_attendees`
--

CREATE TABLE `event_attendees` (
  `userId` int(11) NOT NULL,
  `eventId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `tags`
--

CREATE TABLE `tags` (
  `tagId` int(11) NOT NULL,
  `tag` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(50) NOT NULL,
  `passwordHash` varchar(400) NOT NULL,
  `creationTime` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `displayName` varchar(50) NOT NULL,
  `lastAccessDate` timestamp NULL DEFAULT NULL,
  `location` varchar(200) DEFAULT NULL,
  `totalEventsHosted` int(10) NOT NULL DEFAULT '0',
  `totalEventsAttended` int(10) NOT NULL DEFAULT '0',
  `age` int(11) DEFAULT NULL,
  `aboutMe` varchar(500) DEFAULT NULL,
  `reputation` int(11) NOT NULL DEFAULT '0',
  `tags` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `passwordHash`, `creationTime`, `displayName`, `lastAccessDate`, `location`, `totalEventsHosted`, `totalEventsAttended`, `age`, `aboutMe`, `reputation`, `tags`) VALUES
(1, 'rasagna.v@gmail.com', '', '2016-12-07 02:45:27', 'Rasagna Veeramallu', NULL, 'New Brunswick, New Jersey', 0, 0, 24, NULL, 0, '<soccer>'),
(2, 'adityavikasdav@gmail.com', '', '2016-12-07 02:46:55', 'Aditya Vikas Devarapalli', NULL, 'New Brunswick, New Jersey', 0, 0, 23, NULL, 0, '<cricket>'),
(3, 'tabhi816@gmail.com', '', '2016-12-07 02:47:47', 'Abhijith Talakola', NULL, 'New Brunswick, New Jersey', 0, 0, 25, NULL, 0, '<badmintion>'),
(4, 'bharath.jjj@gmail.com', '', '2016-12-07 02:48:27', 'Bharath Joginapally', NULL, 'New Brunswick', 0, 0, 25, NULL, 0, '<football>');

-- --------------------------------------------------------

--
-- Table structure for table `user_tags`
--

CREATE TABLE `user_tags` (
  `userId` int(11) NOT NULL,
  `tagId` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `events`
--
ALTER TABLE `events`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ownerId` (`ownerId`) USING BTREE;

--
-- Indexes for table `event_attendees`
--
ALTER TABLE `event_attendees`
  ADD PRIMARY KEY (`userId`,`eventId`),
  ADD UNIQUE KEY `eventId` (`eventId`);

--
-- Indexes for table `tags`
--
ALTER TABLE `tags`
  ADD PRIMARY KEY (`tagId`),
  ADD UNIQUE KEY `name` (`tag`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `user_tags`
--
ALTER TABLE `user_tags`
  ADD PRIMARY KEY (`userId`,`tagId`),
  ADD KEY `TagsTagIdFK` (`tagId`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `events`
--
ALTER TABLE `events`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=18;
--
-- AUTO_INCREMENT for table `tags`
--
ALTER TABLE `tags`
  MODIFY `tagId` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;
--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
--
-- Constraints for dumped tables
--

--
-- Constraints for table `events`
--
ALTER TABLE `events`
  ADD CONSTRAINT `EventsUserIdFK` FOREIGN KEY (`ownerId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `event_attendees`
--
ALTER TABLE `event_attendees`
  ADD CONSTRAINT `AttendeesEventIdFK` FOREIGN KEY (`eventId`) REFERENCES `events` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `AttendeesUserIdFK` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `user_tags`
--
ALTER TABLE `user_tags`
  ADD CONSTRAINT `TagsTagIdFK` FOREIGN KEY (`tagId`) REFERENCES `tags` (`tagId`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `TagsUserIdFK` FOREIGN KEY (`userId`) REFERENCES `users` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
