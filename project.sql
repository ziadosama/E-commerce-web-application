-- phpMyAdmin SQL Dump
-- version 4.7.9
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 18, 2018 at 11:17 AM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.3

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `project`
--

-- --------------------------------------------------------

--
-- Table structure for table `buyer`
--

CREATE TABLE `buyer` (
  `buyerID` int(11) NOT NULL,
  `buyerPhone` char(11) NOT NULL,
  `buyerName` varchar(50) NOT NULL,
  `buyerEmail` varchar(50) NOT NULL,
  `buyerPwd` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `buyer`
--

INSERT INTO `buyer` (`buyerID`, `buyerPhone`, `buyerName`, `buyerEmail`, `buyerPwd`) VALUES
(3, '1005851669', 'ziad', 'ziadosama@aucegypt.edu', '$2y$10$oIpLWV2LiuOYTCniMLGscOd26iK5hTfC/27A5tQaEm16ocmOpAugy'),
(9, '01005851669', 'mohsen', 'mohsen@mona.edu', '$2y$10$8XN1222rmNxBdT5hWRzGRON8nSNNfgE5BnUhdKgnGqK9UioWT5iXa');

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `cartID` int(11) NOT NULL,
  `buyerID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `cart-product`
--

CREATE TABLE `cart-product` (
  `productID` int(11) DEFAULT NULL,
  `cartID` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- --------------------------------------------------------

--
-- Table structure for table `category`
--

CREATE TABLE `category` (
  `categoryID` int(11) NOT NULL,
  `catName` varchar(15) NOT NULL,
  `storeID` int(11) DEFAULT NULL,
  `sellerID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `category`
--

INSERT INTO `category` (`categoryID`, `catName`, `storeID`, `sellerID`) VALUES
(53, 'appliances', 23, 5),
(54, 'food', 23, 5),
(55, 'electricity', 23, 5),
(56, 'music', 23, 5),
(59, 'foodies', 24, 23),
(60, 'food', 24, 23);

-- --------------------------------------------------------

--
-- Table structure for table `order-product`
--

CREATE TABLE `order-product` (
  `productID` int(11) DEFAULT NULL,
  `orderID` int(11) DEFAULT NULL,
  `quantity` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `order-product`
--

INSERT INTO `order-product` (`productID`, `orderID`, `quantity`) VALUES
(24, 13, 1),
(25, 13, 1),
(24, 15, 2),
(24, 16, 1),
(23, 18, 2);

-- --------------------------------------------------------

--
-- Table structure for table `orrder`
--

CREATE TABLE `orrder` (
  `orderID` int(11) NOT NULL,
  `orderDate` date NOT NULL,
  `sellerID` int(11) DEFAULT NULL,
  `buyerID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orrder`
--

INSERT INTO `orrder` (`orderID`, `orderDate`, `sellerID`, `buyerID`) VALUES
(11, '2012-08-06', 5, 3),
(13, '2012-08-06', 5, 3),
(15, '2012-08-06', 5, 3),
(16, '2012-08-06', 5, 3),
(18, '2012-08-06', 5, 3);

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE `product` (
  `productID` int(11) NOT NULL,
  `categoryID` int(11) DEFAULT NULL,
  `sellerID` int(11) DEFAULT NULL,
  `productName` varchar(25) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`productID`, `categoryID`, `sellerID`, `productName`) VALUES
(23, 54, 5, 'banana'),
(24, 53, 5, 'TV'),
(25, 53, 5, 'Playstation'),
(26, 55, 5, 'feesha'),
(27, 60, 23, 'banana');

-- --------------------------------------------------------

--
-- Table structure for table `seller`
--

CREATE TABLE `seller` (
  `sellerID` int(11) NOT NULL,
  `sellerPhone` char(11) NOT NULL,
  `sellerName` varchar(50) NOT NULL,
  `sellerEmail` varchar(50) NOT NULL,
  `sellerPwd` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `seller`
--

INSERT INTO `seller` (`sellerID`, `sellerPhone`, `sellerName`, `sellerEmail`, `sellerPwd`) VALUES
(5, '1005851669', 'ziad', 'ziadosama@aucegypt.edu', '$2y$10$qUz6DsulmwIAXI77chFen.YEoS2hkbje7h0wcSvLNSA6RqjSPh9IO'),
(23, '01005851669', 'mohsen', 'mohsen@mona.edu', '$2y$10$8XN1222rmNxBdT5hWRzGRON8nSNNfgE5BnUhdKgnGqK9UioWT5iXa');

-- --------------------------------------------------------

--
-- Table structure for table `store`
--

CREATE TABLE `store` (
  `storeID` int(11) NOT NULL,
  `storeName` varchar(15) NOT NULL,
  `sellerID` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `store`
--

INSERT INTO `store` (`storeID`, `storeName`, `sellerID`) VALUES
(23, 'ahmed', 5),
(24, 'mona', 23);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `buyer`
--
ALTER TABLE `buyer`
  ADD PRIMARY KEY (`buyerID`),
  ADD UNIQUE KEY `buyer_uk` (`buyerID`,`buyerName`,`buyerEmail`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`cartID`),
  ADD KEY `buyerID` (`buyerID`);

--
-- Indexes for table `cart-product`
--
ALTER TABLE `cart-product`
  ADD KEY `productID` (`productID`),
  ADD KEY `cartID` (`cartID`);

--
-- Indexes for table `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`categoryID`),
  ADD KEY `storeID` (`storeID`),
  ADD KEY `sellerID` (`sellerID`),
  ADD KEY `catName` (`catName`) USING BTREE;

--
-- Indexes for table `order-product`
--
ALTER TABLE `order-product`
  ADD KEY `productID` (`productID`),
  ADD KEY `orderID` (`orderID`);

--
-- Indexes for table `orrder`
--
ALTER TABLE `orrder`
  ADD PRIMARY KEY (`orderID`),
  ADD KEY `sellerID` (`sellerID`),
  ADD KEY `buyerID` (`buyerID`);

--
-- Indexes for table `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`productID`),
  ADD KEY `categoryID` (`categoryID`),
  ADD KEY `sellerID` (`sellerID`);

--
-- Indexes for table `seller`
--
ALTER TABLE `seller`
  ADD PRIMARY KEY (`sellerID`),
  ADD UNIQUE KEY `seller_uk` (`sellerID`,`sellerName`,`sellerEmail`);

--
-- Indexes for table `store`
--
ALTER TABLE `store`
  ADD PRIMARY KEY (`storeID`),
  ADD KEY `sellerID` (`sellerID`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `buyer`
--
ALTER TABLE `buyer`
  MODIFY `buyerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `cartID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT for table `category`
--
ALTER TABLE `category`
  MODIFY `categoryID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT for table `orrder`
--
ALTER TABLE `orrder`
  MODIFY `orderID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT for table `product`
--
ALTER TABLE `product`
  MODIFY `productID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=28;

--
-- AUTO_INCREMENT for table `seller`
--
ALTER TABLE `seller`
  MODIFY `sellerID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;

--
-- AUTO_INCREMENT for table `store`
--
ALTER TABLE `store`
  MODIFY `storeID` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `cart`
--
ALTER TABLE `cart`
  ADD CONSTRAINT `cart_ibfk_1` FOREIGN KEY (`buyerID`) REFERENCES `buyer` (`buyerID`);

--
-- Constraints for table `cart-product`
--
ALTER TABLE `cart-product`
  ADD CONSTRAINT `cart-product_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`),
  ADD CONSTRAINT `cart-product_ibfk_2` FOREIGN KEY (`cartID`) REFERENCES `cart` (`cartID`);

--
-- Constraints for table `category`
--
ALTER TABLE `category`
  ADD CONSTRAINT `category_ibfk_1` FOREIGN KEY (`storeID`) REFERENCES `store` (`storeID`),
  ADD CONSTRAINT `category_ibfk_2` FOREIGN KEY (`sellerID`) REFERENCES `seller` (`sellerID`);

--
-- Constraints for table `order-product`
--
ALTER TABLE `order-product`
  ADD CONSTRAINT `order-product_ibfk_1` FOREIGN KEY (`productID`) REFERENCES `product` (`productID`),
  ADD CONSTRAINT `order-product_ibfk_2` FOREIGN KEY (`orderID`) REFERENCES `orrder` (`orderID`);

--
-- Constraints for table `orrder`
--
ALTER TABLE `orrder`
  ADD CONSTRAINT `orrder_ibfk_1` FOREIGN KEY (`sellerID`) REFERENCES `seller` (`sellerID`),
  ADD CONSTRAINT `orrder_ibfk_2` FOREIGN KEY (`buyerID`) REFERENCES `buyer` (`buyerID`);

--
-- Constraints for table `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`categoryID`) REFERENCES `category` (`categoryID`),
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`sellerID`) REFERENCES `seller` (`sellerID`);

--
-- Constraints for table `store`
--
ALTER TABLE `store`
  ADD CONSTRAINT `store_ibfk_1` FOREIGN KEY (`sellerID`) REFERENCES `seller` (`sellerID`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
