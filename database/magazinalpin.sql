-- phpMyAdmin SQL Dump
-- version 5.1.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1:3306
-- Generation Time: Jan 10, 2023 at 01:42 PM
-- Server version: 5.7.36
-- PHP Version: 7.4.26

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `magazinalpin`
--

-- --------------------------------------------------------

--
-- Table structure for table `client`
--

DROP TABLE IF EXISTS `client`;
CREATE TABLE IF NOT EXISTS `client` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userId` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `address` varchar(200) NOT NULL,
  `city` varchar(100) NOT NULL,
  `phone` varchar(30) NOT NULL,
  `postcode` varchar(10) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_clientuser` (`userId`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `client`
--

INSERT INTO `client` (`id`, `userId`, `name`, `address`, `city`, `phone`, `postcode`) VALUES
(1, 5, 'andra ', 'buna ziua', 'cluj-napoca', '075894623158', '435300'),
(3, 5, 'aaa', 'bbb', 'Cluj napoca', '021548796', '0000'),
(5, 6, 'user1 client', 'str Motilor nr4', 'Cluj Napoca', '0215879643', '435200'),
(6, 5, 'user', 'Str Aurel Vlaicu nr 123', 'Cluj Napoca', '0236897452', '587240'),
(7, 7, 'user 2 client', 'Aleea Vasile Lucaciu nr 2', 'Cavnic', '021358745', '120785'),
(8, 9, 'nnnnnn', 'Str Buna ziua nr 2', 'Cluj Napoca', '0125879630', '1000255'),
(9, 10, 'client user 6', 'Calea Turzii nr 467', 'Cluj Napoca', '002157125', '003202'),
(10, 11, 'user5 Client', 'Calea Victoriei', 'Bucuresti', '0215896003', '002120'),
(11, 7, 'uuuuser', 'Str 21 Decembrie nr 56', 'Cluj Napoca', '012578451', '200321'),
(12, 8, 'user 3 client', 'Str Sfatului nr 4', 'Brasov', '0002325581', '500230');

-- --------------------------------------------------------

--
-- Table structure for table `orderdetail`
--

DROP TABLE IF EXISTS `orderdetail`;
CREATE TABLE IF NOT EXISTS `orderdetail` (
  `orderid` int(11) NOT NULL,
  `productid` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double(10,2) NOT NULL,
  PRIMARY KEY (`orderid`,`productid`),
  KEY `fk_orderdetailproductid` (`productid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orderdetail`
--

INSERT INTO `orderdetail` (`orderid`, `productid`, `quantity`, `price`) VALUES
(55, 8, 1, 100.00),
(55, 12, 1, 120.00),
(55, 18, 1, 450.00),
(57, 11, 1, 1250.00),
(57, 12, 3, 360.00),
(57, 17, 1, 625.00),
(58, 13, 1, 1305.00),
(58, 14, 1, 2850.00),
(58, 16, 1, 635.00),
(58, 18, 1, 450.00),
(59, 10, 1, 450.00),
(59, 11, 1, 1250.00),
(59, 15, 1, 485.00),
(59, 17, 1, 625.00),
(59, 18, 1, 450.00),
(60, 8, 1, 100.00),
(60, 10, 1, 450.00),
(60, 12, 1, 120.00),
(60, 14, 1, 2850.00),
(61, 14, 1, 2850.00),
(62, 15, 1, 485.00),
(62, 16, 1, 635.00),
(62, 17, 1, 625.00),
(63, 16, 1, 635.00),
(64, 8, 1, 100.00),
(65, 8, 4, 401.00),
(68, 8, 1, 100.00),
(72, 11, 1, 1250.00),
(73, 8, 1, 100.00),
(74, 10, 1, 450.00),
(75, 8, 1, 100.00);

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

DROP TABLE IF EXISTS `orders`;
CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `clientid` int(11) NOT NULL,
  `total` double(10,2) NOT NULL,
  `status` varchar(20) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `fk_orderclientid` (`clientid`)
) ENGINE=InnoDB AUTO_INCREMENT=76 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `orders`
--

INSERT INTO `orders` (`id`, `clientid`, `total`, `status`) VALUES
(55, 5, 670.26, 'comanda plasata'),
(56, 5, 670.26, 'comanda expediata'),
(57, 6, 2235.00, 'comanda plasata'),
(58, 7, 5240.00, 'comanda plasata'),
(59, 8, 3260.00, 'comanda livrata'),
(60, 9, 3520.26, 'comanda plasata'),
(61, 10, 2850.00, 'comanda plasata'),
(62, 11, 1745.00, 'comanda returnata'),
(63, 12, 635.00, 'comanda plasata'),
(64, 1, 100.26, 'comanda plasata'),
(65, 1, 401.04, 'comanda plasata'),
(66, 1, 401.04, 'comanda plasata'),
(67, 1, 401.04, 'comanda plasata'),
(68, 1, 100.26, 'comanda plasata'),
(69, 1, 100.26, 'comanda plasata'),
(70, 1, 100.26, 'comanda plasata'),
(71, 1, 100.26, 'comanda plasata'),
(72, 1, 1250.00, 'comanda plasata'),
(73, 1, 100.26, 'comanda plasata'),
(74, 1, 450.00, 'comanda plasata'),
(75, 1, 100.26, 'comanda plasata');

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

DROP TABLE IF EXISTS `product`;
CREATE TABLE IF NOT EXISTS `product` (
  `id` int(8) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) NOT NULL,
  `code` varchar(255) NOT NULL,
  `image` text NOT NULL,
  `price` double(10,2) NOT NULL,
  `description` text NOT NULL,
  `category` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=19 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `product`
--

INSERT INTO `product` (`id`, `name`, `code`, `image`, `price`, `description`, `category`) VALUES
(8, 'Jacheta', 'a1', 'images/jacheta.jpg', 100.26, 'jacheta', 'Imbracaminte'),
(10, 'Pantaloni ', 'pnt254', 'images/Pantaloni.jpg', 450.00, 'Pantaloni albastri barbati', 'Imbracaminte'),
(11, 'Bocanci La sportiva', 'bcn1258', 'images/bocanci.jpg', 1250.00, 'Bocanci drumetie', 'Incaltaminte'),
(12, 'Sosete Icebreaker', 'socks3456', 'images/sosete.jpg', 120.00, 'sosete lana merino', 'Imbracaminte'),
(13, 'Arzator MSR', 'arz1254', 'images/arzator.jpg', 1305.00, 'Arzator MSR gaz', 'Accesorii camping'),
(14, 'Cort MSR', 'crt15874', 'images/cort.jpg', 2850.00, 'Cort 2 persoane', 'Accesorii camping'),
(15, 'Ham escalada Black Diamond', 'ham158745', 'images/ham.jpg', 485.00, 'Ham escalada 100 kg max', 'Accesorii escalada'),
(16, 'Lonje catarare', 'lnj8520', 'images/lonje.jpg', 635.00, 'lonje CAMP asigurare y', 'Accesorii escalada'),
(17, 'Espadrile', 'esp84562', 'images/espadrile.jpg', 625.00, 'espadrile catarare', 'Accesorii alpinism'),
(18, 'Bluza Ortovox', 'blz7523', 'images/bluza.jpg', 450.00, 'Bluza lana merino ', 'Imbracaminte');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(100) NOT NULL,
  `user_type` varchar(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `email`, `user_type`) VALUES
(1, 'test', '$2y$10$OlEwwyWcFhpuavnn4jUmJeT5AwEYJzjJ4OHTvSHGENYJ6mzTvwBam', 'a@o.com', 'user'),
(2, 'admin', '$2y$10$kxD5.eWHMADMC85TMUInYOrw6oVAjzGN4VwSNY.7ZhRdMtjysfA3y', 'admin@admin.com', 'admin'),
(5, 'user', '$2y$10$jf80prjeMxvSevjH.XQan.iRLrOXNKWruKuIYkrVs4cChgQH0OyUG', 'user@user.com', 'user'),
(6, 'user1', '$2y$10$l.kJ3lH9Gmxa4825x8OMJe27kb8ZzCXXmn1UymU5WAZcp6kTVnQom', 'user@1.com', 'user'),
(7, 'user2', '$2y$10$/I5uuk9DBZlyi5OC3SNhy.YZ8Ooul/FLnPJLac7hwsUDXM0McEK8y', 'user@2.com', 'user'),
(8, 'user3', '$2y$10$0capHYXBGpHhhHFimhmbQOw6Y1p3kLEjEgDR8KLl4z2WbyF8Y0Lvm', 'user@3.com', 'user'),
(9, 'user4', '$2y$10$BSjNkP5kmyOy2QHKya.c/uPxaZgb90n4eypmsr9OHCDqwJ2U8hvcG', 'user@4.com', 'user'),
(10, 'user6', '$2y$10$7rifzkncF0Sp2nwT5/ZbA.tC2ds15BHda4K11Je1YQHjG/3OZ0vz6', 'user@6.com', 'user'),
(11, 'user5', '$2y$10$ABxY8ozQhcYTNuqfvljMu.MUR4TzTOEag/ZtRgnqnaGaHRKCX6Qzq', 'user@5.com', 'user'),
(12, 'admin2', '$2y$10$IKIT.jVCQhXpRQiD/nqD.eCAyiVMqIUsLDa46pFFpI8flclgOUWWS', 'admin@2.com', 'admin');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `client`
--
ALTER TABLE `client`
  ADD CONSTRAINT `fk_clientuser` FOREIGN KEY (`userId`) REFERENCES `users` (`id`);

--
-- Constraints for table `orderdetail`
--
ALTER TABLE `orderdetail`
  ADD CONSTRAINT `fk_orderdetailproductid` FOREIGN KEY (`productid`) REFERENCES `product` (`id`),
  ADD CONSTRAINT `fk_orderid` FOREIGN KEY (`orderid`) REFERENCES `orders` (`id`);

--
-- Constraints for table `orders`
--
ALTER TABLE `orders`
  ADD CONSTRAINT `fk_orderclientid` FOREIGN KEY (`clientid`) REFERENCES `client` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
