-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: localhost:8889
-- Generation Time: Jun 01, 2023 at 10:34 PM
-- Server version: 5.7.39
-- PHP Version: 8.2.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `foraging_map`
--

-- --------------------------------------------------------

--
-- Table structure for table `spots`
--

CREATE TABLE `spots` (
  `spot_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type_id` int(11) NOT NULL,
  `creation_date` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `lat_coord` varchar(50) NOT NULL,
  `lon_coord` varchar(50) NOT NULL,
  `description` varchar(3000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `spots`
--

INSERT INTO `spots` (`spot_id`, `user_id`, `type_id`, `creation_date`, `lat_coord`, `lon_coord`, `description`) VALUES
(9, 7, 2, '2023-05-29 22:39:23', '57.738330124763706', '14.144876003265383', 'Chestnut tree'),
(10, 5, 13, '2023-05-31 14:06:07', '59.355596110016315', '13.359375000000002', 'bluuuu'),
(11, 7, 9, '2023-05-31 14:29:19', '-13.2399454992863', '-50.62500000000001', 'brasiliaaa'),
(12, 7, 18, '2023-05-31 14:32:36', '66.08936427047088', '121.64062500000001', 'jgjh'),
(13, 5, 10, '2023-05-31 14:34:26', '61.77312286453146', '75.93750000000001', ''),
(14, 5, 1, '2023-05-31 14:44:29', '57.75125917740919', '14.14318084716797', 'Big tree, low hanging fruit'),
(15, 7, 20, '2023-05-31 15:01:11', '39.103955972576166', '-107.9542350769043', 'adited'),
(16, 5, 12, '2023-05-31 15:47:19', '35.17380831799959', '-105.11718750000001', ''),
(18, 7, 19, '2023-06-01 21:52:59', '-27.371767300523032', '138.16406250000003', ''),
(19, 6, 17, '2023-06-01 22:16:05', '58.63121664342478', '-106.32775011996162', '');

-- --------------------------------------------------------

--
-- Table structure for table `types`
--

CREATE TABLE `types` (
  `type_id` int(11) NOT NULL,
  `trefle_id` int(10) NOT NULL,
  `common_name` varchar(255) NOT NULL,
  `scientific_name` varchar(255) NOT NULL,
  `image_url` varchar(3000) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `types`
--

INSERT INTO `types` (`type_id`, `trefle_id`, `common_name`, `scientific_name`, `image_url`) VALUES
(1, 265263, 'Apple', 'Malus domestica', 'https://bs.plantnet.org/image/o/a42b6ba0beea54fbba5aaec0c785ac52ad3440c0'),
(2, 111017, 'European blueberry', 'Vaccinium myrtillus', NULL),
(9, 208447, 'Brazilnut', 'Bertholletia excelsa', NULL),
(10, 267005, 'Russian almond', 'Prunus tenella', NULL),
(11, 262162, 'Small-flower sweetbriar', 'Rosa micrantha', NULL),
(12, 267839, 'Thorn-apple', 'Datura stramonium', NULL),
(13, 8611, 'Fox-and-cubs', 'Pilosella aurantiaca', NULL),
(14, 245788, 'Australian bugle', 'Ajuga australis', NULL),
(15, 48345, 'Australian blackwood', 'Acacia melanoxylon', NULL),
(16, 21381, 'Sunflower', 'Helianthus annuus', NULL),
(17, 225260, 'Giant-reed', 'Arundo donax', 'https://bs.plantnet.org/image/o/0dad70ed27cb8e79525531210b159365c9c73ac7'),
(18, 170613, 'Pine', 'Dacrycarpus imbricatus', 'https://bs.plantnet.org/image/o/55565bba8d5b8656b46cd8d7c82a2c24fc706d9f'),
(19, 188640, 'Hairy geranium', 'Geranium solanderi', 'https://bs.plantnet.org/image/o/6bff628c8e5b27151d2b12d1e58f69e479a07f5a'),
(20, 143177, 'Sweetflower rockjasmine', 'Androsace chamaejasme', 'https://bs.plantnet.org/image/o/0f4787056d692d33eda98774860092ca9f7746c3');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `user_id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `user_role` int(11) NOT NULL DEFAULT '0'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`user_id`, `username`, `password_hash`, `user_role`) VALUES
(4, 'jojo', '$2y$10$50bcO2Q7ATIiG/cbszHNqOk83ApvoWgU/T4qsrbRRXHcA9vLEIFfm', 1),
(5, 'dali', '$2y$10$RjO4Ad14BypyH.ZTWN4FW.1CMiGvmbGwwEN6DltfSIN6/ZT7vj3Wm', 0),
(6, 'dalby', '$2y$10$4Nyfz75W4PbCX6lNcPXBEeOmjjlyoLjpiaSkMd3JZCaTIbRzKK4/u', 0),
(7, 'admin', '$2y$10$kxRybrU5BN2inX255qSp/OxZm1XkkUUTja1fc29Bao62Ont3oWS8e', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `spots`
--
ALTER TABLE `spots`
  ADD PRIMARY KEY (`spot_id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `type_id` (`type_id`);

--
-- Indexes for table `types`
--
ALTER TABLE `types`
  ADD PRIMARY KEY (`type_id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`user_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `spots`
--
ALTER TABLE `spots`
  MODIFY `spot_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT for table `types`
--
ALTER TABLE `types`
  MODIFY `type_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `spots`
--
ALTER TABLE `spots`
  ADD CONSTRAINT `type_id` FOREIGN KEY (`type_id`) REFERENCES `types` (`type_id`),
  ADD CONSTRAINT `user_id` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
