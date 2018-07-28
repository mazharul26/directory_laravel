-- phpMyAdmin SQL Dump
-- version 4.8.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jul 07, 2018 at 12:28 PM
-- Server version: 10.1.31-MariaDB
-- PHP Version: 7.2.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hockeygearshop`
--

DELIMITER $$
--
-- Procedures
--
CREATE DEFINER=`root`@`localhost` PROCEDURE `category` (IN `ids` INT)  BEGIN
SELECT categories.*, (select count(ads.id) from ads, cities where ads.city_id = cities.id AND ads.category_id=categories.id and cities.id=ids and ads.status=1) as total FROM categories ORDER by categories.name asc;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `category_country` (IN `ids` INT, IN `cntid` INT)  BEGIN
SELECT cities.*, (select count(ads.id) from ads, cities as c, states where ads.city_id = c.id AND c.state_id = states.id and ads.category_id=ids and ads.status=1 and c.id=cities.id AND states.country_id=cntid) as total FROM cities ORDER by cities.name asc; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `city` (IN `cntid` INT, IN `stid` INT, IN `ctid` INT)  BEGIN
SELECT categories.*, 
   (select count(ads.id) 
      from ads, cities, states, countries 
      where 
         ads.city_id = cities.id AND 
         cities.state_id=states.id AND 
         states.country_id=countries.id and 
         ads.category_id=categories.id and
         cities.id=ctid and 
         ads.status=1
   ) as total 
FROM categories ORDER by name asc;

SELECT c.*, 
   (select count(ads.id) 
      from ads, cities, states
      where 
         ads.city_id = cities.id AND 
         cities.state_id=states.id AND 
         states.id=stid and 
         ads.status=1 and 
         cities.id = c.id
   ) as total 
FROM cities as c ORDER by name asc;

SELECT s.*, 
   (select count(ads.id) 
      from ads, cities, states, countries 
      where 
         ads.city_id = cities.id AND 
         cities.state_id=states.id AND 
         states.country_id=countries.id and          
         countries.id=cntid and 
         ads.status=1 and
         states.id = s.id
   ) as total 
FROM states as s ORDER by name asc;

SELECT c.*, 
      (select count(ads.id) 
      from ads, cities, states, countries 
      where ads.city_id = cities.id AND 
         cities.state_id=states.id AND 
         states.country_id=countries.id and 
         ads.status=1 and
         countries.id=c.id
         ) as total 
FROM countries c where id=cntid 
ORDER by name asc;

select count(ads.id) total 
from ads, cities, states 
where ads.city_id = cities.id AND 
cities.state_id=states.id AND 
states.id=stid and 
ads.item_type=2 and 
ads.status=1;

select count(ads.id) total 
from ads, cities, states 
where ads.city_id = cities.id AND 
cities.state_id=states.id AND 
states.id=stid and 
ads.item_type=1 and 
ads.status=1;

select count(ads.id) total 
from ads, cities, states 
where ads.city_id = cities.id AND 
cities.state_id=states.id AND 
states.id=stid and 
ads.ads_type=2 and 
ads.status=1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `extra_free` (IN `type` INT, IN `ids` INT)  BEGIN
select categories.id, categories.name, cities.id ctid, (select count(ads.id) from ads where ads.category_id=categories.id and ads.city_id=cities.id and ads.ads_type=type) total
            from categories, ads, cities
            where categories.id = ads.category_id and
            ads.city_id = cities.id and            
            cities.id=ids and 
            ads.status = 1
            group by categories.id
           ; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `extra_new_used` (IN `type` INT, IN `ids` INT)  BEGIN
select categories.id, categories.name, cities.id ctid, (select count(ads.id) from ads where ads.category_id=categories.id and ads.city_id=cities.id and ads.item_type=type) total
            from categories, ads, cities
            where categories.id = ads.category_id and
            ads.city_id = cities.id and            
            cities.id=ids and 
            ads.status = 1
            group by categories.id
           ; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `extra_query` (IN `ids` INT)  BEGIN
select categories.id, categories.name, cities.id ctid, (select count(ads.id) from ads where ads.category_id=categories.id and ads.city_id=cities.id) total
            from categories, ads, cities
            where categories.id = ads.category_id and
            ads.city_id = cities.id and
            cities.id=ids AND
            ads.status = 1
            group by categories.id
           ; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `free_item` (IN `cid` INT)  BEGIN 
SELECT cities.*, (select count(ads.id) from ads where ads.city_id=cities.id and ads.status=1 AND ads.ads_type=2) as total FROM cities, states where cities.state_id=states.id AND states.country_id=cid ORDER by cities.name asc; 
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `home` (IN `cntid` INT, IN `stid` INT)  BEGIN
SELECT categories.*, 
   (select count(ads.id) 
      from ads, cities, states, countries 
      where 
         ads.city_id = cities.id AND 
         cities.state_id=states.id AND 
         states.country_id=countries.id and 
         ads.category_id=categories.id and
         states.id=stid and 
         ads.status=1
   ) as total 
FROM categories ORDER by name asc;

SELECT c.*, 
   (select count(ads.id) 
      from ads, cities, states
      where 
         ads.city_id = cities.id AND 
         cities.state_id=states.id AND 
         states.id=stid and 
         ads.status=1 and 
         cities.id = c.id
   ) as total 
FROM cities as c ORDER by name asc;

SELECT s.*, 
   (select count(ads.id) 
      from ads, cities, states, countries 
      where 
         ads.city_id = cities.id AND 
         cities.state_id=states.id AND 
         states.country_id=countries.id and          
         countries.id=cntid and 
         ads.status=1 and
         states.id = s.id
   ) as total 
FROM states as s ORDER by name asc;

SELECT c.*, 
      (select count(ads.id) 
      from ads, cities, states, countries 
      where ads.city_id = cities.id AND 
         cities.state_id=states.id AND 
         states.country_id=countries.id and 
         ads.status=1 and
         countries.id=c.id
         ) as total 
FROM countries c where id=cntid 
ORDER by name asc;

select count(ads.id) total 
from ads, cities, states 
where ads.city_id = cities.id AND 
cities.state_id=states.id AND 
states.id=stid and  
ads.item_type=2 and 
ads.status=1;

select count(ads.id) total 
from ads, cities, states 
where ads.city_id = cities.id AND 
cities.state_id=states.id AND 
states.id=stid and  
ads.item_type=1 and 
ads.status=1;

select count(ads.id) total 
from ads, cities, states 
where ads.city_id = cities.id AND 
cities.state_id=states.id AND 
states.id=stid and 
ads.ads_type=2 and 
ads.status=1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `home_city` (IN `ids` INT, IN `scid` INT)  BEGIN
SELECT categories.*, (select count(ads.id) from ads, cities, states, countries where ads.city_id = cities.id AND cities.state_id=states.id AND states.country_id=countries.id and ads.category_id=categories.id and countries.id=ids and ads.status=1) as total FROM categories ORDER by name asc;

SELECT cities.*, (select count(ads.id) from ads where ads.city_id=cities.id and ads.status=1) as total FROM cities, states, countries where cities.state_id=states.id AND states.country_id=countries.id and countries.id=ids ORDER by cities.name asc;

SELECT states.*, (select count(ads.id) from ads, cities where ads.city_id = cities.id AND cities.state_id=states.id and ads.status=1) as total FROM states where states.country_id=ids ORDER by name asc;

SELECT countries.*, (select count(ads.id) from ads, cities, states where ads.city_id = cities.id AND cities.state_id=states.id AND states.country_id=countries.id    and ads.status=1) as total FROM countries where id=ids ORDER by name asc;

select count(ads.id) total from ads, cities where ads.city_id = cities.id AND cities.id = scid and ads.item_type=2 and ads.status=1;

select count(ads.id) total from ads, cities where ads.city_id = cities.id AND cities.id = scid and ads.item_type=1 and ads.status=1;

select count(ads.id) total from ads, cities where ads.city_id = cities.id AND cities.id = scid and ads.ads_type=2 and ads.status=1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `home_country` (IN `ids` INT)  BEGIN
SELECT categories.*, (select count(ads.id) from ads, cities, states, countries where ads.city_id = cities.id AND cities.state_id=states.id AND states.country_id=countries.id and ads.category_id=categories.id and countries.id=ids and ads.status=1) as total FROM categories ORDER by name asc;

SELECT cities.*, (select count(ads.id) from ads where ads.city_id=cities.id and ads.status=1) as total FROM cities, states, countries where cities.state_id=states.id AND states.country_id=countries.id and countries.id=ids ORDER by cities.name asc;

SELECT states.*, (select count(ads.id) from ads, cities where ads.city_id = cities.id AND cities.state_id=states.id and ads.status=1) as total FROM states where states.country_id=ids ORDER by name asc;

SELECT countries.*, (select count(ads.id) from ads, cities, states where ads.city_id = cities.id AND cities.state_id=states.id AND states.country_id=countries.id    and ads.status=1) as total FROM countries where id=ids ORDER by name asc;

select count(ads.id) total from ads, cities, states where ads.city_id = cities.id AND cities.state_id=states.id AND states.country_id = ids and ads.item_type=2 and ads.status=1;

select count(ads.id) total from ads, cities, states where ads.city_id = cities.id AND cities.state_id=states.id AND states.country_id = ids and ads.item_type=1 and ads.status=1;

select count(ads.id) total from ads, cities, states where ads.city_id = cities.id AND cities.state_id=states.id AND states.country_id = ids and ads.ads_type=2 and ads.status=1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `home_state` (IN `ids` INT, IN `scid` INT)  BEGIN
SELECT categories.*, (select count(ads.id) from ads, cities, states, countries where ads.city_id = cities.id AND cities.state_id=states.id AND states.country_id=countries.id and ads.category_id=categories.id and countries.id=ids and ads.status=1) as total FROM categories ORDER by name asc;

SELECT cities.*, (select count(ads.id) from ads where ads.city_id=cities.id and ads.status=1) as total FROM cities, states, countries where cities.state_id=states.id AND states.country_id=countries.id and countries.id=ids ORDER by cities.name asc;

SELECT states.*, (select count(ads.id) from ads, cities where ads.city_id = cities.id AND cities.state_id=states.id and ads.status=1) as total FROM states where states.country_id=ids ORDER by name asc;

SELECT countries.*, (select count(ads.id) from ads, cities, states where ads.city_id = cities.id AND cities.state_id=states.id AND states.country_id=countries.id    and ads.status=1) as total FROM countries where id=ids ORDER by name asc;

select count(ads.id) total from ads, cities, states where ads.city_id = cities.id AND cities.state_id=states.id AND states.id = scid and ads.item_type=2 and ads.status=1;

select count(ads.id) total from ads, cities, states where ads.city_id = cities.id AND cities.state_id=states.id AND states.id = scid and ads.item_type=1 and ads.status=1;

select count(ads.id) total from ads, cities, states where ads.city_id = cities.id AND cities.state_id=states.id AND states.id = scid and ads.ads_type=2 and ads.status=1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `login` ()  BEGIN
UPDATE ads set status=3 
WHERE DATEDIFF(CURDATE(), DATE_FORMAT(FROM_UNIXTIME(UNIX_TIMESTAMP(posted)), '%Y-%m-%d')) >= 45 AND first_ad=1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `new_used_city` (IN `cntid` INT, IN `stid` INT, IN `ctid` INT, IN `type` INT)  BEGIN
SELECT categories.*, 
   (select count(ads.id) 
      from ads, cities, states, countries 
      where 
         ads.city_id = cities.id AND 
         cities.state_id=states.id AND 
         states.country_id=countries.id and 
         ads.category_id=categories.id and
         cities.id=ctid and 
         ads.item_type=type and
         ads.status=1
   ) as total 
FROM categories ORDER by name asc;

SELECT c.*, 
   (select count(ads.id) 
      from ads, cities, states
      where 
         ads.city_id = cities.id AND 
         cities.state_id=states.id AND 
         states.id=stid and
         ads.status=1 and
         ads.item_type=type and
         cities.id = c.id
   ) as total 
FROM cities as c ORDER by name asc;

SELECT s.*, 
   (select count(ads.id) 
      from ads, cities, states, countries 
      where 
         ads.city_id = cities.id AND 
         cities.state_id=states.id AND 
         states.country_id=countries.id and          
         countries.id=cntid and 
         ads.status=1 and
         ads.item_type=type and
         states.id = s.id
   ) as total 
FROM states as s ORDER by name asc;

SELECT c.*, 
      (select count(ads.id) 
      from ads, cities, states, countries 
      where ads.city_id = cities.id AND 
         cities.state_id=states.id AND 
         states.country_id=countries.id and 
         ads.status=1 and
         ads.item_type=type and
         countries.id=c.id
         ) as total 
FROM countries c where id=cntid 
ORDER by name asc;

select count(ads.id) total 
from ads, cities, states 
where ads.city_id = cities.id AND 
cities.state_id=states.id AND 
cities.id=ctid and  
ads.item_type=2 and 
ads.status=1;

select count(ads.id) total 
from ads, cities, states 
where ads.city_id = cities.id AND 
cities.state_id=states.id AND 
cities.id=ctid and
ads.item_type=1 and 
ads.status=1;

select count(ads.id) total 
from ads, cities, states 
where ads.city_id = cities.id AND 
cities.state_id=states.id AND 
cities.id=ctid and
ads.ads_type=2 and 
ads.status=1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `new_used_country` (IN `ids` INT, IN `type` INT)  BEGIN
SELECT categories.*, (select count(ads.id) from ads, cities, states, countries where ads.city_id = cities.id AND cities.state_id=states.id AND states.country_id=countries.id and ads.category_id=categories.id and countries.id=ids and ads.item_type=type and ads.status=1) as total FROM categories ORDER by name asc;

SELECT cities.*, (select count(ads.id) from ads where ads.city_id=cities.id and ads.status=1 and ads.item_type=type) as total FROM cities, states, countries where cities.state_id=states.id AND states.country_id=countries.id and countries.id=ids ORDER by cities.name asc;

SELECT states.*, (select count(ads.id) from ads, cities where ads.city_id = cities.id AND cities.state_id=states.id and ads.status=1 and ads.item_type=type) as total FROM states where states.country_id=ids ORDER by name asc;

SELECT countries.*, (select count(ads.id) from ads, cities, states where ads.city_id = cities.id AND cities.state_id=states.id AND states.country_id=countries.id    and ads.status=1 and ads.item_type=type) as total FROM countries where id=ids ORDER by name asc;

select count(ads.id) total from ads, cities, states where ads.city_id = cities.id AND cities.state_id=states.id AND states.country_id = ids and ads.item_type=type and ads.item_type=2 and ads.status=1;

select count(ads.id) total from ads, cities, states where ads.city_id = cities.id AND cities.state_id=states.id AND states.country_id = ids and ads.item_type=type and ads.item_type=1 and ads.status=1;

select count(ads.id) total from ads, cities, states where ads.city_id = cities.id AND cities.state_id=states.id AND states.country_id = ids and ads.item_type=type and ads.ads_type=2 and ads.status=1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `new_used_state` (IN `cntid` INT, IN `stid` INT, IN `type` INT)  BEGIN
SELECT categories.*, 
   (select count(ads.id) 
      from ads, cities, states, countries 
      where 
         ads.city_id = cities.id AND 
         cities.state_id=states.id AND 
         states.country_id=countries.id and 
         ads.category_id=categories.id and
         states.id=stid and 
         ads.item_type=type and
         ads.status=1
   ) as total 
FROM categories ORDER by name asc;

SELECT c.*, 
   (select count(ads.id) 
      from ads, cities, states
      where 
         ads.city_id = cities.id AND 
         cities.state_id=states.id AND 
         states.id=stid and 
         ads.status=1 and
         ads.item_type=type and
         cities.id = c.id
   ) as total 
FROM cities as c ORDER by name asc;

SELECT s.*, 
   (select count(ads.id) 
      from ads, cities, states, countries 
      where 
         ads.city_id = cities.id AND 
         cities.state_id=states.id AND 
         states.country_id=countries.id and          
         countries.id=cntid and 
         ads.status=1 and
         ads.item_type=type and
         states.id = s.id
   ) as total 
FROM states as s ORDER by name asc;

SELECT c.*, 
      (select count(ads.id) 
      from ads, cities, states, countries 
      where ads.city_id = cities.id AND 
         cities.state_id=states.id AND 
         states.country_id=countries.id and 
         ads.status=1 and
         ads.item_type=type and
         countries.id=c.id
         ) as total 
FROM countries c where id=cntid 
ORDER by name asc;

select count(ads.id) total 
from ads, cities, states 
where ads.city_id = cities.id AND 
cities.state_id=states.id AND 
states.id=stid and  
ads.item_type=2 and 
ads.status=1;

select count(ads.id) total 
from ads, cities, states 
where ads.city_id = cities.id AND 
cities.state_id=states.id AND 
states.id=stid and 
ads.item_type=1 and 
ads.status=1;

select count(ads.id) total 
from ads, cities, states 
where ads.city_id = cities.id AND 
cities.state_id=states.id AND 
states.id=stid and 
ads.ads_type=2 and 
ads.status=1;
END$$

CREATE DEFINER=`root`@`localhost` PROCEDURE `state` (IN `ids` INT)  BEGIN
SELECT states.*, (select count(ads.id) from ads, cities where ads.city_id = cities.id AND cities.state_id=states.id    and ads.status=1) as total FROM states where states.country_id=ids ORDER by name asc;
END$$

DELIMITER ;

-- --------------------------------------------------------

--
-- Table structure for table `ads`
--

CREATE TABLE `ads` (
  `id` int(10) UNSIGNED NOT NULL,
  `category_id` tinyint(3) UNSIGNED NOT NULL,
  `ads_type` tinyint(3) UNSIGNED NOT NULL,
  `price` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `title` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci,
  `email` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `receive_email` tinyint(4) NOT NULL,
  `website` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `item_type` tinyint(4) NOT NULL DEFAULT '1',
  `commercial` tinyint(4) NOT NULL DEFAULT '1',
  `status` tinyint(4) NOT NULL DEFAULT '4',
  `city_id` smallint(5) UNSIGNED NOT NULL,
  `visited` mediumint(8) UNSIGNED NOT NULL DEFAULT '0',
  `picture1` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `picture2` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `picture3` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `picture4` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `customer_id` int(10) UNSIGNED NOT NULL,
  `posted` date DEFAULT NULL,
  `paid` tinyint(4) NOT NULL DEFAULT '0',
  `first_ad` tinyint(4) NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `ads`
--

INSERT INTO `ads` (`id`, `category_id`, `ads_type`, `price`, `title`, `description`, `email`, `receive_email`, `website`, `phone`, `postal_code`, `item_type`, `commercial`, `status`, `city_id`, `visited`, `picture1`, `picture2`, `picture3`, `picture4`, `customer_id`, `posted`, `paid`, `first_ad`, `created_at`, `updated_at`) VALUES
(3, 3, 2, 0, 'Looking for Pro Clash of Clans players', 'Looking for Pro Clash of Clans players', 'hasancse016@gmail.com', 2, 'https://www.usedvictoria.com/classified-ad/Gerber-guthook-hunting-knife-and-spare-blades_29013919', '01674086310', '12584', 1, 2, 1, 68, 9, 'png', 'png', 'png', 'png', 1, '0000-00-00', 0, 0, NULL, '2018-06-22 18:00:00'),
(4, 3, 2, 1334, 'Gerber guthook hunting knife and spare blades', 'Gerber guthook hunting knife and spare blades', 'hasancse016@gmail.com', 2, 'https://www.usedvictoria.com/classified-ad/Gerber-guthook-hunting-knife-and-spare-blades_29013919', '01674086310', '1258', 2, 2, 1, 6, 3, 'png', NULL, NULL, NULL, 1, '0000-00-00', 0, 0, '2018-06-22 18:00:00', NULL),
(5, 3, 2, 1334, 'Gerber guthook hunting knife and spare blades', 'Gerber guthook hunting knife and spare blades Gerber guthook hunting knife and spare blades', 'hasancse016@gmail.com', 2, 'https://www.usedvictoria.com/classified-ad/Gerber-guthook-hunting-knife-and-spare-blades_29013919', '01674086310', NULL, 2, 2, 1, 1, 25, 'png', 'png', 'png', '', 1, '2018-06-25', 0, 0, '2018-06-23 18:00:00', '2018-06-24 18:00:00'),
(6, 5, 2, 258, 'Looking for Pro Clash of Clans players', 'Looking for Pro Clash of Clans players Looking for Pro Clash of Clans players Looking for Pro Clash of Clans players', 'hasancse016@gmail.com', 2, NULL, NULL, NULL, 2, 2, 1, 2, 6, 'png', NULL, NULL, NULL, 1, '0000-00-00', 0, 0, '2018-06-23 18:00:00', NULL),
(7, 5, 1, 1786, 'Looking for Pro Clash of Clans players', 'Looking for Pro Clash of Clans players', 'hasancse016@gmail.com', 2, NULL, NULL, NULL, 2, 2, 1, 68, 40, 'png', NULL, NULL, NULL, 1, '0000-00-00', 0, 0, '2018-06-23 18:00:00', NULL),
(8, 3, 2, 1334, 'Looking for Pro Clash of Clans players', 'Looking for Pro Clash of Clans players', 'hasancse016@gmail.com', 2, NULL, NULL, NULL, 2, 2, 1, 1, 0, 'png', NULL, NULL, NULL, 1, '2018-03-01', 0, 0, '2018-06-23 18:00:00', NULL),
(9, 3, 2, 0, 'Gerber guthook hunting knife and spare blades', 'Looking for Pro Clash of Clans players', 'hasancse016@gmail.com', 2, NULL, NULL, NULL, 1, 2, 1, 68, 9, 'png', '', '', '', 1, '2018-06-26', 0, 1, '2018-06-23 18:00:00', '2018-06-25 18:00:00'),
(10, 3, 1, 1334, 'Gerber guthook hunting knife and spare blades', 'asf as assad sa sa sa', 'hasancsdffse016@gmail.com', 2, 'https://www.usedvictoria.com/classified-ad/Gerber-guthook-hunting-knife-and-spare-blades_29013919', '01674086310', '5857', 2, 2, 1, 1, 0, 'png', 'png', NULL, NULL, 4, '2018-06-01', 0, 1, '2018-06-24 18:00:00', NULL),
(11, 5, 2, 0, 'Gerber guthook hunting knife and spare blades', 'Gerber guthook hunting knife and spare bladesGerber guthook hunting knife and spare blades', 'hasancse016@gmail.com', 2, NULL, NULL, NULL, 2, 2, 1, 3, 2, NULL, NULL, NULL, NULL, 1, '2018-06-27', 0, 0, '2018-06-26 18:00:00', NULL),
(12, 2, 2, 0, '111 Gerber guthook hunting knife and spare blades', '111 Gerber guthook hunting knife and spare blades111 Gerber guthook hunting knife and spare blades111 Gerber guthook hunting knife and spare blades', 'hasancse016@gmail.com', 2, NULL, NULL, NULL, 2, 2, 1, 68, 0, NULL, NULL, NULL, NULL, 1, '2018-06-27', 0, 0, '2018-06-26 18:00:00', NULL),
(13, 3, 2, 0, 'Gerber guthook hunting knife and spare blades', 'Gerber guthook hunting knife and spare blades', 'hasancse016@gmail.com', 2, NULL, NULL, NULL, 2, 2, 1, 68, 3, NULL, NULL, NULL, NULL, 1, '2018-06-30', 0, 0, '2018-06-26 18:00:00', '2018-06-29 18:00:00'),
(14, 3, 1, 1334, 'Gerber guthook hunting knife and spare blades', 'fafdsa fs', 'sk.hasan6310@gmail.com', 2, NULL, NULL, NULL, 2, 2, 1, 1, 0, NULL, NULL, NULL, NULL, 3, '2018-06-29', 0, 1, '2018-06-28 18:00:00', NULL),
(15, 3, 1, 1334, 'Gerber guthook hunting knife and spare blades', 'Gerber guthook hunting knife and spare blades', 'hasancse016@gmail.com', 2, NULL, NULL, NULL, 2, 1, 1, 1, 0, NULL, NULL, NULL, NULL, 1, '2018-06-30', 0, 0, '2018-06-28 18:00:00', '2018-06-29 18:00:00'),
(16, 5, 1, 1334, 'Gerber guthook hunting knife and spare blades', 'Gerber guthook hunting knife and spare bladesGerber guthook hunting knife and spare bladesGerber guthook hunting knife and spare blades', 'afdsadfsfdsadfafsafdf@gmail.com', 2, NULL, NULL, NULL, 1, 1, 1, 1, 0, NULL, NULL, NULL, NULL, 7, '2018-06-29', 0, 1, '2018-06-28 18:00:00', NULL),
(17, 3, 1, 1334, 'Gerber guthook hunting knife and spare blades', 'Gerber guthook hunting knife and spare blades', 'sk.haddsan6310@gmail.com', 2, NULL, NULL, NULL, 1, 1, 1, 1, 0, 'png', '', '', '', 8, '2018-06-29', 0, 1, '2018-06-28 18:00:00', '2018-06-28 18:00:00'),
(18, 3, 1, 1334, 'Gerber guthook hunting knife and spare blades', 'Gerber guthook hunting knife and spare bladesGerber guthook hunting knife and spare bladesGerber guthook hunting knife and spare blades', 'afdsadd58f@gmail.com', 2, NULL, NULL, NULL, 1, 1, 1, 1, 0, 'png', '', '', '', 9, '2018-06-29', 0, 1, '2018-06-28 18:00:00', '2018-06-28 18:00:00'),
(19, 3, 1, 1334, 'Gerber guthook hunting knife and spare bladess', 'Gerber guthook hunting knife and spare blades', 'hasancse016@gmail.com', 2, NULL, NULL, NULL, 1, 1, 1, 1, 0, NULL, NULL, NULL, NULL, 1, '2018-06-30', 0, 0, '2018-06-28 18:00:00', '2018-06-29 18:00:00'),
(20, 3, 2, 0, 'Gerber guthook hunting knife and spare blades', 'asf sadfsf s fsa f asf das', 'afdsa4532d4ddf@gmail.com', 2, NULL, NULL, NULL, 1, 1, 1, 3, 0, NULL, NULL, NULL, NULL, 10, '2018-06-30', 0, 1, '2018-06-29 18:00:00', '2018-06-29 18:00:00'),
(21, 5, 2, 0, 'Gerber guthook hunting knife and spare blades', 'Gerber guthook hunting knife and spare blades Gerber guthook hunting knife and spare blades', 'hasancsed016@gmail.com', 2, NULL, NULL, NULL, 1, 1, 1, 1, 0, NULL, NULL, NULL, NULL, 11, '2018-06-30', 0, 1, '2018-06-29 18:00:00', '2018-06-29 18:00:00'),
(22, 3, 2, 0, 'Gerber guthook hunting knife and spare blades', 'fasdfas sad', 'hasancsed016@gmail.com', 2, NULL, NULL, NULL, 1, 1, 1, 6, 0, NULL, NULL, NULL, NULL, 1, '2018-06-30', 0, 0, '2018-06-29 18:00:00', NULL);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Shirt', NULL, NULL),
(2, 'Pants', NULL, NULL),
(3, 'Elbow Pads', NULL, NULL),
(4, 'Jock', NULL, NULL),
(5, 'Jersey/Socks', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `state_id` smallint(5) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `cities`
--

INSERT INTO `cities` (`id`, `name`, `state_id`, `created_at`, `updated_at`) VALUES
(1, 'Abbotsford', 2, NULL, NULL),
(2, 'Armstrong', 2, NULL, NULL),
(3, 'Burnaby', 2, NULL, NULL),
(4, 'Adelanto', 7, NULL, NULL),
(5, 'Agoura Hills', 7, NULL, NULL),
(6, 'BAIE-DURFÉ', 1, NULL, NULL),
(68, 'Victoria', 2, NULL, NULL),
(69, 'White Rock', 2, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` tinyint(3) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `countries`
--

