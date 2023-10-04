-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 03, 2023 at 04:23 PM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 8.0.19

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `productice`
--

-- --------------------------------------------------------

--
-- Table structure for table `admin`
--

CREATE TABLE `admin` (
  `admin_id` int(11) NOT NULL,
  `fullname` varchar(50) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `admin`
--

INSERT INTO `admin` (`admin_id`, `fullname`, `email`, `password`) VALUES
(1, 'Product Ice', 'donkim018@gmail.com', 'product123');

-- --------------------------------------------------------

--
-- Table structure for table `expense`
--

CREATE TABLE `expense` (
  `expense_id` int(11) NOT NULL,
  `expenseName` varchar(50) NOT NULL,
  `expenseAmount` varchar(50) NOT NULL,
  `expenseDate` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `expense`
--

INSERT INTO `expense` (`expense_id`, `expenseName`, `expenseAmount`, `expenseDate`) VALUES
(1, 'foodi', '25', '2023-08-27'),
(2, 'electricity', '30', '2023-08-30'),
(3, 'fundi', '30', '2023-08-31'),
(4, 'keys', '10', '2023-08-31'),
(6, 'voucher', '10', '2023-08-31'),
(7, 'board', '20', '2023-09-01'),
(8, 'bags', '15', '2023-08-31'),
(9, 'electricity', '6', '2023-09-02');

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `product_id` int(11) NOT NULL,
  `productName` varchar(50) NOT NULL,
  `productCost` varchar(50) NOT NULL,
  `productPrice` varchar(50) NOT NULL,
  `productUnit` varchar(50) NOT NULL,
  `saleUnit` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `products`
--

INSERT INTO `products` (`product_id`, `productName`, `productCost`, `productPrice`, `productUnit`, `saleUnit`) VALUES
(1, 'Maziwaa', '200', '250', '20', '330'),
(2, 'mkate', '400', '500', '158', '600'),
(3, 'Laptop', '2000', '2500', '70', '3000'),
(4, 'pc', '4200', '5000', '20', '6000'),
(5, 'keyboard ', '10000', '2500', '80', '3000'),
(6, 'phone', '1000', '1200', '45', '3000');

-- --------------------------------------------------------

--
-- Table structure for table `purchase`
--

CREATE TABLE `purchase` (
  `purchase_id` int(11) NOT NULL,
  `purchaseDate` date NOT NULL,
  `itemsPurchased` varchar(50) NOT NULL,
  `purchasePrice` varchar(50) NOT NULL,
  `purchaseQuantity` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `purchase`
--

INSERT INTO `purchase` (`purchase_id`, `purchaseDate`, `itemsPurchased`, `purchasePrice`, `purchaseQuantity`) VALUES
(1, '2023-08-27', 'Maziwa', '450', '12'),
(2, '2023-08-30', 'Maziwaa', '100', '8'),
(3, '2023-08-30', 'sugar', '200', '9'),
(4, '2023-08-31', 'wire', '100', '10'),
(5, '2023-08-29', 'socket', '300', '2'),
(6, '2023-08-31', 'help', '100', '7');

-- --------------------------------------------------------

--
-- Table structure for table `sales`
--

CREATE TABLE `sales` (
  `sales_id` int(11) NOT NULL,
  `saleDate` date NOT NULL,
  `saleItem` varchar(50) NOT NULL,
  `clientName` varchar(50) NOT NULL,
  `saleQuantity` varchar(50) NOT NULL,
  `saleUnit` varchar(50) NOT NULL,
  `salePrice` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sales`
--

INSERT INTO `sales` (`sales_id`, `saleDate`, `saleItem`, `clientName`, `saleQuantity`, `saleUnit`, `salePrice`) VALUES
(1, '2023-08-27', 'Maziwaa', 'Product enterr', '7', '253', '450'),
(2, '2023-08-30', 'Laptop', 'Product enterprises', '10', '3000', '30000.00'),
(3, '2023-08-31', 'pc', 'Product enter', '20', '600', '12000.00'),
(4, '2023-08-31', 'keyboard ', 'Product enterr', '40', '3000', '120000.00'),
(5, '2023-08-31', 'mkate', 'Product enterprises', '40', '500', '18000.00'),
(6, '2023-09-01', 'pc', 'Product enter', '20', '4000', '80000.00'),
(7, '2023-09-02', 'mkate', 'Product enterprises', '2', '600', '1200.00'),
(9, '2023-09-02', 'Maziwaa', 'Product enter', '10', '330', '3300.00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`admin_id`);

--
-- Indexes for table `expense`
--
ALTER TABLE `expense`
  ADD PRIMARY KEY (`expense_id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`product_id`);

--
-- Indexes for table `purchase`
--
ALTER TABLE `purchase`
  ADD PRIMARY KEY (`purchase_id`);

--
-- Indexes for table `sales`
--
ALTER TABLE `sales`
  ADD PRIMARY KEY (`sales_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `admin`
--
ALTER TABLE `admin`
  MODIFY `admin_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `expense`
--
ALTER TABLE `expense`
  MODIFY `expense_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `product_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `purchase`
--
ALTER TABLE `purchase`
  MODIFY `purchase_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `sales`
--
ALTER TABLE `sales`
  MODIFY `sales_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
