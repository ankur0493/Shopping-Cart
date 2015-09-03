SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";

/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;


CREATE TABLE IF NOT EXISTS `cart_details` (
  `cart_id` int(4) NOT NULL,
  `product_id` bigint(14) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `invoices` (
  `invoice_id` int(4) NOT NULL,
  `cust_name` varchar(20) NOT NULL,
  `cust_tel` bigint(10) NOT NULL,
  `invoice_date` date NOT NULL,
  `invoice_time` time NOT NULL,
  `invoice_total` decimal(4,0) NOT NULL,
  UNIQUE KEY `invoice_id` (`invoice_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `operators` (
  `operator_username` varchar(20) NOT NULL,
  `operator_pass` varchar(20) NOT NULL,
  `operator_name` varchar(30) NOT NULL,
  `operator_id` int(10) NOT NULL,
  UNIQUE KEY `operator_username` (`operator_username`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

CREATE TABLE IF NOT EXISTS `products` (
  `prod_id` bigint(13) NOT NULL,
  `prod_name` text NOT NULL,
  `prod_price` decimal(4,0) NOT NULL,
  UNIQUE KEY `prod_id` (`prod_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
