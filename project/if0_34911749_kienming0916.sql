-- phpMyAdmin SQL Dump
-- version 4.9.0.1
-- https://www.phpmyadmin.net/
--
-- Host: sql211.infinityfree.com
-- Generation Time: Aug 31, 2023 at 02:45 AM
-- Server version: 10.4.17-MariaDB
-- PHP Version: 7.2.22

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `if0_34911749_kienming0916`
--

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `Category_ID` int(11) NOT NULL,
  `category_name` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`Category_ID`, `category_name`, `description`) VALUES
(1, 'Beverages', 'The beverages category is a diverse selection of refreshing and thirst-quenching drinks suitable for a wide range of preferences and occasions.'),
(2, 'Snacks', 'Snacks category covers a variety of tasty treats, perfect for satisfying cravings on the go, relaxing and sharing.'),
(3, 'Canned Goods', 'Canned goods comprise a collection of convenient products, providing long shelf lives and a wide range of food options for various culinary needs.'),
(4, 'Personal Care', 'The personal care category features a variety of products designed to cater to personal hygiene and self-care needs, promoting overall well-being.'),
(5, 'Household Cleaning', ' Household cleaning products are essential for maintaining a clean and sanitary living space.'),
(6, 'Stationery', 'The stationery category offers a wide assortment of essential office and school supplies, catering to various organizational and creative needs.'),
(7, 'Fashion', 'Fashion is a broad category that encompasses a wide range of items related to clothing, accessories, pants and jackets.'),
(14, 'Frozen Foods', 'Waffles, vegetables, individual meals, ice cream');

-- --------------------------------------------------------

--
-- Table structure for table `contacts`
--

CREATE TABLE `contacts` (
  `Contact_ID` int(11) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `email` varchar(50) NOT NULL,
  `phonenumber` varchar(20) NOT NULL,
  `address` varchar(150) NOT NULL,
  `message` varchar(150) NOT NULL,
  `datetime` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `contacts`
--

INSERT INTO `contacts` (`Contact_ID`, `firstname`, `lastname`, `email`, `phonenumber`, `address`, `message`, `datetime`) VALUES
(1, 'Sin', 'Kuan', 'sinkuan@gmail.com', '018-2183456', 'New Era University College, Kajang, Selangor', 'I want to purchase 100 units of jacket, please contact me via my phone number ASAP.', '2023-08-26 13:40:26'),
(2, 'Boo', 'Heng', 'booheng@gmail.com', '011-12345678', 'New Era University College, Kajang, Selangor', 'I want to purchase 100 units of jacket, please contact me via my phone number ASAP.', '2023-08-26 13:40:46'),
(3, 'Qian', 'Sheng', 'patrick@gmail.com', '013-54573843', 'New Era University College, Kajang, Selangor', 'I want to buy 50 units of pantene shampoo. Contact me ASAP.', '2023-08-26 13:44:10'),
(4, 'Cai', 'Ming', 'caiming@gmail.com', '011-2345433', 'Kajang', 'Do you sell 100 Plus in bottles?', '2023-08-27 21:09:11'),
(5, 'Kien', 'Ming', 'kmtan0111@gmail.com', '011-54343332', 'New Era University College, Kajang, Selangor', 'Hi, I want to pruchase 100 units of jacket. Contact me ASAP', '2023-08-28 07:22:54');

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `Customer_ID` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `password` varchar(200) NOT NULL,
  `firstname` varchar(30) NOT NULL,
  `lastname` varchar(30) NOT NULL,
  `gender` enum('Male','Female') NOT NULL,
  `birthdate` date NOT NULL,
  `email` varchar(50) NOT NULL,
  `registrationdatetime` datetime NOT NULL DEFAULT current_timestamp(),
  `status` enum('Active','Inactive','Pending') NOT NULL DEFAULT 'Active',
  `profile_image` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`Customer_ID`, `username`, `password`, `firstname`, `lastname`, `gender`, `birthdate`, `email`, `registrationdatetime`, `status`, `profile_image`) VALUES
