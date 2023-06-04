-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jun 04, 2023 at 02:30 PM
-- Server version: 10.4.25-MariaDB
-- PHP Version: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `run_together`
--

-- --------------------------------------------------------

--
-- Table structure for table `friendships`
--

CREATE TABLE `friendships` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `friend_id` int(11) NOT NULL,
  `status` varchar(50) NOT NULL DEFAULT 'pending'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `friendships`
--

INSERT INTO `friendships` (`id`, `user_id`, `friend_id`, `status`) VALUES
(1, 2, 1, 'accept'),
(2, 1, 2, 'accept'),
(3, 3, 1, 'pending');

-- --------------------------------------------------------

--
-- Table structure for table `marathons`
--

CREATE TABLE `marathons` (
  `id` int(11) NOT NULL,
  `name` varchar(250) NOT NULL,
  `description` varchar(2500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `marathons`
--

INSERT INTO `marathons` (`id`, `name`, `description`) VALUES
(1, 'İstanbul Marathon 2023', 'Would you like to join our marathon that will be held on July 10, 2023?'),
(2, 'Ankara Marathon 2023', 'Would you like to join our marathon that will be held on July 10, 2023?'),
(3, 'İzmir Marathon 2023', 'Would you like to join our marathon that will be held on July 10, 2023?');

-- --------------------------------------------------------

--
-- Table structure for table `marathon_joins`
--

CREATE TABLE `marathon_joins` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `marathon_joins`
--

INSERT INTO `marathon_joins` (`id`, `user_id`, `post_id`) VALUES
(28, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `messages`
--

CREATE TABLE `messages` (
  `id` int(11) NOT NULL,
  `sender_id` int(11) NOT NULL,
  `receiver_id` int(11) NOT NULL,
  `message` varchar(250) NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `messages`
--

INSERT INTO `messages` (`id`, `sender_id`, `receiver_id`, `message`, `created_at`) VALUES
(4, 1, 2, 'Hello', '2023-06-04 14:24:43'),
(5, 2, 1, 'Hello', '2023-06-04 14:24:52');

-- --------------------------------------------------------

--
-- Table structure for table `run_joins`
--

CREATE TABLE `run_joins` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `post_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `run_post`
--

CREATE TABLE `run_post` (
  `id` int(11) NOT NULL,
  `name` varchar(75) NOT NULL,
  `owner` int(11) NOT NULL,
  `date` date NOT NULL,
  `location` varchar(500) NOT NULL,
  `destination` varchar(500) NOT NULL,
  `description` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `run_post`
--

INSERT INTO `run_post` (`id`, `name`, `owner`, `date`, `location`, `destination`, `description`) VALUES
(4, 'Atalar District Run', 1, '2023-06-04', 'Atalar, ATALAR MERKEZ CAMİİ, Atalar Caddesi, Kartal/İstanbul, Türkiye', 'Orhantepe, Marmara Üniversitesi Dragos Kampüs, Fabrika, Kartal/İstanbul, Türkiye', 'We are going for a run in Atalar District at the weekend, if you want to join us, click the join button!');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `email` varchar(200) NOT NULL,
  `username` varchar(50) NOT NULL,
  `name` varchar(50) NOT NULL,
  `surname` varchar(50) NOT NULL,
  `gender` varchar(30) NOT NULL,
  `birth_date` date NOT NULL,
  `password` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `email`, `username`, `name`, `surname`, `gender`, `birth_date`, `password`) VALUES
(1, 'yusuftrken@gmail.com', 'Yusuf11', 'Yusuf', 'Türken', 'Male', '2002-01-01', 'ef4ce77f8320ccccddd1a7863c195275'),
(2, 'yusuftrkenproje@gmail.com', 'Yusuf34', 'Yusuf', 'Türken', 'Male', '2002-01-26', '93325c4a1921f84133385be4a54d76ff'),
(3, 'yusuftrken1@gmail.com', 'yusuf45', 'Yusuf', 'Türken', 'Male', '2000-01-26', 'ef4ce77f8320ccccddd1a7863c195275');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `friendships`
--
ALTER TABLE `friendships`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marathons`
--
ALTER TABLE `marathons`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `marathon_joins`
--
ALTER TABLE `marathon_joins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `messages`
--
ALTER TABLE `messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `run_joins`
--
ALTER TABLE `run_joins`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `run_post`
--
ALTER TABLE `run_post`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `friendships`
--
ALTER TABLE `friendships`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `marathons`
--
ALTER TABLE `marathons`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `marathon_joins`
--
ALTER TABLE `marathon_joins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=29;

--
-- AUTO_INCREMENT for table `messages`
--
ALTER TABLE `messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `run_joins`
--
ALTER TABLE `run_joins`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `run_post`
--
ALTER TABLE `run_post`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