INSERT INTO `countries` (`id`, `name`, `created_at`, `updated_at`) VALUES
(1, 'Canada', NULL, NULL),
(2, 'USA', NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `customers`
--

CREATE TABLE `customers` (
  `id` int(10) UNSIGNED NOT NULL,
  `username` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(100) COLLATE utf8mb4_unicode_ci NOT NULL,
  `picture` varchar(4) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `first_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `last_name` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `location_name` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `postal_code` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `description` mediumtext COLLATE utf8mb4_unicode_ci,
  `phone` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `commercial_seller` tinyint(4) NOT NULL DEFAULT '1',
  `password` char(32) COLLATE utf8mb4_unicode_ci NOT NULL,
  `auth` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `status` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `type` tinyint(4) NOT NULL DEFAULT '1',
  `quotes` smallint(5) UNSIGNED NOT NULL DEFAULT '1',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `customers`
--

INSERT INTO `customers` (`id`, `username`, `email`, `picture`, `first_name`, `last_name`, `location_name`, `postal_code`, `description`, `phone`, `commercial_seller`, `password`, `auth`, `status`, `type`, `quotes`, `created_at`, `updated_at`) VALUES
(1, 'hasancse016', 'hasancse016@gmail.com', 'png', 'Sk', 'Abul Hasan', 'Adelanto', NULL, NULL, NULL, 0, '202cb962ac59075b964b07152d234b70', '1', '', 2, 5, NULL, NULL),
(2, 'hockeygearshop', 'ceo@hockeygearshop.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'e10adc3949ba59abbe56e057f20f883e', '1', NULL, 2, 1, NULL, NULL),
(3, 'sk.hasan6310931', 'sk.hasan6310@gmail.com', '', 'Sk', 'Hasan', NULL, NULL, NULL, NULL, 0, '202cb962ac59075b964b07152d234b70', '1', '', 1, 0, NULL, NULL),
(4, 'hasancsdffse016568', 'hasancsdffse016@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'a953caa6e670b32a51234e712b94f574', '1', 'Tpf69OWSMpE33KL26gKC', 1, 0, NULL, NULL),
(5, 'hasancse016dd', 'sk.hadfdsan6310@gmail.com', 'png', NULL, NULL, 'Abbotsford', NULL, NULL, NULL, 1, 'a953caa6e670b32a51234e712b94f574', '1', '', 1, 1, NULL, NULL),
(6, 'hockeygearshopf', 'afdsaddf@gmail.com', '', NULL, NULL, NULL, NULL, NULL, NULL, 1, 'a953caa6e670b32a51234e712b94f574', '1', 'oIwTN5W2mHbpioX86kdQ', 1, 1, NULL, NULL),
(7, 'afdsadfsfdsadfafsafdf587', 'afdsadfsfdsadfafsafdf@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'e10adc3949ba59abbe56e057f20f883e', '1', 'eaH9dOw3lIt9wDGoQ8n0', 1, 0, NULL, NULL),
(8, 'sk.haddsan6310255', 'sk.haddsan6310@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'e10adc3949ba59abbe56e057f20f883e', '1', 'ciFymAIIkHeI1UoRKb08', 1, 0, NULL, NULL),
(9, 'afdsadd58f623', 'afdsadd58f@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'e10adc3949ba59abbe56e057f20f883e', '1', 'YrsKKksePh7BnD0KGKEb', 1, 0, NULL, NULL),
(10, 'afdsa4532d4ddf216', 'afdsa4532d4ddf@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'e10adc3949ba59abbe56e057f20f883e', '1', 'J1y0rvnPXU4PB5GspV1O', 1, 0, NULL, NULL),
(11, 'hasancsed016665', 'hasancsed016@gmail.com', NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1, 'e10adc3949ba59abbe56e057f20f883e', '1', 'wDvUcA2Qvif2FkuWnm3G', 1, 0, NULL, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(7, '2018_06_19_155405_create_customers_table', 1),
(8, '2018_06_19_164200_create_countries_table', 1),
(9, '2018_06_19_164234_create_states_table', 1),
(10, '2018_06_19_165030_create_cities_table', 1),
(11, '2018_06_21_140346_create_categories_table', 1),
(12, '2018_06_21_140415_create_ads_table', 1);

-- --------------------------------------------------------

--
-- Table structure for table `states`
--

CREATE TABLE `states` (
  `id` smallint(5) UNSIGNED NOT NULL,
  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL,
  `country_id` tinyint(3) UNSIGNED NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `states`
--

INSERT INTO `states` (`id`, `name`, `country_id`, `created_at`, `updated_at`) VALUES
(1, 'Alberta', 1, NULL, NULL),
(2, 'British Columbia', 1, NULL, NULL),
(3, 'Manitoba', 1, NULL, NULL),
(4, 'New Brunswick', 1, NULL, NULL),
(5, 'Newfoundland and Labrador', 1, NULL, NULL),
(6, 'Northwest Territories', 1, NULL, NULL),
(7, 'California', 2, NULL, NULL),
(8, 'Alabama', 2, NULL, NULL),
(9, 'Alaska', 2, NULL, NULL),
(10, 'Arizona', 2, NULL, NULL),
(11, 'Arkansas', 2, NULL, NULL);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ads`
--
ALTER TABLE `ads`
  ADD PRIMARY KEY (`id`),
  ADD KEY `ads_category_id_foreign` (`category_id`),
  ADD KEY `ads_city_id_foreign` (`city_id`),
  ADD KEY `ads_customer_id_foreign` (`customer_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `categories_name_unique` (`name`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `name` (`name`,`state_id`),
  ADD KEY `cities_state_id_foreign` (`state_id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `countries_name_unique` (`name`);

--
-- Indexes for table `customers`
--
ALTER TABLE `customers`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `customers_username_unique` (`username`),
  ADD UNIQUE KEY `customers_email_unique` (`email`);

--
-- Indexes for table `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `states`
--
ALTER TABLE `states`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `states_name_unique` (`name`),
  ADD KEY `states_country_id_foreign` (`country_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ads`
--
ALTER TABLE `ads`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=70;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` tinyint(3) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `customers`
--
ALTER TABLE `customers`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT for table `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `states`
--
ALTER TABLE `states`
  MODIFY `id` smallint(5) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ads`
--
ALTER TABLE `ads`
  ADD CONSTRAINT `ads_category_id_foreign` FOREIGN KEY (`category_id`) REFERENCES `categories` (`id`),
  ADD CONSTRAINT `ads_city_id_foreign` FOREIGN KEY (`city_id`) REFERENCES `cities` (`id`),
  ADD CONSTRAINT `ads_customer_id_foreign` FOREIGN KEY (`customer_id`) REFERENCES `customers` (`id`);

--
-- Constraints for table `cities`
--
ALTER TABLE `cities`
  ADD CONSTRAINT `cities_state_id_foreign` FOREIGN KEY (`state_id`) REFERENCES `states` (`id`);

--
-- Constraints for table `states`
--
ALTER TABLE `states`
  ADD CONSTRAINT `states_country_id_foreign` FOREIGN KEY (`country_id`) REFERENCES `countries` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