(1, 'kienming0916', '$2y$10$DLadNkJXWh0jhBTQAQeqVOEHak3vYkyjgZ2rgs1XUxUFkEkDp1P32', 'Kien', 'Ming', 'Male', '2002-09-16', 'kienming@gmail.com', '2023-07-02 15:44:43', 'Active', 'uploaded_customer_img/3c1edfd4bd829c2df3e89bf3efa659c03db8d426tan.jpg'),
(2, 'mohammadali', '$2y$10$LS9ZwzVFQyD0r2nDUz/Fn.NniHvZL5aCutQqrKaVjGCGrMQqfGFjW', 'Mohammad', 'Ali', 'Male', '2003-07-19', 'mohammadali@gmail.com', '2023-07-02 15:50:06', 'Active', 'uploaded_customer_img/defaultcustomerimg.jpg'),
(3, 'shinyee711', '$2y$10$Eb/H14MP6m5SL3BLEBKh1OoiXSHbnQ6FK4eUOfXB3LMYnwm7.x4u.', 'Shin', 'Yee', 'Female', '2003-07-01', 'shinyee711@gmail.com', '2023-07-02 18:11:20', 'Active', 'uploaded_customer_img/defaultcustomerimg.jpg'),
(4, 'yeezheng0211', '$2y$10$dM9PST77IIJQAd6C3poG/.ELPHaqb0/hKb3ST03HLx5ExdNDn/9pG', 'Yee', 'Zheng', 'Male', '2002-02-11', 'yeezheng0211@gmail.com', '2023-07-02 18:12:20', 'Inactive', 'uploaded_customer_img/defaultcustomerimg.jpg'),
(5, 'boonkang', '$2y$10$nndnzzMZ80aJYFCoeItwzu2hbW8ARZOouJHh0KobNos/J2ghipvr.', 'Boon', 'Kang', 'Male', '1992-06-25', 'boonkang0625@gmail.com', '2023-07-02 18:19:27', 'Inactive', 'uploaded_customer_img/defaultcustomerimg.jpg'),
(6, 'bensimmon', '$2y$10$DuVfpcozNXSjK.SANJaHpeXLDxSJEr.QqgS6pfB8HGXWf/w6EKdJm', 'Ben', 'Simmon', 'Male', '1995-07-02', 'bensimmon@gmail.com', '2023-07-02 22:09:03', 'Pending', 'uploaded_customer_img/defaultcustomerimg.jpg'),
(7, 'cheehong0511', '$2y$10$Vo/RQwueIEVGFkrIKWp8y.5QlLIHr61RX0ju11aI5MKNMmDlgaqAO', 'Chee', 'Hong', 'Male', '2002-05-11', 'cheehong@gmail.com', '2023-07-10 12:34:40', 'Active', 'uploaded_customer_img/defaultcustomerimg.jpg'),
(8, 'junyong1215', '$2y$10$zawjv9TAbcjqPyTEJvil1eLlrkXVkUaZvoh4ym.5yltONYbYW8kMS', 'Jun', 'Yong', 'Male', '2003-12-15', 'junyong@gmail.com', '2023-07-10 12:42:16', 'Active', 'uploaded_customer_img/defaultcustomerimg.jpg'),
(9, 'mohammadabu', '$2y$10$DZ4pJxc0SssNilyKBA7HLuCxbkdx19EB06Zhl0S/HgweduY/Shuy6', 'Mohammad', 'Abu', 'Male', '2023-06-28', 'mohammadabu@gmail.com', '2023-07-10 12:43:00', 'Active', 'uploaded_customer_img/defaultcustomerimg.jpg'),
(10, 'hanyuan', '$2y$10$WU.hRsNrY0pGnvvMY0YEO.ZMMinbrtko7n.m2GVPjNSVWn9c5CrjS', 'Han', 'Yuan', 'Male', '2002-06-27', 'hanyuan@gmail.com', '2023-07-10 12:44:00', 'Active', 'uploaded_customer_img/defaultcustomerimg.jpg'),
(11, 'benjamin', '$2y$10$x3rmBSVeLEpH8kBKj7Jy0Oq3YrJ5sfKSW5uJwJdsQ/pJnX1v8VWNG', 'Benjamin', 'Lee', 'Male', '2011-01-01', 'benjamin@gmail.com', '2023-07-10 16:11:13', 'Active', 'uploaded_customer_img/defaultcustomerimg.jpg'),
(12, 'lisa0302', '$2y$10$0R1TeoZ7eLKJi8uprutX/uvxISdMVjRq9CmgDoNXWF3FwfU1ngpHa', 'Lisa', 'Lim', 'Female', '2005-03-02', 'lisa0302@gmail.com', '2023-07-14 17:33:00', 'Active', 'uploaded_customer_img/defaultcustomerimg.jpg'),
(13, 'mandy1230', '$2y$10$QJ7zNBJimMVWQFZ3/QERFO/R77nOCqOGqSW5EC2je92cc5rY9y8Q6', 'Mandy', 'Loh', 'Female', '2001-12-30', 'mandy1230@gmail.com', '2023-07-14 17:48:31', 'Active', 'uploaded_customer_img/defaultcustomerimg.jpg'),
(14, 'alison0506', '$2y$10$cAgHfh7z5.Hp/vKmqqYqTeLrY202Ltq7f8hzVmQN.NXltgKn0dVtm', 'Alison', 'Lee', 'Female', '2000-05-06', 'alison@gmail.com', '2023-07-14 18:06:19', 'Active', 'uploaded_customer_img/defaultcustomerimg.jpg'),
(15, 'baokei0202', '$2y$10$3Ub0kgufjQOHGsb7exajU.W8W953hqFk3fzkRyTQuyT651o4QoZeu', 'Bao', 'Kei', 'Male', '2002-02-02', 'lawbaokee@gmail.com', '2023-07-16 15:58:57', 'Active', 'uploaded_customer_img/defaultcustomerimg.jpg'),
(16, 'bernice0701', '$2y$10$SVMojYv6ZyMHW8X0aR8fxuc3/L/pxrJax94gR/dDFu7wMLigah8Vy', 'Bernice', 'Tan', 'Female', '2006-07-01', 'bernicetan@gmail.com', '2023-07-16 16:21:11', 'Active', 'uploaded_customer_img/defaultcustomerimg.jpg'),
(17, 'ashley', '$2y$10$yBjPdgNwPthCLsi9N6yYEO3DOe5U4euynWE0r4ZTWMvfMmxi8gi6C', 'Ashley', 'Lee', 'Female', '2002-02-21', 'ashelylee@gmail.com', '2023-07-16 16:22:36', 'Active', 'uploaded_customer_img/defaultcustomerimg.jpg'),
(18, 'alexlim', '$2y$10$k9o8DP9VdpLWakau7tiR2eQW5tvcWImEvwsKHWg5.KhGvEQF8vNPC', 'Alex', 'Lim', 'Male', '2002-10-10', 'alexlim@gmail.com', '2023-07-23 13:24:24', 'Active', 'uploaded_customer_img/defaultcustomerimg.jpg'),
(19, 'kaixiang', '$2y$10$oxBcKpxHPLFiEgrOIXz4Wuzw3YhRepY3.8Vzh16.nzVYsHFgLPRku', 'Kai', 'Xiang', 'Male', '2006-07-02', 'kaixiang702@gmail.com', '2023-07-25 22:52:49', 'Active', 'uploaded_customer_img/defaultcustomerimg.jpg'),
(20, 'moneyorange', '$2y$10$9j97yBisbdJC0tIY5RxroeT.Itj7LC/L62NJ6FfAA.Tk8EelDJ7wm', 'Money', 'Orange', 'Male', '2006-05-05', 'moneyorange@gmail.com', '2023-07-30 16:48:43', 'Active', 'uploaded_customer_img/defaultcustomerimg.jpg'),
(22, 'jameslow', '$2y$10$BVzt1Xv9PpZODI/YTzzy6O20N1htOsf8hSUHx43ca.MQtXdor7TVO', 'James', 'Low', 'Male', '2003-08-20', 'james@gmail.com', '2023-08-19 16:25:21', 'Active', 'uploaded_customer_img/49194900d682e8055e7669dcedc02f6f8da05ca5james.jpg'),
(23, 'jennie', '$2y$10$M.T8Kla/wFiQ2zTSyocDBO.rPk2oG1QDFag2bTg5clAe8Lu3Qi.ty', 'Jennie', 'Chen', 'Female', '2005-03-01', 'jenniechen@gmail.com', '2023-08-19 16:31:36', 'Active', 'uploaded_customer_img/defaultcustomerimg.jpg'),
(24, 'mbapee', '$2y$10$zxM0wESkht1LkdLeTvv8b..nx99pNfCTCmnJYZ6IgSw8AXeFJKFW6', 'Kylian', 'Mbapee', 'Male', '1998-12-20', 'mbapee@gmail.com', '2023-08-19 16:43:41', 'Active', 'uploaded_customer_img/ff8247d0a69a501fc8ce9b6c6ff1a94f62c51856kylianmbapee.jpg'),
(25, 'kyrie', '$2y$10$EblLBIuT2wBy4CkEUkSkjOTQA1/jYsUZvJflI8XkGy2GBjmzVZgcu', 'Kyrie', 'Irving', 'Male', '1992-03-23', 'kyrieirving@gmail.com', '2023-08-19 16:49:18', 'Active', 'uploaded_customer_img/886e87b94a8074eaf10e4c88bad2467ba7d1ae8ekyrie.jpg'),
(26, 'tukun', '$2y$10$XObYVpCjETifjwcc1js8UO4H8Devz1Z8rO3pl/e7xILOAHCydrlx6', 'Tukun', 'Wong', 'Male', '2005-08-19', 'tukun@gmail.com', '2023-08-19 16:58:19', 'Active', 'uploaded_customer_img/defaultcustomerimg.jpg'),
(27, 'kevinlim', '$2y$10$tYAig5amTkwJRnIk8IzdLushG4TXGi8IzUoYKpEDXTFDEXIa5oyEa', 'Kevin', 'Lim', 'Male', '2002-12-12', 'kevinlim@gmail.com', '2023-08-19 18:47:44', 'Active', 'uploaded_customer_img/defaultcustomerimg.jpg'),
(36, 'kaixin', '$2y$10$42KmI9GvGJ/b0kwYdAlQhe3N5MPHBKWiWoFDUX1uczREhNLi/HIFq', 'Kai', 'Xin', 'Female', '2006-12-12', 'kaixin@gmail.com', '2023-08-26 20:41:48', 'Active', 'uploaded_customer_img/8bcb1462b921dbe5db55ee0b078d22805f124032kaixin.jpg'),
(34, 'limsinkuan', '$2y$10$CRlHOwRhs2LhxaBLFuJxL.Ixr41vYbAYF.ZxUzVv7GJDecrGkGD2m', 'Sin', 'Kuan', 'Male', '2002-01-01', 'sinkuan@gmail.com', '2023-08-21 14:25:31', 'Active', 'uploaded_customer_img/3fdb091d3b74cbce00f0cd2e1693d9e0a357aa67lim.jpg'),
(37, 'leecaiming0711', '$2y$10$aVfuq1kv3.qD5lh4CTMMcuShQO9IrwdOqu8Q5Fy1OQWQA4hP6qfnS', 'Cai', 'Ming', 'Male', '2003-11-07', 'leecaiming@gmail.com', '2023-08-27 21:03:09', 'Active', 'uploaded_customer_img/defaultcustomerimg.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `order_details`
--

CREATE TABLE `order_details` (
  `OrderDetail_ID` int(11) NOT NULL,
  `Order_ID` int(11) NOT NULL,
  `Product_ID` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `promotion_price` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_details`
--

INSERT INTO `order_details` (`OrderDetail_ID`, `Order_ID`, `Product_ID`, `quantity`, `price`, `promotion_price`) VALUES
(170, 1, 1, 1, 2.99, 2.69),
(2, 2, 10, 5, 4, 3.8),
(3, 2, 16, 4, 15, 14),
(4, 2, 31, 3, 15, 12.99),
(5, 3, 5, 10, 8, 7.5),
(6, 3, 17, 7, 15, 14),
(7, 3, 18, 2, 10, 9.69),
(8, 3, 15, 1, 7.99, 7.5),
(9, 4, 4, 2, 6.99, 6.89),
(10, 4, 18, 1, 10, 9.69),
(11, 5, 2, 6, 3.29, 2.99),
(12, 5, 6, 8, 8, 7.5),
(13, 5, 19, 9, 19.99, 17.99),
(14, 5, 1, 1, 2.99, 2.69),
(15, 5, 13, 8, 15, 12.99),
(16, 5, 4, 10, 6.99, 6.89),
(357, 74, 42, 2, 200, 199),
(347, 75, 52, 10, 12, 0),
(356, 74, 44, 4, 3, 2.9),
(355, 74, 11, 2, 10, 9.8),
(354, 74, 4, 3, 6.99, 6.89),
(343, 73, 42, 1, 200, 199),
(342, 73, 44, 3, 3, 2.9),
(24, 7, 1, 1, 2.99, 2.69),
(25, 7, 2, 1, 3.29, 2.99),
(26, 7, 5, 1, 8, 7.5),
(151, 8, 8, 2, 5, 4.5),
(150, 8, 7, 3, 3.99, 3.95),
(149, 8, 6, 4, 8, 7.5),
(159, 9, 1, 1, 2.99, 2.69),
(158, 9, 22, 4, 16, 15.29),
(157, 9, 12, 3, 30, 28),
(156, 9, 10, 6, 4, 3.8),
(148, 10, 2, 2, 3.29, 2.99),
(147, 10, 1, 4, 2.99, 2.69),
(146, 10, 5, 5, 8, 7.5),
(145, 10, 7, 2, 3.99, 3.95),
(144, 10, 6, 3, 8, 7.5),
(39, 11, 1, 8, 2.99, 2.69),
(40, 12, 1, 1, 2.99, 2.69),
(41, 12, 2, 1, 3.29, 2.99),
(42, 12, 5, 1, 8, 7.5),
(43, 12, 3, 1, 4.99, 4.5),
(44, 12, 4, 1, 6.99, 6.89),
(45, 12, 6, 1, 8, 7.5),
(161, 22, 1, 10, 2.99, 2.69),
(160, 9, 3, 1, 4.99, 4.5),
(152, 8, 1, 5, 2.99, 2.69),
(138, 13, 1, 2, 2.99, 2.69),
(137, 13, 30, 4, 5, 4),
(51, 14, 17, 2, 15, 14),
(52, 14, 26, 2, 5, 4.9),
(53, 14, 16, 2, 15, 14),
(140, 15, 10, 1, 4, 3.8),
(139, 15, 9, 2, 5, 4.2),
(56, 16, 15, 1, 7.99, 7.5),
(57, 16, 5, 1, 8, 7.5),
(58, 16, 3, 1, 4.99, 4.5),
(59, 17, 1, 10, 2.99, 2.69),
(60, 17, 2, 4, 3.29, 2.99),
(113, 18, 19, 2, 19.99, 17.99),
(112, 18, 11, 3, 10, 9.8),
(111, 18, 1, 5, 2.99, 2.69),
(64, 19, 2, 3, 3.29, 2.99),
(65, 19, 3, 2, 4.99, 4.5),
(66, 19, 1, 5, 2.99, 2.69),
(67, 20, 7, 10, 3.99, 3.95),
(68, 20, 12, 9, 30, 28),
(69, 20, 16, 8, 15, 14),
(70, 20, 6, 6, 8, 7.5),
(71, 20, 19, 3, 19.99, 17.99),
(72, 20, 10, 2, 4, 3.8),
(73, 20, 1, 1, 2.99, 2.69),
(238, 21, 7, 1, 3.99, 3.95),
(237, 21, 18, 1, 10, 9.69),
(236, 21, 3, 5, 4.99, 4.5),
(235, 21, 14, 5, 10, 8.5),
(110, 18, 2, 3, 3.29, 2.99),
(109, 18, 10, 10, 4, 3.8),
(155, 9, 17, 1, 15, 14),
(154, 9, 6, 1, 8, 7.5),
(153, 9, 18, 3, 10, 9.69),
(162, 22, 2, 5, 3.29, 2.99),
(163, 23, 2, 4, 3.29, 2.99),
(164, 23, 12, 3, 30, 28),
(165, 23, 1, 2, 2.99, 2.69),
(166, 24, 2, 10, 3.29, 2.99),
(167, 24, 6, 10, 8, 7.5),
(168, 24, 9, 10, 5, 4.2),
(171, 1, 2, 3, 3.29, 2.99),
(172, 1, 21, 7, 30, 25),
(173, 25, 4, 10, 6.99, 6.89),
(174, 25, 17, 4, 15, 14),
(175, 25, 20, 3, 18.99, 17),
(176, 25, 19, 2, 19.99, 17.99),
(364, 26, 3, 1, 4.99, 4.5),
(363, 26, 7, 2, 3.99, 3.95),
(362, 26, 10, 3, 4, 3.8),
(209, 38, 1, 10, 2.99, 2.69),
(205, 36, 10, 10, 4, 3.8),
(204, 36, 1, 10, 2.99, 2.69),
(203, 35, 17, 2, 15, 14),
(202, 35, 18, 2, 10, 9.69),
(201, 35, 3, 2, 4.99, 4.5),
(186, 29, 14, 6, 10, 8.5),
(187, 29, 16, 6, 15, 14),
(188, 30, 2, 2, 3.29, 2.99),
(189, 30, 3, 1, 4.99, 4.5),
(190, 31, 1, 10, 2.99, 2.69),
(191, 32, 1, 1, 2.99, 2.69),
(208, 37, 3, 10, 4.99, 4.5),
(197, 34, 2, 3, 3.29, 2.99),
(207, 37, 2, 1, 3.29, 2.99),
(206, 37, 1, 1, 2.99, 2.69),
(210, 38, 10, 10, 4, 3.8),
(211, 38, 17, 10, 15, 14),
(212, 38, 4, 10, 6.99, 6.89),
(361, 39, 15, 10, 7.99, 7.5),
(234, 42, 1, 2, 2.99, 2.69),
(230, 41, 1, 2, 2.99, 2.69),
(229, 41, 9, 3, 5, 4.2),
(360, 39, 1, 10, 5, 4),
(225, 40, 34, 10, 3, 2.8),
(233, 42, 2, 1, 3.29, 2.99),
(254, 43, 4, 2, 6.99, 6.89),
(253, 43, 3, 3, 4.99, 4.5),
(252, 43, 2, 3, 3.29, 2.99),
(251, 43, 1, 3, 2.99, 2.69),
(309, 45, 1, 6, 5, 4),
(308, 45, 2, 1, 3.29, 2.99),
(307, 44, 1, 1, 5, 4),
(306, 44, 6, 3, 8, 7.5),
(305, 44, 11, 4, 10, 9.8),
(304, 44, 12, 1, 30, 28),
(303, 44, 20, 1, 18.99, 17),
(302, 44, 19, 1, 19.99, 17.99),
(301, 44, 4, 5, 6.99, 6.89),
(310, 45, 22, 4, 16, 15.29),
(311, 46, 2, 1, 3.29, 2.99),
(312, 46, 1, 6, 5, 4),
(313, 46, 22, 4, 16, 15.29),
(314, 49, 22, 10, 16, 15.29),
(315, 50, 24, 1, 35, 34),
(316, 53, 8, 3, 5, 4.5),
(331, 55, 1, 1, 5, 4),
(330, 55, 34, 7, 3, 2.8),
(332, 55, 33, 1, 5, 4.8),
(333, 61, 1, 1, 5, 4),
(334, 71, 52, 5, 12, 11),
(335, 71, 46, 4, 5, 4.9),
(336, 71, 44, 3, 3, 2.9),
(358, 74, 52, 10, 12, 0),
(353, 74, 2, 4, 3.29, 2.99),
(365, 26, 12, 10, 30, 28),
(366, 77, 44, 6, 3, 2.9),
(371, 78, 45, 2, 10, 9.5),
(370, 78, 1, 5, 5, 4);

-- --------------------------------------------------------

--
-- Table structure for table `order_summary`
--

CREATE TABLE `order_summary` (
  `Order_ID` int(11) NOT NULL,
  `Customer_ID` int(11) NOT NULL,
  `order_date` datetime NOT NULL DEFAULT current_timestamp(),
  `total_amount` double NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order_summary`
--

INSERT INTO `order_summary` (`Order_ID`, `Customer_ID`, `order_date`, `total_amount`) VALUES
(1, 1, '2023-08-07 16:05:12', 186.66),
(2, 2, '2023-07-30 15:53:30', 113.97),
(3, 18, '2023-07-30 15:54:26', 199.88),
(4, 3, '2023-07-30 16:12:51', 23.47),
(5, 16, '2023-07-30 16:14:51', 415.36),
(73, 36, '2023-08-26 20:44:19', 207.7),
(7, 1, '2023-07-30 21:40:51', 13.18),
(8, 6, '2023-08-06 18:57:47', 64.3),
(9, 15, '2023-08-06 21:36:01', 225.72),
(10, 13, '2023-08-06 18:52:55', 84.64),
(11, 12, '2023-07-30 22:04:37', 21.52),
(12, 9, '2023-07-30 22:08:17', 32.07),
(13, 17, '2023-08-06 11:44:34', 21.38),
(14, 7, '2023-07-31 10:52:52', 65.8),
(15, 20, '2023-08-06 13:41:08', 12.2),
(16, 2, '2023-07-31 21:43:42', 19.5),
(17, 11, '2023-08-03 22:31:23', 38.86),
(18, 12, '2023-08-06 10:58:30', 125.8),
(19, 1, '2023-08-05 16:03:43', 31.42),
(20, 2, '2023-08-05 17:09:42', 512.76),
(21, 11, '2023-08-26 15:51:19', 78.64),
(22, 12, '2023-08-07 13:46:38', 41.85),
(23, 3, '2023-08-07 14:19:31', 101.34),
(24, 3, '2023-08-07 15:52:07', 146.9),
(25, 14, '2023-08-11 17:11:19', 211.88),
(26, 8, '2023-08-28 20:08:19', 303.8),
(36, 6, '2023-08-12 21:16:14', 64.9),
(35, 9, '2023-08-12 21:06:48', 56.38),
(29, 11, '2023-08-12 14:46:15', 135),
(30, 3, '2023-08-12 14:48:21', 10.48),
(31, 6, '2023-08-12 14:54:02', 26.9),
(32, 1, '2023-08-12 15:03:20', 2.69),
(37, 1, '2023-08-12 21:17:46', 50.68),
(34, 7, '2023-08-12 21:03:40', 8.97),
(38, 10, '2023-08-12 21:18:29', 273.8),
(39, 16, '2023-08-28 20:08:07', 115),
(40, 2, '2023-08-12 21:25:38', 28),
(41, 5, '2023-08-19 18:55:27', 17.98),
(42, 5, '2023-08-21 15:53:47', 8.37),
(43, 3, '2023-08-26 17:06:35', 44.32),
(44, 12, '2023-08-26 17:52:57', 163.14),
(45, 14, '2023-08-26 17:55:24', 88.15),
(46, 14, '2023-08-26 17:55:42', 88.15),
(75, 13, '2023-08-27 21:04:52', 120),
(49, 1, '2023-08-26 17:57:38', 152.9),
(50, 2, '2023-08-26 17:57:58', 34),
(53, 2, '2023-08-26 17:59:04', 13.5),
(55, 9, '2023-08-26 18:07:52', 28.4),
(61, 34, '2023-08-26 18:17:02', 4),
(71, 1, '2023-08-26 20:02:56', 83.3),
(74, 37, '2023-08-27 21:05:43', 581.83),
(77, 3, '2023-08-28 08:15:22', 17.4),
(78, 15, '2023-08-28 20:24:19', 39);

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `Product_ID` int(11) NOT NULL,
  `name` varchar(50) NOT NULL,
  `description` varchar(200) NOT NULL,
  `price` double NOT NULL,
  `promotion_price` double NOT NULL,
  `manufacture_date` date NOT NULL,
  `expired_date` date NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `Category_ID` int(11) NOT NULL,
  `product_image` varchar(200) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`Product_ID`, `name`, `description`, `price`, `promotion_price`, `manufacture_date`, `expired_date`, `created`, `modified`, `Category_ID`, `product_image`) VALUES
(1, 'Coca Cola', 'Coca-Cola is a popular carbonated soft drink known for its refreshing taste and effervescence.', 5, 4, '2023-07-18', '2025-07-18', '2015-08-02 12:04:03', '2023-08-27 13:21:06', 1, 'uploaded_product_img/933d424477245b602081e8f173c2c5a45bdde45acoca-cola.jpg'),
(2, 'Tropicana Orange Juice', 'Tropicana Orange Juice is made from 100% fresh oranges for a natural citrus flavor.', 3.29, 2.99, '2023-07-18', '2025-07-18', '2015-08-02 12:14:29', '2023-08-28 05:43:09', 1, 'uploaded_product_img/300f20b9eac164519f441ee86f6f683976d47374300f20b9eac164519f441ee86f6f683976d47374tropicana.jpg'),
(3, 'LaCroix Sparkling Water', 'LaCroix Sparkling Water offers a variety of flavors infused with natural essences.', 4.99, 4.5, '2023-07-18', '2025-07-18', '2015-08-02 12:15:04', '2023-08-28 05:44:44', 1, 'uploaded_product_img/defaultproductimg.jpg'),
(4, 'Starbucks Frappuccino', 'Starbucks Frappuccino is a ready-to-drink coffee-based beverage available in various flavors.', 6.99, 6.89, '2023-07-18', '2025-07-18', '2015-08-02 12:16:08', '2023-08-27 14:13:07', 1, 'uploaded_product_img/8b822d4b901ce23d0e767325fa39a5dcc9b84893starbucksfrappuccino.jpeg'),
(5, 'Gatorade', 'Gatorade is a sports drink formulated to replenish electrolytes and provide hydration during physical activity.', 8, 7.5, '2023-07-18', '2025-07-18', '2015-08-02 12:17:58', '2023-08-27 14:12:57', 1, 'uploaded_product_img/53d89d4c72810ccd7eb37829efa6472953b6bc57gatorade.jpg'),
(6, 'Lay\'s Classic Potato Chips', 'Lay\'s Classic Potato Chips are thinly sliced and perfectly salted, offering a crispy and savory snack.', 8, 7.5, '2023-07-18', '2024-07-18', '2015-08-02 12:18:21', '2023-08-27 13:46:50', 2, 'uploaded_product_img/b06dc374aeab761d6f46976658daa1ba8073d6edlays.jpeg'),
(7, 'Hup Seng Cream Crackers', 'Hup Seng Cream Crackers are light and crispy cracker, to be the perfect savoury snack.', 3.99, 3.95, '2023-07-18', '2024-02-18', '2015-08-02 12:18:56', '2023-08-27 13:47:01', 2, 'uploaded_product_img/cf46dcaec7d80c32d54fe9e9759ecc79db3e0bd7hupseng.png'),
(8, 'Pringles Original', 'Pringles is an American brand of stackable potato-based chips.', 5, 4.5, '2023-07-18', '2024-07-18', '2023-06-26 05:03:07', '2023-08-27 13:47:14', 2, 'uploaded_product_img/b70436ac13202ee25f87fcd928b5891a825fa708pringlesorginal.jpg'),
(9, 'Popcorners', 'Popcorners are crispy and air-popped corn snacks available in various flavors, offering a lighter alternative to traditional potato chips.', 5, 4.2, '2023-07-18', '2024-07-18', '2023-06-26 05:22:46', '2023-08-27 13:48:19', 2, 'uploaded_product_img/07405b9ca30373c1c83fe040fa0179dc82982765popcorners.jpg'),
(10, 'Oreos', 'Oreos are iconic sandwich cookies with a sweet cream filling between two chocolate wafers, providing a classic and beloved treat enjoyed by people.', 4, 3.8, '2023-07-18', '2024-02-18', '2023-06-26 05:23:49', '2023-08-27 13:48:36', 2, 'uploaded_product_img/d8aadac152b605fa2df4351335a701889c4c5624oreo.jpeg'),
(11, 'Campbell\'s Tomato Soup', 'Campbell\'s Tomato Soup is a comforting and classic soup made with ripe tomatoes, offering familiar flavors that are perfect for a cozy meal.', 10, 9.8, '2023-07-18', '2026-07-18', '2023-06-26 05:41:13', '2023-08-27 13:51:22', 3, 'uploaded_product_img/1d0f09e9ca8bd84d8da0eaf4ada8544fb61a2125campbell.png'),
(12, 'Bumble Bee Solid White Albacore Tuna', 'Bumble Bee Solid White Albacore Tuna is premium-grade tuna packed in water, providing a convenient and versatile source of lean protein.', 30, 28, '2023-07-18', '2026-07-18', '2023-06-26 05:46:26', '2023-08-27 13:51:36', 3, 'uploaded_product_img/ebf36472643ff12edbdccfa6e5d233107d6ae019bumblebeetuna.jpeg'),
(13, 'Libby\'s Sweet Corn', 'Libby\'s Sweet Corn is tender and sweet corn kernels packed in a can, perfect for adding a burst of sweetness to a variety of dishes.', 15, 12.99, '2023-07-18', '2026-07-18', '2023-06-26 05:48:02', '2023-08-28 05:45:25', 3, 'uploaded_product_img/a3907e2483540cfdaa5e9abcee3ee70ac334fd3da3907e2483540cfdaa5e9abcee3ee70ac334fd3dlibbysweetcorn.jpeg'),
(14, 'Del Monte Diced Tomatoes', 'Del Monte Diced Tomatoes are vine-ripened tomatoes, diced and packed in their natural juices, ideal for adding a burst of tomato flavor to a wide range of dishes.', 10, 8.5, '2023-07-18', '2026-07-18', '2023-06-26 05:54:57', '2023-08-28 05:44:36', 3, 'uploaded_product_img/defaultproductimg.jpg'),
(15, 'Amy\'s Organic Lentil Soup', 'Amy\'s Organic Lentil Soup is a hearty and nutritious soup made with organic lentils and vegetables, providing a delicious and convenient meal option for those seeking a wholesome choice.', 7.99, 7.5, '2023-07-18', '2026-07-18', '2023-06-26 05:56:59', '2023-08-27 14:02:15', 3, 'uploaded_product_img/6afe0c046a3a9eb780dee7b9105741faeb7cad84amykitchen.jpeg'),
(16, 'Dove Moisturizing Body Wash', 'Dove Moisturizing Body Wash is a gentle and nourishing formula that cleanses and hydrates the skin, leaving it feeling soft, smooth, and refreshed after every use.', 15, 14, '2023-07-19', '2026-07-19', '2023-06-26 05:58:42', '2023-08-27 14:02:04', 4, 'uploaded_product_img/7f1207bf65ef064fc5a5992e738841cec932d817dove.jpeg'),
(17, 'Pantene Pro-V Shampoo', 'Pantene Pro-V Shampoo is a popular hair care product that helps nourish and strengthen hair, leaving it looking shiny, healthy, and manageable.', 15, 14, '2023-07-19', '2026-07-19', '2023-06-26 06:06:28', '2023-08-27 14:01:52', 4, 'uploaded_product_img/fd95cba896098327c9bf50ed63ff0f06e1e2911apantene.jpeg'),
(18, 'Colgate Total Toothpaste', 'Colgate Total Toothpaste provides comprehensive oral care, fighting bacteria and plaque, while also promoting fresh breath and maintaining overall dental health.', 10, 9.69, '2023-07-19', '2026-07-19', '2023-06-26 06:23:56', '2023-08-27 14:02:31', 4, 'uploaded_product_img/5dcfffde0ca392d20bcaf0d4bc0f82576af09392colgate.jpeg'),
(19, 'Neutrogena Facial Cleanser', 'Neutrogena Facial Cleanser is a gentle and effective cleanser that removes dirt, oil, and impurities from the skin, leaving it clean, refreshed, and ready for skincare.', 19.99, 17.99, '2023-07-19', '2026-07-19', '2023-06-26 06:28:39', '2023-08-27 14:02:44', 4, 'uploaded_product_img/6b6ebc967e363ce6271d70edddf7726016a7af40neutrogena.jpeg'),
(20, 'Gillette Mach3 Razor', 'Gillette Mach3 Razor is a high-performance shaving tool with three blades and a comfortable grip, providing a close and smooth shave for men.', 18.99, 17, '2023-07-19', '2028-07-19', '2023-06-26 07:20:21', '2023-08-27 14:04:17', 4, 'uploaded_product_img/666b999e0ee9d75d06cd60fe04b50e24087cf975gillette.jpeg'),
(21, 'Clorox Disinfecting Wipes', 'Clorox Disinfecting Wipes are pre-moistened wipes that effectively kill germs and bacteria on various surfaces, providing a convenient way to maintain cleanliness and hygiene.', 30, 25, '2023-07-19', '2028-07-19', '2023-07-02 07:27:51', '2023-08-27 14:04:07', 5, 'uploaded_product_img/003465e912f17de1e318857980ddb1d98ed28bffclorox.jpg'),
(22, 'Mr. Clean Magic Eraser', 'Mr. Clean Magic Eraser is a versatile cleaning sponge that helps remove tough stains and marks from a variety of surfaces with minimal effort.', 16, 15.29, '2023-07-19', '2028-07-19', '2023-07-02 07:28:35', '2023-08-27 14:03:53', 5, 'uploaded_product_img/3183916054f7aca844e4cc826d90578af8510678mrclean.jpeg'),
(24, 'Swiffer WetJet Mop', 'Swiffer WetJet Mop is a floor cleaning system that combines a mop with a disposable cleaning pad and a cleaning solution spray to efficiently clean.', 35, 34, '2023-07-19', '2028-07-19', '2023-07-02 11:07:50', '2023-08-27 14:03:30', 5, 'uploaded_product_img/08f5ce9e773fd2b87b8f66bb65f770d666c383ecswiffermop.jpg'),
(25, 'Windex Glass Cleaner', 'Windex Glass Cleaner is a trusted and effective formula that cleans and shines glass surfaces, leaving them streak-free and crystal clear.', 20, 18.99, '2023-07-19', '2028-07-19', '2023-07-02 11:09:51', '2023-08-27 14:03:13', 5, 'uploaded_product_img/906fac057f915ac812d3fb71f06f4eb13c8432c3windex.jpg'),
(26, 'Pilot G2 Gel Pen', 'The Pilot G2 Gel Pen is a favorite among writers for its smooth and effortless writing experience. Its gel ink and comfortable grip make long writing sessions enjoyable.', 5, 4.9, '2023-07-19', '2028-07-19', '2023-07-02 11:55:07', '2023-08-27 14:03:04', 6, 'uploaded_product_img/8d48864648dd47e33a2df22d5945cd48fbcae988pilotg2.jpg'),
(27, 'Moleskine  Classic Hardcover Notebook', 'The Moleskine Classic Hardcover Notebook is a timeless and high-quality option for jotting down ideas, taking notes, or capturing your thoughts.', 2, 1.9, '2023-07-19', '2028-07-19', '2023-07-02 11:57:55', '2023-08-27 14:02:54', 6, 'uploaded_product_img/3f165951c1a1f98c58702b39876f20583f9fb657moloskinenotebook.jpeg'),
(29, 'Sharpie Permanent Markers', 'Sharpie Permanent Markers are bold and long-lasting markers that provide vibrant and fade-resistant markings on a variety of surfaces.', 6, 5.5, '2023-07-19', '2028-07-19', '2023-07-02 14:10:44', '2023-08-27 13:58:05', 6, 'uploaded_product_img/c95ef5288c90e13822afa8e3c033c1cfb3643d94sharpie.png'),
(30, 'Scotch Magic Tape', 'Scotch Magic Tape is a versatile and transparent tape that offers a strong bond for everyday sealing.', 5, 4, '2023-07-19', '2028-07-19', '2023-07-17 07:45:54', '2023-08-27 14:07:34', 6, 'uploaded_product_img/963e586cf9073e10bfc25350a9b19285730ba05escotchmagictape.jpg'),
(31, 'Spicy Tomato and Lentil Soup', 'Spicy Tomato and Lentil Soup is a hearty and flavorful canned goods product that combines the rich savory taste of tomatoes.', 15, 12.99, '2023-07-20', '2028-07-20', '2023-07-20 13:44:21', '2023-08-27 13:46:13', 3, 'uploaded_product_img/7901e663e3cc36912f63dd76ff9fc0597cfc9318spciytomatolentilsoup.jpg'),
(33, 'Crispy BBQ Chickpeas', 'Crispy BBQ Chickpeas are an addictive and wholesome snack product that offers a satisfying crunch and robust flavor.', 5, 4.8, '2023-07-20', '2024-07-20', '2023-07-20 13:55:33', '2023-08-27 13:44:20', 2, 'uploaded_product_img/de3fccf43ac20cc323cb083b322ec31246dc2087chickpeas.jpg'),
(34, 'Recycled Paper Notebook', 'Eco-friendly recycled paper notebooks are the perfect eco-friendly stationery product.', 3, 2.8, '2023-07-20', '2028-07-20', '2023-07-20 13:56:35', '2023-08-28 05:44:54', 6, 'uploaded_product_img/defaultproductimg.jpg'),
(42, 'Jacket', 'Men Warm Winter Overcoat Lamb Fur Lined Thick Trench Coats Fashion Cowboy Jacket.', 200, 199, '2023-08-19', '2025-08-19', '2023-08-19 07:49:40', '2023-08-27 14:15:25', 7, 'uploaded_product_img/2e9a8618922a454f24664516a6734029dd67bdfbjacket.jpeg'),
(44, '100 Plus', '100plus is a brand of isotonic sports drink manufactured by Fraser and Neave Limited.', 3, 2.9, '2023-08-19', '2024-08-19', '2023-08-19 08:51:32', '2023-08-27 14:12:43', 1, 'uploaded_product_img/3cf6270be3d4a5715cc494bdb525688b2f2de010100plus.png'),
(45, 'Lexus', 'Lexus is a nutritious vegetable crackers biscuit enriched with vegetable flakes.', 10, 9.5, '2023-08-19', '2024-08-19', '2023-08-19 08:55:01', '2023-08-27 14:12:35', 2, 'uploaded_product_img/f3a5327162a638394d78d31c8a6df1b9acb2a178lexus.jpg'),
(46, 'Pringles Spicy', 'Pringles is an American brand of stackable potato-based chips.', 5, 4.9, '2023-08-19', '2024-08-19', '2023-08-19 08:57:18', '2023-08-28 07:27:52', 2, 'uploaded_product_img/000981a444633b97383077a097695b107441ea57pringlesspicy.jpeg'),
(52, 'Julie\'s', 'Julie\'s is a biscuit brand sold in 80 countries across Asia, Australia, and New Zealand.', 12, 0, '2023-08-19', '2024-02-19', '2023-08-19 11:20:42', '2023-08-28 11:21:43', 2, 'uploaded_product_img/1611a0067b51f1939f3819cdc83efed9ebc7fe45julie.png'),
(66, 'NestlÃ©\'s vanilla ice cream', 'It is a delectable frozen dessert known for its creamy texture and rich vanilla flavor. Made from high-quality ingredients, it offers a delightful treat that is loved by people.', 15, 14, '2023-08-28', '2024-08-28', '2023-08-28 08:05:40', '2023-08-28 12:05:41', 14, 'uploaded_product_img/defaultproductimg.jpg');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`Category_ID`);

--
-- Indexes for table `contacts`
--
ALTER TABLE `contacts`
  ADD PRIMARY KEY (`Contact_ID`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`Customer_ID`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`);

--
-- Indexes for table `order_details`
--
ALTER TABLE `order_details`
  ADD PRIMARY KEY (`OrderDetail_ID`),
  ADD KEY `Order_ID` (`Order_ID`),
  ADD KEY `Product_ID` (`Product_ID`);

--
-- Indexes for table `order_summary`
--
ALTER TABLE `order_summary`
  ADD PRIMARY KEY (`Order_ID`),
  ADD KEY `Customer_ID` (`Customer_ID`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`Product_ID`),
  ADD KEY `Category_ID` (`Category_ID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `Category_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=15;

--
-- AUTO_INCREMENT for table `contacts`
--
ALTER TABLE `contacts`
  MODIFY `Contact_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `Customer_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=39;

--
-- AUTO_INCREMENT for table `order_details`
--
ALTER TABLE `order_details`
  MODIFY `OrderDetail_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=372;

--
-- AUTO_INCREMENT for table `order_summary`
--
ALTER TABLE `order_summary`
  MODIFY `Order_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=79;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `Product_ID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=68;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
