-- phpMyAdmin SQL Dump
-- version 4.9.11
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Generation Time: Jul 20, 2023 at 08:08 AM
-- Server version: 5.6.51-cll-lve
-- PHP Version: 7.4.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `adcast`
--

-- --------------------------------------------------------

--
-- Table structure for table `active_guests`
--

CREATE TABLE `active_guests` (
  `ip` varchar(15) NOT NULL,
  `timestamp` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `active_guests`
--

INSERT INTO `active_guests` (`ip`, `timestamp`) VALUES
('182.177.244.53', 1689865562);

-- --------------------------------------------------------

--
-- Table structure for table `active_users`
--

CREATE TABLE `active_users` (
  `username` varchar(30) NOT NULL,
  `timestamp` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `adsdetail`
--

CREATE TABLE `adsdetail` (
  `id` int(11) NOT NULL,
  `deviceId` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `user` varchar(256) NOT NULL,
  `timestamp` int(11) NOT NULL,
  `startDate` varchar(256) NOT NULL,
  `endDate` varchar(256) NOT NULL,
  `status` varchar(256) NOT NULL,
  `downloadStatus` varchar(256) NOT NULL,
  `size` int(11) NOT NULL,
  `flag` int(11) NOT NULL,
  `flag2` int(11) NOT NULL,
  `path` varchar(256) NOT NULL,
  `short_url` varchar(255) NOT NULL,
  `startTime` varchar(256) NOT NULL,
  `endTime` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `adsdetail`
--

INSERT INTO `adsdetail` (`id`, `deviceId`, `name`, `user`, `timestamp`, `startDate`, `endDate`, `status`, `downloadStatus`, `size`, `flag`, `flag2`, `path`, `short_url`, `startTime`, `endTime`) VALUES
(91, 15, 'New Ad', '14', 1683966371, '2023-03-07', '2023-03-10', 'Offline', 'Pending Download', 1, 0, 0, '1415_43791254676.mp4', 'http://adcast.industrialemployeeprogress.com/playAdd.php?c=91', '13:25', '14:33'),
(96, 19, 'test1', '22', 1684087018, '2023-05-14', '2023-05-21', 'Offline', 'Pending Download', 1, 0, 0, '2219_13801424696.mp4', 'http://adcast.industrialemployeeprogress.com/playAdd.php?c=96', '19:00', '20:31'),
(97, 19, 'test2', '22', 1678528607, '2023-03-11', '2023-03-13', 'Offline', 'Pending Download', 34, 0, 0, '2219_8596341419.mp4', 'http://adcast.industrialemployeeprogress.com/playAdd.php?c=97', '', ''),
(98, 20, 'New Ad', '23', 1679202341, '2023-03-20', '2023-03-21', 'Offline', 'Pending Download', 11, 0, 0, '2320_70451627541.mp4', 'http://adcast.industrialemployeeprogress.com/playAdd.php?c=98', '', ''),
(99, 20, 'new Ad', '23', 1679204134, '2023-03-25', '2023-03-27', 'Offline', 'Pending Download', 11, 0, 0, '2320_63218552180.mp4', 'http://adcast.industrialemployeeprogress.com/playAdd.php?c=99', '', ''),
(100, 20, 'new ad', '23', 1679204596, '2023-03-28', '2023-03-29', 'Offline', 'Pending Download', 11, 0, 0, '2320_81228077496.mp4', 'http://adcast.industrialemployeeprogress.com/playAdd.php?c=100', '', ''),
(101, 20, 'new Ad', '23', 1679207281, '2023-03-19', '2023-03-20', 'Offline', 'Pending Download', 11, 0, 0, '2320_55487577623.mp4', 'http://adcast.industrialemployeeprogress.com/playAdd.php?c=101', '', ''),
(104, 17, 'AD 1', '16', 1684925783, '2023-05-14', '2023-07-10', 'Offline', 'Pending Download', 1, 0, 0, '1617_42917602786.mp4', 'http://adcast.industrialemployeeprogress.com/playAdd.php?c=104', '03:57', '15:58'),
(114, 17, 'AD 2', '16', 1684929533, '2023-03-31', '2023-05-04', 'Offline', 'Pending Download', 0, 0, 0, '1617_85134009483.mp4', 'http://adcast.industrialemployeeprogress.com/playAdd.php?c=114', '17:00', '20:57'),
(115, 21, '60 Curzon St', '22', 1682012870, '2023-04-21', '2023-04-21', 'Offline', 'Pending Download', 14, 0, 0, '2221_4178872596.mp4', 'http://adcast.industrialemployeeprogress.com/playAdd.php?c=115', '19:48', '22:30'),
(117, 21, '', '22', 1682012897, '2023-04-20', '2023-04-20', 'Offline', 'Pending Download', 0, 0, 0, '2221_96112844059.mp4', 'http://adcast.industrialemployeeprogress.com/playAdd.php?c=117', '19:48', '19:58'),
(118, 21, '', '22', 1682013192, '2023-04-20', '2023-04-20', 'Offline', 'Pending Download', 0, 0, 0, '2221_97217013599.mp4', 'http://adcast.industrialemployeeprogress.com/playAdd.php?c=118', '19:59', '20:05'),
(119, 22, 'NewAd', '24', 1684047636, '2023-05-14', '2023-05-17', 'Offline', 'Pending Download', 1, 0, 0, '2422_11890749698.mp4', 'http://adcast.industrialemployeeprogress.com/playAdd.php?c=119', '12:05', '12:06'),
(120, 23, 'NewAd', '24', 1684062171, '2023-05-14', '2023-06-01', 'Offline', 'Pending Download', 0, 0, 0, '2423_9621146610.mp4', 'http://adcast.industrialemployeeprogress.com/playAdd.php?c=120', '16:03', '16:45'),
(121, 25, 'test 1', '', 1684086798, '2023-05-14', '2023-05-15', '', 'Pending Download', 6, 0, 0, '25_5164058894.mp4', 'http://adcast.industrialemployeeprogress.com/playAdd.php?c=121', '19:50', '20:55'),
(122, 25, 'test 1', '26', 1684086506, '2023-05-14', '2023-05-15', 'Offline', 'Pending Download', 6, 0, 0, '2625_80730111657.mp4', 'http://adcast.industrialemployeeprogress.com/playAdd.php?c=122', '19:50', '20:50'),
(123, 26, 'Marko', '28', 1684090540, '2023-05-14', '2023-05-21', 'Offline', 'Pending Download', 1, 0, 0, '2826_11763221439.mp4', 'http://adcast.industrialemployeeprogress.com/playAdd.php?c=123', '20:00', '20:05'),
(124, 26, '', '28', 1684090498, '2023-05-14', '2023-05-21', 'Offline', 'Pending Download', 1, 0, 0, '2826_73027344667.mp4', 'http://adcast.industrialemployeeprogress.com/playAdd.php?c=124', '20:06', '20:15'),
(125, 28, '', '28', 1684090831, '2023-05-14', '2023-05-15', 'Offline', 'Pending Download', 21, 0, 0, '2828_17933375071.mp4', 'http://adcast.industrialemployeeprogress.com/playAdd.php?c=125', '20:03', '21:04');

-- --------------------------------------------------------

--
-- Table structure for table `adstimedetail`
--

CREATE TABLE `adstimedetail` (
  `id` int(11) NOT NULL,
  `adId` int(11) NOT NULL,
  `deviceId` int(11) NOT NULL,
  `user` varchar(256) NOT NULL,
  `name` varchar(256) NOT NULL,
  `date` varchar(256) NOT NULL,
  `dateTimestamp` int(11) NOT NULL,
  `flag` int(11) NOT NULL,
  `startTime` varchar(256) NOT NULL,
  `endTime` varchar(256) NOT NULL,
  `day` varchar(256) NOT NULL,
  `flag2` int(11) NOT NULL,
  `monday` varchar(256) NOT NULL,
  `tuesday` varchar(256) NOT NULL,
  `wednesday` varchar(256) NOT NULL,
  `thursday` varchar(256) NOT NULL,
  `friday` varchar(256) NOT NULL,
  `saturday` varchar(256) NOT NULL,
  `sunday` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `adstimedetail`
--

INSERT INTO `adstimedetail` (`id`, `adId`, `deviceId`, `user`, `name`, `date`, `dateTimestamp`, `flag`, `startTime`, `endTime`, `day`, `flag2`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sunday`) VALUES
(878, 98, 20, '23', 'New Ad', '2023-03-20', 1679270400, 0, '10:05', '10:10', 'Monday', 0, '', '', '', '', '', '', ''),
(879, 98, 20, '23', 'New Ad', '2023-03-21', 1679356800, 0, '10:05', '10:10', 'Tuesday', 0, '', '', '', '', '', '', ''),
(880, 99, 20, '23', 'new Ad', '2023-03-25', 1679702400, 0, '00:33', '01:37', 'Saturday', 0, '', '', '', '', '', '', ''),
(881, 99, 20, '23', 'new Ad', '2023-03-26', 1679788800, 0, '00:33', '01:37', 'Sunday', 0, '', '', '', '', '', '', ''),
(882, 99, 20, '23', 'new Ad', '2023-03-27', 1679875200, 0, '00:33', '01:37', 'Monday', 0, '', '', '', '', '', '', ''),
(883, 100, 20, '23', 'new ad', '2023-03-28', 1679961600, 0, '10:40', '10:48', 'Tuesday', 0, '', '', '', '', '', '', ''),
(884, 100, 20, '23', 'new ad', '2023-03-29', 1680048000, 0, '10:40', '10:48', 'Wednesday', 0, '', '', '', '', '', '', ''),
(885, 101, 20, '23', 'new Ad', '2023-03-19', 1679184000, 0, '11:26', '11:40', 'Sunday', 0, '', '', '', '', '', '', ''),
(886, 101, 20, '23', 'new Ad', '2023-03-20', 1679270400, 0, '11:26', '11:40', 'Monday', 0, '', '', '', '', '', '', ''),
(6462, 115, 21, '22', '60 Curzon St', '2023-04-21', 1682035200, 0, '19:48', '22:30', 'Friday', 0, '', '', '', '', '', '', ''),
(6464, 117, 21, '22', '', '2023-04-20', 1681948800, 0, '19:48', '19:58', 'Thursday', 0, '', '', '', '', '', '', ''),
(6465, 118, 21, '22', '', '2023-04-20', 1681948800, 0, '19:59', '20:05', 'Thursday', 0, '', '', '', '', '', '', ''),
(6470, 91, 15, '14', 'New Ad', '2023-03-07', 1678147200, 0, '13:25', '14:33', 'Tuesday', 0, '', '', '', '', '', '', ''),
(6471, 91, 15, '14', 'New Ad', '2023-03-08', 1678233600, 0, '13:25', '14:33', 'Wednesday', 0, '', '', '', '', '', '', ''),
(6472, 91, 15, '14', 'New Ad', '2023-03-09', 1678320000, 0, '13:25', '14:33', 'Thursday', 0, '', '', '', '', '', '', ''),
(6473, 91, 15, '14', 'New Ad', '2023-03-10', 1678406400, 0, '13:25', '14:33', 'Friday', 0, '', '', '', '', '', '', ''),
(6532, 119, 22, '24', 'NewAd', '2023-05-14', 1684022400, 0, '12:05', '12:06', 'Sunday', 0, '', '', '', '', '', '', ''),
(6533, 119, 22, '24', 'NewAd', '2023-05-15', 1684108800, 0, '12:05', '12:06', 'Monday', 0, '', '', '', '', '', '', ''),
(6534, 119, 22, '24', 'NewAd', '2023-05-16', 1684195200, 0, '12:05', '12:06', 'Tuesday', 0, '', '', '', '', '', '', ''),
(6535, 119, 22, '24', 'NewAd', '2023-05-17', 1684281600, 0, '12:05', '12:06', 'Wednesday', 0, '', '', '', '', '', '', ''),
(6650, 120, 23, '24', 'NewAd', '2023-05-14', 1684022400, 0, '16:03', '16:45', 'Sunday', 0, '', '', '', '', '', '', ''),
(6651, 120, 23, '24', 'NewAd', '2023-05-15', 1684108800, 0, '16:03', '16:45', 'Monday', 0, '', '', '', '', '', '', ''),
(6652, 120, 23, '24', 'NewAd', '2023-05-16', 1684195200, 0, '16:03', '16:45', 'Tuesday', 0, '', '', '', '', '', '', ''),
(6653, 120, 23, '24', 'NewAd', '2023-05-17', 1684281600, 0, '16:03', '16:45', 'Wednesday', 0, '', '', '', '', '', '', ''),
(6654, 120, 23, '24', 'NewAd', '2023-05-18', 1684368000, 0, '16:03', '16:45', 'Thursday', 0, '', '', '', '', '', '', ''),
(6655, 120, 23, '24', 'NewAd', '2023-05-19', 1684454400, 0, '16:03', '16:45', 'Friday', 0, '', '', '', '', '', '', ''),
(6656, 120, 23, '24', 'NewAd', '2023-05-20', 1684540800, 0, '16:03', '16:45', 'Saturday', 0, '', '', '', '', '', '', ''),
(6657, 120, 23, '24', 'NewAd', '2023-05-21', 1684627200, 0, '16:03', '16:45', 'Sunday', 0, '', '', '', '', '', '', ''),
(6658, 120, 23, '24', 'NewAd', '2023-05-22', 1684713600, 0, '16:03', '16:45', 'Monday', 0, '', '', '', '', '', '', ''),
(6659, 120, 23, '24', 'NewAd', '2023-05-23', 1684800000, 0, '16:03', '16:45', 'Tuesday', 0, '', '', '', '', '', '', ''),
(6660, 120, 23, '24', 'NewAd', '2023-05-24', 1684886400, 0, '16:03', '16:45', 'Wednesday', 0, '', '', '', '', '', '', ''),
(6661, 120, 23, '24', 'NewAd', '2023-05-25', 1684972800, 0, '16:03', '16:45', 'Thursday', 0, '', '', '', '', '', '', ''),
(6662, 120, 23, '24', 'NewAd', '2023-05-26', 1685059200, 0, '16:03', '16:45', 'Friday', 0, '', '', '', '', '', '', ''),
(6663, 120, 23, '24', 'NewAd', '2023-05-27', 1685145600, 0, '16:03', '16:45', 'Saturday', 0, '', '', '', '', '', '', ''),
(6664, 120, 23, '24', 'NewAd', '2023-05-28', 1685232000, 0, '16:03', '16:45', 'Sunday', 0, '', '', '', '', '', '', ''),
(6665, 120, 23, '24', 'NewAd', '2023-05-29', 1685318400, 0, '16:03', '16:45', 'Monday', 0, '', '', '', '', '', '', ''),
(6666, 120, 23, '24', 'NewAd', '2023-05-30', 1685404800, 0, '16:03', '16:45', 'Tuesday', 0, '', '', '', '', '', '', ''),
(6667, 120, 23, '24', 'NewAd', '2023-05-31', 1685491200, 0, '16:03', '16:45', 'Wednesday', 0, '', '', '', '', '', '', ''),
(6668, 120, 23, '24', 'NewAd', '2023-06-01', 1685577600, 0, '16:03', '16:45', 'Thursday', 0, '', '', '', '', '', '', ''),
(6679, 122, 25, '26', 'test 1', '2023-05-14', 1684022400, 0, '19:50', '20:50', 'Sunday', 0, '', '', '', '', '', '', ''),
(6680, 122, 25, '26', 'test 1', '2023-05-15', 1684108800, 0, '19:50', '20:50', 'Monday', 0, '', '', '', '', '', '', ''),
(6681, 121, 25, '', 'test 1', '2023-05-14', 1684022400, 0, '19:50', '20:55', 'Sunday', 0, '', '', '', '', '', '', ''),
(6682, 121, 25, '', 'test 1', '2023-05-15', 1684108800, 0, '19:50', '20:55', 'Monday', 0, '', '', '', '', '', '', ''),
(6683, 96, 19, '22', 'test1', '2023-05-14', 1684022400, 0, '19:00', '20:31', 'Sunday', 0, '', '', '', '', '', '', ''),
(6684, 96, 19, '22', 'test1', '2023-05-15', 1684108800, 0, '19:00', '20:31', 'Monday', 0, '', '', '', '', '', '', ''),
(6685, 96, 19, '22', 'test1', '2023-05-16', 1684195200, 0, '19:00', '20:31', 'Tuesday', 0, '', '', '', '', '', '', ''),
(6686, 96, 19, '22', 'test1', '2023-05-17', 1684281600, 0, '19:00', '20:31', 'Wednesday', 0, '', '', '', '', '', '', ''),
(6687, 96, 19, '22', 'test1', '2023-05-18', 1684368000, 0, '19:00', '20:31', 'Thursday', 0, '', '', '', '', '', '', ''),
(6688, 96, 19, '22', 'test1', '2023-05-19', 1684454400, 0, '19:00', '20:31', 'Friday', 0, '', '', '', '', '', '', ''),
(6689, 96, 19, '22', 'test1', '2023-05-20', 1684540800, 0, '19:00', '20:31', 'Saturday', 0, '', '', '', '', '', '', ''),
(6690, 96, 19, '22', 'test1', '2023-05-21', 1684627200, 0, '19:00', '20:31', 'Sunday', 0, '', '', '', '', '', '', ''),
(6747, 124, 26, '28', '', '2023-05-14', 1684022400, 0, '20:06', '20:15', 'Sunday', 0, '', '', '', '', '', '', ''),
(6748, 124, 26, '28', '', '2023-05-15', 1684108800, 0, '20:06', '20:15', 'Monday', 0, '', '', '', '', '', '', ''),
(6749, 124, 26, '28', '', '2023-05-16', 1684195200, 0, '20:06', '20:15', 'Tuesday', 0, '', '', '', '', '', '', ''),
(6750, 124, 26, '28', '', '2023-05-17', 1684281600, 0, '20:06', '20:15', 'Wednesday', 0, '', '', '', '', '', '', ''),
(6751, 124, 26, '28', '', '2023-05-18', 1684368000, 0, '20:06', '20:15', 'Thursday', 0, '', '', '', '', '', '', ''),
(6752, 124, 26, '28', '', '2023-05-19', 1684454400, 0, '20:06', '20:15', 'Friday', 0, '', '', '', '', '', '', ''),
(6753, 124, 26, '28', '', '2023-05-20', 1684540800, 0, '20:06', '20:15', 'Saturday', 0, '', '', '', '', '', '', ''),
(6754, 124, 26, '28', '', '2023-05-21', 1684627200, 0, '20:06', '20:15', 'Sunday', 0, '', '', '', '', '', '', ''),
(6755, 123, 26, '28', 'Marko', '2023-05-14', 1684022400, 0, '20:00', '20:05', 'Sunday', 0, '', '', '', '', '', '', ''),
(6756, 123, 26, '28', 'Marko', '2023-05-15', 1684108800, 0, '20:00', '20:05', 'Monday', 0, '', '', '', '', '', '', ''),
(6757, 123, 26, '28', 'Marko', '2023-05-16', 1684195200, 0, '20:00', '20:05', 'Tuesday', 0, '', '', '', '', '', '', ''),
(6758, 123, 26, '28', 'Marko', '2023-05-17', 1684281600, 0, '20:00', '20:05', 'Wednesday', 0, '', '', '', '', '', '', ''),
(6759, 123, 26, '28', 'Marko', '2023-05-18', 1684368000, 0, '20:00', '20:05', 'Thursday', 0, '', '', '', '', '', '', ''),
(6760, 123, 26, '28', 'Marko', '2023-05-19', 1684454400, 0, '20:00', '20:05', 'Friday', 0, '', '', '', '', '', '', ''),
(6761, 123, 26, '28', 'Marko', '2023-05-20', 1684540800, 0, '20:00', '20:05', 'Saturday', 0, '', '', '', '', '', '', ''),
(6762, 123, 26, '28', 'Marko', '2023-05-21', 1684627200, 0, '20:00', '20:05', 'Sunday', 0, '', '', '', '', '', '', ''),
(6763, 125, 28, '28', '', '2023-05-14', 1684022400, 0, '20:03', '21:04', 'Sunday', 0, '', '', '', '', '', '', ''),
(6764, 125, 28, '28', '', '2023-05-15', 1684108800, 0, '20:03', '21:04', 'Monday', 0, '', '', '', '', '', '', ''),
(6858, 104, 17, '16', 'AD 1', '2023-05-14', 1684022400, 0, '03:57', '15:58', 'Sunday', 0, '', '', '', '', '', '', ''),
(6859, 104, 17, '16', 'AD 1', '2023-05-15', 1684108800, 0, '03:57', '15:58', 'Monday', 0, '', '', '', '', '', '', ''),
(6860, 104, 17, '16', 'AD 1', '2023-05-16', 1684195200, 0, '03:57', '15:58', 'Tuesday', 0, '', '', '', '', '', '', ''),
(6861, 104, 17, '16', 'AD 1', '2023-05-17', 1684281600, 0, '03:57', '15:58', 'Wednesday', 0, '', '', '', '', '', '', ''),
(6862, 104, 17, '16', 'AD 1', '2023-05-18', 1684368000, 0, '03:57', '15:58', 'Thursday', 0, '', '', '', '', '', '', ''),
(6863, 104, 17, '16', 'AD 1', '2023-05-19', 1684454400, 0, '03:57', '15:58', 'Friday', 0, '', '', '', '', '', '', ''),
(6864, 104, 17, '16', 'AD 1', '2023-05-20', 1684540800, 0, '03:57', '15:58', 'Saturday', 0, '', '', '', '', '', '', ''),
(6865, 104, 17, '16', 'AD 1', '2023-05-21', 1684627200, 0, '03:57', '15:58', 'Sunday', 0, '', '', '', '', '', '', ''),
(6866, 104, 17, '16', 'AD 1', '2023-05-22', 1684713600, 0, '03:57', '15:58', 'Monday', 0, '', '', '', '', '', '', ''),
(6867, 104, 17, '16', 'AD 1', '2023-05-23', 1684800000, 0, '03:57', '15:58', 'Tuesday', 0, '', '', '', '', '', '', ''),
(6868, 104, 17, '16', 'AD 1', '2023-05-24', 1684886400, 0, '03:57', '15:58', 'Wednesday', 0, '', '', '', '', '', '', ''),
(6869, 104, 17, '16', 'AD 1', '2023-05-25', 1684972800, 0, '03:57', '15:58', 'Thursday', 0, '', '', '', '', '', '', ''),
(6870, 104, 17, '16', 'AD 1', '2023-05-26', 1685059200, 0, '03:57', '15:58', 'Friday', 0, '', '', '', '', '', '', ''),
(6871, 104, 17, '16', 'AD 1', '2023-05-27', 1685145600, 0, '03:57', '15:58', 'Saturday', 0, '', '', '', '', '', '', ''),
(6872, 104, 17, '16', 'AD 1', '2023-05-28', 1685232000, 0, '03:57', '15:58', 'Sunday', 0, '', '', '', '', '', '', ''),
(6873, 104, 17, '16', 'AD 1', '2023-05-29', 1685318400, 0, '03:57', '15:58', 'Monday', 0, '', '', '', '', '', '', ''),
(6874, 104, 17, '16', 'AD 1', '2023-05-30', 1685404800, 0, '03:57', '15:58', 'Tuesday', 0, '', '', '', '', '', '', ''),
(6875, 104, 17, '16', 'AD 1', '2023-05-31', 1685491200, 0, '03:57', '15:58', 'Wednesday', 0, '', '', '', '', '', '', ''),
(6876, 104, 17, '16', 'AD 1', '2023-06-01', 1685577600, 0, '03:57', '15:58', 'Thursday', 0, '', '', '', '', '', '', ''),
(6877, 104, 17, '16', 'AD 1', '2023-06-02', 1685664000, 0, '03:57', '15:58', 'Friday', 0, '', '', '', '', '', '', ''),
(6878, 104, 17, '16', 'AD 1', '2023-06-03', 1685750400, 0, '03:57', '15:58', 'Saturday', 0, '', '', '', '', '', '', ''),
(6879, 104, 17, '16', 'AD 1', '2023-06-04', 1685836800, 0, '03:57', '15:58', 'Sunday', 0, '', '', '', '', '', '', ''),
(6880, 104, 17, '16', 'AD 1', '2023-06-05', 1685923200, 0, '03:57', '15:58', 'Monday', 0, '', '', '', '', '', '', ''),
(6881, 104, 17, '16', 'AD 1', '2023-06-06', 1686009600, 0, '03:57', '15:58', 'Tuesday', 0, '', '', '', '', '', '', ''),
(6882, 104, 17, '16', 'AD 1', '2023-06-07', 1686096000, 0, '03:57', '15:58', 'Wednesday', 0, '', '', '', '', '', '', ''),
(6883, 104, 17, '16', 'AD 1', '2023-06-08', 1686182400, 0, '03:57', '15:58', 'Thursday', 0, '', '', '', '', '', '', ''),
(6884, 104, 17, '16', 'AD 1', '2023-06-09', 1686268800, 0, '03:57', '15:58', 'Friday', 0, '', '', '', '', '', '', ''),
(6885, 104, 17, '16', 'AD 1', '2023-06-10', 1686355200, 0, '03:57', '15:58', 'Saturday', 0, '', '', '', '', '', '', ''),
(6886, 104, 17, '16', 'AD 1', '2023-06-11', 1686441600, 0, '03:57', '15:58', 'Sunday', 0, '', '', '', '', '', '', ''),
(6887, 104, 17, '16', 'AD 1', '2023-06-12', 1686528000, 0, '03:57', '15:58', 'Monday', 0, '', '', '', '', '', '', ''),
(6888, 104, 17, '16', 'AD 1', '2023-06-13', 1686614400, 0, '03:57', '15:58', 'Tuesday', 0, '', '', '', '', '', '', ''),
(6889, 104, 17, '16', 'AD 1', '2023-06-14', 1686700800, 0, '03:57', '15:58', 'Wednesday', 0, '', '', '', '', '', '', ''),
(6890, 104, 17, '16', 'AD 1', '2023-06-15', 1686787200, 0, '03:57', '15:58', 'Thursday', 0, '', '', '', '', '', '', ''),
(6891, 104, 17, '16', 'AD 1', '2023-06-16', 1686873600, 0, '03:57', '15:58', 'Friday', 0, '', '', '', '', '', '', ''),
(6892, 104, 17, '16', 'AD 1', '2023-06-17', 1686960000, 0, '03:57', '15:58', 'Saturday', 0, '', '', '', '', '', '', ''),
(6893, 104, 17, '16', 'AD 1', '2023-06-18', 1687046400, 0, '03:57', '15:58', 'Sunday', 0, '', '', '', '', '', '', ''),
(6894, 104, 17, '16', 'AD 1', '2023-06-19', 1687132800, 0, '03:57', '15:58', 'Monday', 0, '', '', '', '', '', '', ''),
(6895, 104, 17, '16', 'AD 1', '2023-06-20', 1687219200, 0, '03:57', '15:58', 'Tuesday', 0, '', '', '', '', '', '', ''),
(6896, 104, 17, '16', 'AD 1', '2023-06-21', 1687305600, 0, '03:57', '15:58', 'Wednesday', 0, '', '', '', '', '', '', ''),
(6897, 104, 17, '16', 'AD 1', '2023-06-22', 1687392000, 0, '03:57', '15:58', 'Thursday', 0, '', '', '', '', '', '', ''),
(6898, 104, 17, '16', 'AD 1', '2023-06-23', 1687478400, 0, '03:57', '15:58', 'Friday', 0, '', '', '', '', '', '', ''),
(6899, 104, 17, '16', 'AD 1', '2023-06-24', 1687564800, 0, '03:57', '15:58', 'Saturday', 0, '', '', '', '', '', '', ''),
(6900, 104, 17, '16', 'AD 1', '2023-06-25', 1687651200, 0, '03:57', '15:58', 'Sunday', 0, '', '', '', '', '', '', ''),
(6901, 104, 17, '16', 'AD 1', '2023-06-26', 1687737600, 0, '03:57', '15:58', 'Monday', 0, '', '', '', '', '', '', ''),
(6902, 104, 17, '16', 'AD 1', '2023-06-27', 1687824000, 0, '03:57', '15:58', 'Tuesday', 0, '', '', '', '', '', '', ''),
(6903, 104, 17, '16', 'AD 1', '2023-06-28', 1687910400, 0, '03:57', '15:58', 'Wednesday', 0, '', '', '', '', '', '', ''),
(6904, 104, 17, '16', 'AD 1', '2023-06-29', 1687996800, 0, '03:57', '15:58', 'Thursday', 0, '', '', '', '', '', '', ''),
(6905, 104, 17, '16', 'AD 1', '2023-06-30', 1688083200, 0, '03:57', '15:58', 'Friday', 0, '', '', '', '', '', '', ''),
(6906, 104, 17, '16', 'AD 1', '2023-07-01', 1688169600, 0, '03:57', '15:58', 'Saturday', 0, '', '', '', '', '', '', ''),
(6907, 104, 17, '16', 'AD 1', '2023-07-02', 1688256000, 0, '03:57', '15:58', 'Sunday', 0, '', '', '', '', '', '', ''),
(6908, 104, 17, '16', 'AD 1', '2023-07-03', 1688342400, 0, '03:57', '15:58', 'Monday', 0, '', '', '', '', '', '', ''),
(6909, 104, 17, '16', 'AD 1', '2023-07-04', 1688428800, 0, '03:57', '15:58', 'Tuesday', 0, '', '', '', '', '', '', ''),
(6910, 104, 17, '16', 'AD 1', '2023-07-05', 1688515200, 0, '03:57', '15:58', 'Wednesday', 0, '', '', '', '', '', '', ''),
(6911, 104, 17, '16', 'AD 1', '2023-07-06', 1688601600, 0, '03:57', '15:58', 'Thursday', 0, '', '', '', '', '', '', ''),
(6912, 104, 17, '16', 'AD 1', '2023-07-07', 1688688000, 0, '03:57', '15:58', 'Friday', 0, '', '', '', '', '', '', ''),
(6913, 104, 17, '16', 'AD 1', '2023-07-08', 1688774400, 0, '03:57', '15:58', 'Saturday', 0, '', '', '', '', '', '', ''),
(6914, 104, 17, '16', 'AD 1', '2023-07-09', 1688860800, 0, '03:57', '15:58', 'Sunday', 0, '', '', '', '', '', '', ''),
(6915, 104, 17, '16', 'AD 1', '2023-07-10', 1688947200, 0, '03:57', '15:58', 'Monday', 0, '', '', '', '', '', '', ''),
(6986, 114, 17, '16', 'AD 2', '2023-03-31', 1680220800, 0, '17:00', '20:57', 'Friday', 0, '', '', '', '', '', '', ''),
(6987, 114, 17, '16', 'AD 2', '2023-04-01', 1680307200, 0, '17:00', '20:57', 'Saturday', 0, '', '', '', '', '', '', ''),
(6988, 114, 17, '16', 'AD 2', '2023-04-02', 1680393600, 0, '17:00', '20:57', 'Sunday', 0, '', '', '', '', '', '', ''),
(6989, 114, 17, '16', 'AD 2', '2023-04-03', 1680480000, 0, '17:00', '20:57', 'Monday', 0, '', '', '', '', '', '', ''),
(6990, 114, 17, '16', 'AD 2', '2023-04-04', 1680566400, 0, '17:00', '20:57', 'Tuesday', 0, '', '', '', '', '', '', ''),
(6991, 114, 17, '16', 'AD 2', '2023-04-05', 1680652800, 0, '17:00', '20:57', 'Wednesday', 0, '', '', '', '', '', '', ''),
(6992, 114, 17, '16', 'AD 2', '2023-04-06', 1680739200, 0, '17:00', '20:57', 'Thursday', 0, '', '', '', '', '', '', ''),
(6993, 114, 17, '16', 'AD 2', '2023-04-07', 1680825600, 0, '17:00', '20:57', 'Friday', 0, '', '', '', '', '', '', ''),
(6994, 114, 17, '16', 'AD 2', '2023-04-08', 1680912000, 0, '17:00', '20:57', 'Saturday', 0, '', '', '', '', '', '', ''),
(6995, 114, 17, '16', 'AD 2', '2023-04-09', 1680998400, 0, '17:00', '20:57', 'Sunday', 0, '', '', '', '', '', '', ''),
(6996, 114, 17, '16', 'AD 2', '2023-04-10', 1681084800, 0, '17:00', '20:57', 'Monday', 0, '', '', '', '', '', '', ''),
(6997, 114, 17, '16', 'AD 2', '2023-04-11', 1681171200, 0, '17:00', '20:57', 'Tuesday', 0, '', '', '', '', '', '', ''),
(6998, 114, 17, '16', 'AD 2', '2023-04-12', 1681257600, 0, '17:00', '20:57', 'Wednesday', 0, '', '', '', '', '', '', ''),
(6999, 114, 17, '16', 'AD 2', '2023-04-13', 1681344000, 0, '17:00', '20:57', 'Thursday', 0, '', '', '', '', '', '', ''),
(7000, 114, 17, '16', 'AD 2', '2023-04-14', 1681430400, 0, '17:00', '20:57', 'Friday', 0, '', '', '', '', '', '', ''),
(7001, 114, 17, '16', 'AD 2', '2023-04-15', 1681516800, 0, '17:00', '20:57', 'Saturday', 0, '', '', '', '', '', '', ''),
(7002, 114, 17, '16', 'AD 2', '2023-04-16', 1681603200, 0, '17:00', '20:57', 'Sunday', 0, '', '', '', '', '', '', ''),
(7003, 114, 17, '16', 'AD 2', '2023-04-17', 1681689600, 0, '17:00', '20:57', 'Monday', 0, '', '', '', '', '', '', ''),
(7004, 114, 17, '16', 'AD 2', '2023-04-18', 1681776000, 0, '17:00', '20:57', 'Tuesday', 0, '', '', '', '', '', '', ''),
(7005, 114, 17, '16', 'AD 2', '2023-04-19', 1681862400, 0, '17:00', '20:57', 'Wednesday', 0, '', '', '', '', '', '', ''),
(7006, 114, 17, '16', 'AD 2', '2023-04-20', 1681948800, 0, '17:00', '20:57', 'Thursday', 0, '', '', '', '', '', '', ''),
(7007, 114, 17, '16', 'AD 2', '2023-04-21', 1682035200, 0, '17:00', '20:57', 'Friday', 0, '', '', '', '', '', '', ''),
(7008, 114, 17, '16', 'AD 2', '2023-04-22', 1682121600, 0, '17:00', '20:57', 'Saturday', 0, '', '', '', '', '', '', ''),
(7009, 114, 17, '16', 'AD 2', '2023-04-23', 1682208000, 0, '17:00', '20:57', 'Sunday', 0, '', '', '', '', '', '', ''),
(7010, 114, 17, '16', 'AD 2', '2023-04-24', 1682294400, 0, '17:00', '20:57', 'Monday', 0, '', '', '', '', '', '', ''),
(7011, 114, 17, '16', 'AD 2', '2023-04-25', 1682380800, 0, '17:00', '20:57', 'Tuesday', 0, '', '', '', '', '', '', ''),
(7012, 114, 17, '16', 'AD 2', '2023-04-26', 1682467200, 0, '17:00', '20:57', 'Wednesday', 0, '', '', '', '', '', '', ''),
(7013, 114, 17, '16', 'AD 2', '2023-04-27', 1682553600, 0, '17:00', '20:57', 'Thursday', 0, '', '', '', '', '', '', ''),
(7014, 114, 17, '16', 'AD 2', '2023-04-28', 1682640000, 0, '17:00', '20:57', 'Friday', 0, '', '', '', '', '', '', ''),
(7015, 114, 17, '16', 'AD 2', '2023-04-29', 1682726400, 0, '17:00', '20:57', 'Saturday', 0, '', '', '', '', '', '', ''),
(7016, 114, 17, '16', 'AD 2', '2023-04-30', 1682812800, 0, '17:00', '20:57', 'Sunday', 0, '', '', '', '', '', '', ''),
(7017, 114, 17, '16', 'AD 2', '2023-05-01', 1682899200, 0, '17:00', '20:57', 'Monday', 0, '', '', '', '', '', '', ''),
(7018, 114, 17, '16', 'AD 2', '2023-05-02', 1682985600, 0, '17:00', '20:57', 'Tuesday', 0, '', '', '', '', '', '', ''),
(7019, 114, 17, '16', 'AD 2', '2023-05-03', 1683072000, 0, '17:00', '20:57', 'Wednesday', 0, '', '', '', '', '', '', ''),
(7020, 114, 17, '16', 'AD 2', '2023-05-04', 1683158400, 0, '17:00', '20:57', 'Thursday', 0, '', '', '', '', '', '', '');

-- --------------------------------------------------------

--
-- Table structure for table `banned_users`
--

CREATE TABLE `banned_users` (
  `username` varchar(30) NOT NULL,
  `timestamp` int(11) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `devices`
--

CREATE TABLE `devices` (
  `id` int(11) NOT NULL,
  `user` varchar(256) NOT NULL,
  `deviceName` varchar(256) NOT NULL,
  `deviceType` varchar(256) NOT NULL,
  `deviceOrientation` varchar(256) NOT NULL,
  `status` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `devices`
--

INSERT INTO `devices` (`id`, `user`, `deviceName`, `deviceType`, `deviceOrientation`, `status`) VALUES
(15, '14', 'Sony', 'androidTv', 'horizontal', 'Offline'),
(16, '15', 'Sony', 'androidTv', 'horizontal', 'Offline'),
(17, '16', 'TV in the main ', 'androidTv', 'horizontal', 'Offline'),
(19, '22', 'soba radna', 'androidTv', 'horizontal', 'Offline'),
(20, '23', 'Sony', 'appleTv', 'vertical', 'Offline'),
(21, '22', 'spavaca soba', 'androidTv', 'horizontal', 'Offline'),
(22, '24', 'TV in the main ', 'androidTv', 'horizontal', 'Offline'),
(23, '24', 'TV in Hall', 'androidTv', 'horizontal', 'Offline'),
(25, '26', 'Radna soba', 'androidTv', 'vertical', 'Offline'),
(26, '28', 'my room', 'androidTv', 'horizontal', 'Offline'),
(27, '27', 'Samsung', 'androidTv', 'vertical', 'Offline'),
(28, '28', 'spavaca soba', 'appleTv', 'horizontal', 'Offline'),
(29, '29', 'Front LCD', 'androidTv', 'horizontal', 'Offline');

-- --------------------------------------------------------

--
-- Table structure for table `profile`
--

CREATE TABLE `profile` (
  `id` int(11) NOT NULL,
  `user` varchar(256) NOT NULL,
  `businessName` varchar(256) NOT NULL,
  `businessIndustry` varchar(256) NOT NULL,
  `businessType` varchar(256) NOT NULL,
  `workingHours` varchar(256) NOT NULL,
  `timezone` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `profile`
--

INSERT INTO `profile` (`id`, `user`, `businessName`, `businessIndustry`, `businessType`, `workingHours`, `timezone`) VALUES
(11, '14', 'new', 'construction', 'liftIndustry', '10', 'Asia/Karachi'),
(12, '15', 'Lift Industry', 'construction', 'liftIndustry', '10', 'Asia/Karachi'),
(13, '16', 'Test Account', 'construction', 'liftIndustry', '8', 'Asia/Karachi'),
(14, '19', 'sadas', 'construction', 'liftIndustry', '9', 'Pacific/Midway'),
(16, '22', 'MISTEL', 'construction', 'liftIndustry', '8', 'UTC'),
(17, '23', 'new profile', 'construction', 'liftIndustry', '8', 'Asia/Karachi'),
(18, '24', 'Test Account', 'construction', 'liftIndustry', '8', 'Asia/Ashgabat'),
(20, '26', 'TuÅ¡ d.o.o', 'construction', 'liftIndustry', '8', 'Africa/Casablanca'),
(21, '27', 'Gtr', 'construction', 'liftIndustry', '10', 'Europe/Dublin'),
(22, '28', 'marko proba', 'construction', 'liftIndustry', '10', 'UTC'),
(23, '29', 'SJP Legnocrats', 'construction', 'liftIndustry', '10', 'Asia/Karachi');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(32) DEFAULT NULL,
  `userid` varchar(32) DEFAULT NULL,
  `userlevel` tinyint(1) UNSIGNED NOT NULL,
  `email` varchar(50) DEFAULT NULL,
  `timestamp` int(11) UNSIGNED NOT NULL,
  `parent_directory` varchar(30) NOT NULL,
  `privacy` varchar(256) NOT NULL,
  `profilePicture` varchar(256) NOT NULL,
  `accountStatus` varchar(256) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `name`, `username`, `password`, `userid`, `userlevel`, `email`, `timestamp`, `parent_directory`, `privacy`, `profilePicture`, `accountStatus`) VALUES
(28, 'Marko', 'ccucek4@gmail.com', '4297f44b13955235245b2497399d7a93', '37bc887a98817e2856a36ad31bf63a32', 2, 'ccucek4@gmail.com', 1684473886, '0', 'checked', '', 'basic'),
(19, 'dummy', 'dummy@gmail.com', 'bad670f05ad869901d90a37aef62572c', 'a202229d4312491c701b1a9bd99f9866', 2, 'dummy@gmail.com', 1678349266, '0', 'checked', '', 'basic'),
(29, 'Fakhir', 'fakhiir@gmail.com', '93279e3308bdbbeed946fc965017f67a', '520d73de0a8a5719a23819400e83b0d5', 3, 'fakhiir@gmail.com', 1689829538, '0', 'checked', '', 'basic'),
(24, 'Hassan', 'hassan@gmail.com', '93279e3308bdbbeed946fc965017f67a', 'eb94fced07d6d06ab83fdbc9e4b1ccc6', 2, 'hassan@gmail.com', 1684925373, '0', 'checked', '', 'basic'),
(16, 'Hassan Zaman', 'hassanzaman99@gmail.com', 'bad670f05ad869901d90a37aef62572c', 'a8e9be5f20119945afb7c917d7a8c3be', 2, 'hassanzaman99@gmail.com', 1684930569, '0', '', '', 'basic'),
(26, 'Ivanka', 'ivanka.spoljaric45@gmail.com', '51506cf4c67015e64c7a600f98edb56a', 'a19009fdb99448a04649ec0b4a40cfab', 2, 'ivanka.spoljaric45@gmail.com', 1684345259, '0', 'checked', '', 'basic'),
(23, 'new', 'new@gmail.com', 'bad670f05ad869901d90a37aef62572c', 'c03e2b0e3dcd42e7492c9a94bc5f1d24', 2, 'new@gmail.com', 1679639324, '0', 'checked', '', 'basic'),
(14, 'newuser', 'newuser@gmail.com', 'bad670f05ad869901d90a37aef62572c', '335309c76d9033ef6293ed7cf316ddb6', 2, 'newuser@gmail.com', 1683996797, '0', 'checked', '', 'basic'),
(27, 'Tim', 'tim@gtr-uk.com', '2d97435d160a35ec38a7fa59ef612082', '81ffd8c9792a384fb3a829e01e63effe', 2, 'tim@gtr-uk.com', 1684092119, '0', 'checked', '', 'basic');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `active_guests`
--
ALTER TABLE `active_guests`
  ADD PRIMARY KEY (`ip`);

--
-- Indexes for table `active_users`
--
ALTER TABLE `active_users`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `adsdetail`
--
ALTER TABLE `adsdetail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `adstimedetail`
--
ALTER TABLE `adstimedetail`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `banned_users`
--
ALTER TABLE `banned_users`
  ADD PRIMARY KEY (`username`);

--
-- Indexes for table `devices`
--
ALTER TABLE `devices`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `profile`
--
ALTER TABLE `profile`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`username`),
  ADD UNIQUE KEY `id` (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `adsdetail`
--
ALTER TABLE `adsdetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=128;

--
-- AUTO_INCREMENT for table `adstimedetail`
--
ALTER TABLE `adstimedetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7023;

--
-- AUTO_INCREMENT for table `devices`
--
ALTER TABLE `devices`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;

--
-- AUTO_INCREMENT for table `profile`
--
ALTER TABLE `profile`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=30;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
