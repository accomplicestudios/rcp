-- phpMyAdmin SQL Dump
-- version 3.5.2
-- http://www.phpmyadmin.net
--
-- Host: internal-db.s227232.gridserver.com
-- Generation Time: May 21, 2019 at 12:46 PM
-- Server version: 5.6.32-78.1
-- PHP Version: 5.3.29

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `db227232_prod`
--

-- --------------------------------------------------------

--
-- Table structure for table `accounts`
--

CREATE TABLE IF NOT EXISTS `accounts` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login_name` varchar(32) NOT NULL,
  `login_pwd` varchar(32) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Dumping data for table `accounts`
--

INSERT INTO `accounts` (`id`, `login_name`, `login_pwd`) VALUES
(1, 'miches', '0sxle0pard!!!'),
(2, 'azi', '4rtofwar794@!'),
(3, 'rebecca', '4rtofwar794@!');

-- --------------------------------------------------------

--
-- Table structure for table `artists`
--

CREATE TABLE IF NOT EXISTS `artists` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `last_name` varchar(255) NOT NULL DEFAULT '',
  `first_name` varchar(255) DEFAULT NULL,
  `cv` varchar(255) NOT NULL,
  `press` varchar(255) DEFAULT NULL,
  `list_image_desktop` text,
  `list_image_tablet` text NOT NULL,
  `slug` varchar(255) NOT NULL,
  `is_published` int(11) DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `name` (`last_name`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=37 ;

--
-- Dumping data for table `artists`
--

INSERT INTO `artists` (`id`, `last_name`, `first_name`, `cv`, `press`, `list_image_desktop`, `list_image_tablet`, `slug`, `is_published`) VALUES
(29, 'Babirye', 'Leilah', 'Leilah_Babirye_CV.pdf', NULL, '1abf4f52aec21d3e2de8396752015fbd.png', 'f79084f39982db903c2a3888cf3c6a45.png', 'leilah-babirye', 1),
(30, 'Khoury', 'Sahar', 'Sahar_Khoury_CV.pdf', NULL, '3bf03680a9354bcb49465704e839c858.png', 'db1e1f83a687cb66a992e284cae4b345.png', 'sahar-khoury', 1),
(31, 'Valdez', 'Vincent', 'Vincent_Valdez_CV.pdf', NULL, 'b55ee5fa85a19cd4ce8b14c0a02a80ab.png', 'c9b19d2166405f6c884a2db7a3be9077.png', 'vincent-valdez', 1),
(32, 'Matson', 'Christy', 'Christy_Matson_CV.pdf', NULL, '7e2d2666d6dd64cd12dad5167046c150.png', '3482dd15e9509bc61b794f17ef5c6982.png', 'christy-matson', 1),
(33, 'Lee II', 'El Franco', 'El_Franco_Lee_II_CV.pdf', NULL, '3cd8809a9c6ccf0b46f3c15810353bfa.png', 'e233ece02891757bbb23b28f40c7a355.png', 'el-franco-lee-ii', 1),
(34, 'Jansons', 'Max', 'Max_Jansons_CV.pdf', NULL, '2f397c8994f1f8f8c13ea7bec2a9b4a4.png', 'c1f63de9a88a6c798bd8a648966dee7b.png', 'max-jansons', 1),
(35, 'Gilbert', 'David', 'David_Gilbert_CV.pdf', NULL, '038eaf55098de42f5f23d731968e482b.png', 'df3d2b6be84b0b26b64f69f04c280d70.png', 'david-gilbert', 1),
(36, 'Ball', 'Natalie', 'Natalie_Ball_CV.pdf', NULL, '338c5b591d72d62934998c9327fbefdc.png', 'a11786f09ea7bbcfcf42c52950e47d28.png', 'nathalie-ball', 1);

-- --------------------------------------------------------

--
-- Table structure for table `artist_photos`
--

CREATE TABLE IF NOT EXISTS `artist_photos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `artist_id` int(10) unsigned NOT NULL,
  `filename` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `position` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id` (`artist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `artist_photos`
--

INSERT INTO `artist_photos` (`id`, `artist_id`, `filename`, `description`, `position`) VALUES
(1, 29, 'ce963e66229082801d4f725bd0c82c7e.png', 'Omumbejja Sangalyabongo (The Only Daughter of Nagginda,The Wedded Queen of Buganda), 2018, Wood, metal, nails, glue and found objects, 32 ½ x 8 ¼ x 9 inches, 82.6 x 21 x 22.9 cm', 1),
(2, 30, '87c9ea02694f3cf26bd82c4a3b5ac29f.jpg', 'Untitled (1948/1995, 1953/1979), 2017, Paper textile mache, steel, cast cement and ceramic, In 11 parts, 60 x 60 x 24 inches each, 152.4 x 152.4 x 61 cm each', 5),
(3, 31, 'c9ed4a333520556edd07b5d4e8b5cf14.png', 'Untitled, 2017, Lithograph crayon on mylar, In two parts, 14 x 11 inches each, 35.6 x 27.9 cm each', 1),
(4, 32, '56a3de6aa69fe4449878370821e8ce04.png', 'Untitled, 2019, Paper, spray paint, cotton and linen, 20 x 20 inches, 50.8 x 50.8 cm', 1),
(5, 33, '35f9c1bd366767428f8486fc9b17b7b5.png', 'The Red, White, Black, & Blue, 2015, Acrylic on canvas, 40 x 48 inches, 101.6 x 121.9 cm', 1),
(6, 34, '2649636470144e2de1aee321a97f1e77.jpg', 'Gold, 2018/2019, Oil on linen, 30 x 36 inches, 76.2 x 91.4 cm', 1),
(7, 35, '70c4c8f0bf530754d392b5d91e2217a2.png', 'Lit Up, 2019, Archival inkjet print, 40 x 30 inches, 101.6 x 76.2 cm', 1),
(8, 36, '5e357181174fa3fed5eb6b988ff6e1dc.png', 'Bang Bang, 2019, Elk hide, rope, rabbit fur, acrylic paint, waxed thread, oil stick, cotton and wool, 84 x 124 inches, 213.4 x 315 cm', 1),
(9, 30, '845d776148f98dd6972349a0437de95b.jpg', 'Untitled (holder of tomato cage), 2019, Glazed ceramic, paper-textile-mâché, acrylic, reflector tape, 51 1/4 x 14 1/2 x 3 inches,  130.2 x 36.8 x 7.6 cm', 1),
(10, 30, '2775b0a6b91f09f87fe5970b2ede23bd.jpg', 'Untitled (glaze tests), 2019, Paper-textile-mâché, glazed ceramic, resin, paint, 32 x 25 x 3 inches,  81.3 x 63.5 x 7.6 cm', 2),
(11, 30, '8b8649cd40df99397930f5b3b485cfdd.jpg', 'Untitled (Esther on paper pedestal), 2019, Paper-textile-mâché, metal, ceramic, inkjet photo collage, 57 x 8 x 6 1/2 inches , 144.8 x 20.3 x 16.5 cm', 3),
(12, 30, 'e0408e45755f113804b541284dce50d0.jpg', 'Untitled (Esther on paper pedestal), 2019, Paper-textile-mâché, metal, ceramic, inkjet photo collage, 57 x 8 x 6 1/2 inches , 144.8 x 20.3 x 16.5 cm', 4);

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `url` varchar(255) CHARACTER SET latin1 NOT NULL,
  `section_id` int(11) NOT NULL,
  `type` varchar(16) CHARACTER SET latin1 NOT NULL,
  `expander` text CHARACTER SET latin1 NOT NULL,
  `seq` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `name` (`name`,`url`),
  KEY `section_id` (`section_id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=70 ;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `url`, `section_id`, `type`, `expander`, `seq`) VALUES
(39, 'Hours', 'hours', 2, 'normal', '', 100),
(51, 'View All', 'list', 4, 'normal', '', 100),
(57, 'Drafts', 'list/drafts', 3, 'normal', '', 80),
(41, 'Parking', 'parking', 2, 'normal', '', 300),
(50, 'New Artist', 'add', 3, 'normal', '', 200),
(40, 'Public Transportation', 'public_transportation', 2, 'normal', '', 200),
(49, 'View All', 'list', 3, 'normal', '', 100),
(52, 'New Exhibition', 'add', 4, 'normal', '', 200),
(46, 'Tagline', 'tagline', 2, 'normal', '', 50),
(47, '-', '', 2, 'divider', '', 51),
(53, 'View All', 'list', 5, 'normal', '', 100),
(54, 'New Item', 'add', 5, 'normal', '', 200),
(55, '-', '', 2, 'divider', '', 54),
(56, 'Photo', 'photo', 2, 'normal', '', 52),
(58, 'Published', 'list/published', 3, 'normal', '', 70),
(59, '-', '', 3, 'divider', '', 110),
(60, 'Published', 'list/published', 4, 'normal', '', 50),
(61, 'Drafts', 'list/drafts', 4, 'normal', '', 60),
(62, '-', '-', 4, 'divider', '', 110),
(63, 'Published', 'list/published', 5, 'normal', '', 50),
(64, 'Drafts', 'list/drafts', 5, 'normal', '', 60),
(65, '-', '-', 5, 'divider', '', 110),
(66, 'Current', 'list/current', 4, 'normal', '', 20),
(67, 'Upcoming', 'list/upcoming', 4, 'normal', '', 30),
(68, 'Past', 'list/past', 4, 'normal', '', 40),
(69, '-', '-', 4, 'divider', '', 41);

-- --------------------------------------------------------

--
-- Table structure for table `ci_sessions`
--

CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(128) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned NOT NULL DEFAULT '0',
  `data` blob NOT NULL,
  KEY `ci_sessions_timestamp` (`timestamp`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data for table `ci_sessions`
--

INSERT INTO `ci_sessions` (`id`, `ip_address`, `timestamp`, `data`) VALUES
('5756e18621b093365c8e4ef1aa22d171b269ab1b', '110.54.229.246', 1558379425, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383337393333313b),
('a7cdb0853610b5e4f0df397a8933e38a90c5df2a', '110.54.161.30', 1558379899, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383337393634343b),
('ca6586481f2b62174870f9c529931240979feb8f', '110.54.161.30', 1558379905, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383337393634383b6c6f676765645f696e7c623a313b),
('3c46d3b1ed9aab835199d4df57a63eedf9589969', '110.54.161.30', 1558380036, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383337393934393b),
('425e57e694f2e27e75b7f89d727e1ba9687e84c3', '110.54.161.30', 1558380364, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383338303336343b6c6f676765645f696e7c623a313b),
('63baae12c582a9975fa21c17aacdb838fdbb6c24', '110.54.161.30', 1558382368, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383338323336383b6c6f676765645f696e7c623a313b),
('4852615fe566953bc14d8ae75dc3e1954bb31067', '66.87.118.120', 1558380500, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383338303530303b),
('e37ace68990332021cab50b61023049f4a6bf74d', '99.124.158.112', 1558381002, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383338303937393b),
('d850239b10063a828b618949ac3349f99ea39ea3', '110.54.161.30', 1558381941, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383338313934313b6c6f676765645f696e7c623a313b),
('b2f8dd23531fe1897bad27e80f95f7eb2128e403', '110.54.161.30', 1558382368, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383338323336383b6c6f676765645f696e7c623a313b),
('d025d8e39cf602c789cebf7232bba5da609c1693', '110.54.161.30', 1558382853, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383338323835333b),
('371040d1cb0a8c3c6535907ed81c6c65a99dd229', '110.54.161.30', 1558382853, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383338323835333b),
('81cbda7fda3d783ef5d0daca05a46954ad3da8c9', '54.208.102.37', 1558384107, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383338343130373b),
('175a18e3c24fb83fff1d3b43cab1d91ad1aa4a73', '71.198.120.152', 1558384269, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383338343232333b),
('1a54e1249f1a8a3dc260d22f71075ea8f6701da4', '76.14.126.105', 1558384229, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383338343232393b),
('aa6e9dd5287d28e516a2ead26c195888973cd6df', '24.225.22.189', 1558390053, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383339303034303b),
('579d4873b06c9376248e91644f5da48dca72a3b0', '104.248.12.43', 1558391616, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383339313631363b),
('d48c4b919c9d002781b0c05af8eb0a8bf3dec452', '76.103.10.70', 1558391773, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383339313737333b),
('ea7750578b02a81cc31029f434eeedd370caab74', '108.184.0.251, ', 1558393936, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383339333933363b),
('1fcbf1f9b0e0b759044b0446f12074397cc86104', '66.249.87.28', 1558397466, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383339373436363b),
('0e2882ceec42f1ef612300d1c2b87a0eb20b9d74', '107.219.192.88', 1558398026, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383339383032333b),
('f479541a56d2aa732dd423810a8087b4ece9e128', '172.91.129.122', 1558398058, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383339383035323b),
('edd96037e29fc87924a856e3d1e60b9073ab4197', '35.237.171.154', 1558399843, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383339393834333b),
('27e563a23c8442c08da1b675550d4a4962505ff5', '35.237.171.154', 1558400486, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383430303438363b),
('b0f0c4d32258c61bb44ec3ee5e237229fa543dba', '66.249.87.220', 1558400352, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383430303335323b),
('9f4004495440422b9f062dc3a97fd92f27027d6f', '66.249.87.218', 1558400353, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383430303335333b),
('e52b829fff6a1fb9784bdf8b7763fc9e9d9fa95a', '77.88.5.32', 1558400379, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383430303337393b),
('eb23d19cdbe4a0ff4283409444d7332a2c542126', '35.237.171.154', 1558401090, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383430313039303b),
('e469f16075c36136d0d2f96298c17235dcdddb83', '54.36.149.56', 1558400773, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383430303737333b),
('6163a84b9c6d1dcff7fb5f3556dedfa24b990b42', '35.237.171.154', 1558401090, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383430313039303b),
('e94397f8011e03133be3dd6b27e3efdab8adcc6f', '205.243.127.182', 1558401111, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383430313131313b),
('c7fb413f1971cb28ab1cd0879d3f33aec20f3f42', '66.249.69.213', 1558401573, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383430313537333b),
('2434eb738967ec21073bedd79dbb5d7a48927b03', '185.127.18.113', 1558402370, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383430323337303b),
('2a5d69c588ec1ce2b7d94b155c9a5f81512815c4', '185.127.18.113', 1558402370, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383430323337303b),
('6090331da18238c9b1053c8091e347d5eb9a0874', '73.92.246.158', 1558403330, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383430333239313b),
('cdf63d375fd8b64459435e5673be936334a48fee', '73.158.237.81', 1558404314, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383430343237323b),
('f2ac4fec6d7fda917c8771b151042170387e19dd', '66.220.149.10', 1558404351, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383430343335313b),
('8613ba8ae3e4b3f33ce4334ed61c9acb91051d97', '66.220.149.46', 1558404352, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383430343335323b),
('0d7b4f167392d0d63e6fb94455846ea547cdbf85', '157.230.119.225', 1558406275, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383430363237353b),
('44f8476e7e100b0631259279f82ff07cd67cfb61', '66.249.87.220', 1558406886, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383430363838363b),
('ecb090d2d012b4695f0c61559932c87a2005c502', '66.249.87.220', 1558407384, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383430373338343b),
('b232ebe139da6f6597cb75900a91b9b21b0e1a55', '149.28.121.6', 1558410035, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383431303033353b),
('da8c82797fc72e5aed026c008a0a04d7894b4ec8', '73.15.123.240', 1558411382, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383431313337373b),
('7e67b3d071a569e4ea82622f3b58f410e060c5b9', '207.46.13.194', 1558411500, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383431313530303b),
('4535435e10525507aabe89ceb8a15b9b2ce19224', '5.62.62.142', 1558411608, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383431313630383b),
('ec7dbad2b60633fdfeedec9ef0e4ce33c70fa94e', '173.252.127.43', 1558411949, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383431313934393b),
('d37f07c5eaddc9210289a57c79ec2f78086d9a6f', '209.17.96.250, ', 1558412116, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383431323131363b),
('f15ebc5b52d482e0bfa91306d430c64891165c7b', '91.210.145.166', 1558416489, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383431363438393b),
('d750e05d4ae0a429a0e9c47cbddf235d0d2396d0', '54.36.148.219', 1558419254, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383431393235343b),
('6d691ef06af513fa33ab96adb2ab7fa6f3e1afe4', '66.249.69.211', 1558419714, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383431393731343b),
('a9f97ac74ff94061e5116822328938adbbec5204', '66.249.87.220', 1558426093, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383432363039333b),
('2a37c38b0cb3a9d20c55b69ad111a4fe6dd9f5dd', '122.3.199.7', 1558431713, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383433313638333b),
('f356fc966e942dc5a8c0ffc8df387f46388cb1a4', '66.249.91.114', 1558433260, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383433333236303b),
('42946ff1432e9076c6c2bb52f611aeef1685e947', '66.249.91.116', 1558433261, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383433333236313b),
('3cbb743907095ec704bae8e5ee9b48b9f4b52d18', '122.168.155.62', 1558433766, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383433333736363b),
('15e1f1039f0f4102cab0e7f03084276681a31565', '66.249.87.220', 1558434423, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383433343432333b),
('6c28c3fba74c6e5e21918224b6d3446ff8df981d', '66.249.87.216', 1558434423, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383433343432333b),
('5bc6f10d7c9b37d942c6ae8a7f98aaf92aa64e35', '109.201.154.164', 1558435269, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383433353236393b),
('009d306945d13bab1bd9e515bb84890666fae2a6', '46.166.186.211', 1558435277, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383433353237373b),
('27451f74023c0aa19aa61aa5c4b79dd8df33cd48', '99.189.173.117', 1558436805, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383433363830353b),
('c0b5d09d6aab4ba4d6c610797638423ca4588e6a', '18.236.112.95', 1558438106, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383433383130363b),
('04227bbdd0960b026e24c9057bfdeb4d586af0e8', '209.17.96.234, ', 1558440462, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383434303436323b),
('36e928ee9f8dee06de4f0bca80556e9f51b2526c', '54.36.149.92', 1558440554, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383434303535343b),
('6172351843b5d7b9a6c728f2a648172d6dd47f1f', '77.88.47.73', 1558441851, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383434313835313b),
('e3919603b4e826f74c9756e46d9372a4f907a56a', '39.41.217.194', 1558446672, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383434363637323b),
('8cabf0d2e8777b42047b9d0e57832d8d1dba5556', '39.41.217.194', 1558446713, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383434363731333b),
('e637e0006f6bed99055aad2193885dbcfc96f17b', '14.192.214.89', 1558447244, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383434373234343b),
('5d962415b85cf1f519056c687710dcc9fc41c285', '14.192.214.89', 1558447815, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383434373831353b),
('7b9fad6a9ae865396d4e329dbaad558d93395c89', '14.231.191.17', 1558449430, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383434393433303b),
('6949220914e9a427543016beb96bc4447a8ade51', '14.231.191.17', 1558449430, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383434393433303b),
('e6b100aadfad8e062755de099970e1f0e3b98727', '14.231.191.17', 1558449441, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383434393434313b),
('670f4741f069d850535fef2dc53e7d0dca938f5a', '176.9.137.17', 1558451249, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383435313233313b),
('96bc34cf70f460995446992e90ed643566e55e8e', '110.54.164.16', 1558453061, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383435333034313b),
('89552ca1663505a03a92771796c046aeee0811ca', '104.236.72.207', 1558453615, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383435333631353b),
('58c4255c269224c2f2a8fb942242e0483b8301d9', '69.181.96.105', 1558459297, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383435393130383b),
('daf8575121edfeb972cdfc93f8c03ccf80830a05', '69.181.96.105', 1558459281, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383435393238313b),
('e7d2f2d8c919fb33509a3f88c284ac1fd86fe834', '54.36.148.172', 1558460619, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383436303631393b),
('339ae1c7b0469f1b7d2d1661ea3dbf21a85eced2', '208.121.64.7', 1558461531, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383436313533313b),
('fbc73eae5428287f84a5f7d423f566f0a3809e8c', '73.202.126.47', 1558467014, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383436373031343b),
('14b053d320422c4c166828d0e5c1fe99fd608d96', '34.74.41.181', 1558464540, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383436343534303b),
('14173df71c7f37218e4008101a43c25c02892eb2', '34.74.41.181', 1558464990, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383436343939303b),
('9b73fb74223f4ffc6bc144182f58fdaec7238d1f', '73.202.126.47', 1558467058, 0x5f5f63695f6c6173745f726567656e65726174657c693a313535383436373031343b);

-- --------------------------------------------------------

--
-- Table structure for table `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `phone` text,
  `email` text,
  `street` text,
  `city` text,
  `googlemaps` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `contact`
--

INSERT INTO `contact` (`id`, `phone`, `email`, `street`, `city`, `googlemaps`) VALUES
(1, '+1 415 800 7228', 'info@rebeccacamacho.com', '794 Sutter Street', 'San Francisco, CA 94109', 'https://www.google.com/maps/place/794+Sutter+St,+San+Francisco,+CA+94109,+USA/@37.7888101,-122.4156263,17z/data=!4m13!1m7!3m6!1s0x80858092041ae0d1:0x135b06e8a34ae337!2s794+Sutter+St,+San+Francisco,+CA+94109,+USA!3b1!8m2!3d37.7888101!4d-122.4134376!3m4!1s0x80858092041ae0d1:0x135b06e8a34ae337!8m2!3d37.7888101!4d-122.4134376');

-- --------------------------------------------------------

--
-- Table structure for table `exhibitions`
--

CREATE TABLE IF NOT EXISTS `exhibitions` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `artist_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL DEFAULT '',
  `date_start` date DEFAULT NULL,
  `date_end` date DEFAULT NULL,
  `subtitle` varchar(255) NOT NULL,
  `slug` text NOT NULL,
  `is_published` int(11) DEFAULT NULL,
  `press` text,
  `list_image` text,
  PRIMARY KEY (`id`),
  KEY `name` (`title`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=58 ;

--
-- Dumping data for table `exhibitions`
--

INSERT INTO `exhibitions` (`id`, `artist_id`, `title`, `date_start`, `date_end`, `subtitle`, `slug`, `is_published`, `press`, `list_image`) VALUES
(32, 30, 'Holder', '2019-05-17', '2019-07-06', 'Opening Reception: Thursday 16 May, 6 to 8pm', 'sahar-khoury-holder', 1, 'Holder_Press.pdf', '293437f281475c970b2942418bbda64b.jpg');

-- --------------------------------------------------------

--
-- Table structure for table `exhibition_installation_photos`
--

CREATE TABLE IF NOT EXISTS `exhibition_installation_photos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `exhibition_id` int(10) unsigned NOT NULL,
  `filename` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `position` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id` (`exhibition_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=275 ;

--
-- Dumping data for table `exhibition_installation_photos`
--

INSERT INTO `exhibition_installation_photos` (`id`, `exhibition_id`, `filename`, `description`, `position`) VALUES
(269, 32, '0ebf53aae1204bc772e01e1e11e33ba1.jpg', 'Installation View', 17),
(270, 32, 'cb27c47aee0f70408cda4c0cd7e7311b.jpg', 'Installation View', 18),
(271, 32, '1b4b9c07c4c88803da79c282d45ae381.jpg', 'Installation View', 19),
(272, 32, '997eedc167123038b77f9a409e104cbf.jpg', 'Installation View', 20),
(273, 32, 'fcc6a5bddfb2bd3f49531e8f957f732f.jpg', 'Installation View', 21),
(274, 32, '8e7a225073de242f7625de0c1a864d29.jpg', 'Installation View', 22);

-- --------------------------------------------------------

--
-- Table structure for table `exhibition_photos`
--

CREATE TABLE IF NOT EXISTS `exhibition_photos` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `exhibition_id` int(10) unsigned NOT NULL,
  `filename` varchar(255) NOT NULL DEFAULT '',
  `description` text NOT NULL,
  `position` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `project_id` (`exhibition_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=269 ;

--
-- Dumping data for table `exhibition_photos`
--

INSERT INTO `exhibition_photos` (`id`, `exhibition_id`, `filename`, `description`, `position`) VALUES
(243, 32, 'a4534f3ee1f55938c5bd2a7aab75db14.jpg', 'Untitled (holder of Joan Armatrading side 1), 2019, Unglazed and glazed ceramic, record player, Joan Armatrading record, leather, white glue, 38 x 17 3/4 x 27 inches, 96.5 x 45.1 x 68.6 cm', 1),
(250, 32, '6e3f82bb34dc40adae1e55706c4222b6.jpg', 'Untitled (holder of Lynne Hershman Leeson''s plexiglas and Sarah Braman''s glass), 2019, Glazed ceramic, plexiglas, glass, steel, leather, white glue, 18 x 40 x 17 inches, 45.7 x 101.6 x 43.2 cm', 2),
(251, 32, 'dc04d64552fc80f2ac50a57aba1827d6.jpg', 'Untitled (red head holder), 2019, Glazed ceramic, 12 x 12 x 3 1/2 inches, 30.5 x 30.5 x 8.9 cm', 3),
(256, 32, 'f13fbe39988b443a484228ab8079eabd.jpg', 'Untitled (holder of Alicia''s finger), 2019, Glazed ceramic, steel, 10 1/2 x 4 3/4 x 8 inches, 26.7 x 12.1 x 20.3 cm', 4),
(257, 32, 'dfe4f2713e74251c6eb0245fa750486a.jpg', 'Untitled (highlighter), 2019, Glazed ceramic, 30 highlighters, steel, 56 1/4 x 18 1/2 x 14 inches, 142.9 x 47 x 35.6 cm', 5),
(258, 32, '9b5163dd19f6fd092b5f5e7df632e213.jpg', 'Untitled (10 dates blue), 2019, Paper-textile-mâché, ceramic, steel, 39 x 18 x 2 3/4 inches, 99.1 x 45.7 x 7 cm', 6),
(259, 32, '33ee579d2b1bbd03abc3ca1fc8e5f528.jpg', 'Untitled (6 dates red), 2019, Paper-textile-mâché, glazed ceramic, steel, 24 x 17 x 4 1/2 inches, 61 x 43.2 x 11.4 cm', 7),
(260, 32, '603b4fd07c98be7b71eb64f53de473cd.jpg', 'Untitled (teal head holder), 2019, Glazed ceramic, 11 x 10 1/2 x 4 3/4 inches, 27.9 x 26.7 x 12.1 cm', 8),
(261, 32, 'cd4ecb1f35dd5846ae2deee768d195ad.jpg', 'Untitled (black belts), 2019, Glazed ceramic, 4 black belts, steel, resin, leather, paper-textile-mâché, white glue, 54 1/2 x 21 x 17 inches, 138.4 x 53.3 x 43.2 cm', 9),
(262, 32, 'b6316ea6233d9911ff00e8f686514c3c.jpg', 'Untitled (numbers), 2019, Paper-textile-mâché, glazed ceramic, steel, 24 1/4 x 16 x 7 inches,61.6 x 40.6 x 17.8 cm', 10),
(263, 32, '5fc8c6aa5c4a5af7a65a73d70377befe.jpg', 'Untitled (holder of Porpentine Charity Heartscape''s PDF), 2019, Glazed ceramic, iPad, resin, cardboard, leather, acrylic, Diptych, 14 1/2 x 36 x 4 3/4 inches overall, 36.8 x 91.4 x 12.1 cm overall', 11),
(264, 32, 'fe8ac55b4fbe85d4f61cd74942c5ea78.jpg', 'Untitled (bones holder 1), 2019, Cement, resin, 11 1/2 x 12 x 1 3/4 inches, 29.2 x 30.5 x 4.4 cm', 12),
(265, 32, '326b95883188e366ecda498a3c2f8880.jpg', 'Untitled (bones holder 2), 2019, Glazed ceramic, resin, cement, leather, Diptych, 12 x 19 1/2 x 1 1/4 inches overall, 30.5 x 49.5 x 3.2 cm overall', 13),
(266, 32, '93a5a6da4a28b447efd7590aa7afbc9b.jpg', 'Untitled (holder of David Hammons'' slideshow), 2019, Basketball hoop, paper-textile-mâché, iPhone 6, copper pennies, 28 x 18 x 2 inches, 71.1 x 45.7 x 5.1 cm', 14),
(267, 32, 'c400037f6f2d20f124bb0329930b1412.jpg', 'Untitled (stool on wheels), 2019, Cement, glazed ceramic, copper, caster wheels, 13 x 14 1/2 x 13 inches, 33 x 36.8 x 33 cm', 15),
(268, 32, 'b08caad7b7bf5642f220171e54eadd13.jpg', 'Untitled (topiary), 2019, Glazed ceramic, steel, 28 x 12 x 10 3/4 inches, 71.1 x 30.5 x 27.3 cm', 16);

-- --------------------------------------------------------

--
-- Table structure for table `homepages`
--

CREATE TABLE IF NOT EXISTS `homepages` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `is_primary` int(11) DEFAULT '0',
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) DEFAULT NULL,
  `line1` varchar(255) DEFAULT NULL,
  `line2` varchar(255) DEFAULT NULL,
  `layout` varchar(16) NOT NULL,
  `logo_color` varchar(16) NOT NULL,
  `menu_color` varchar(16) NOT NULL,
  `background_image` text NOT NULL,
  `link` text NOT NULL,
  `background_color` varchar(16) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=13 ;

--
-- Dumping data for table `homepages`
--

INSERT INTO `homepages` (`id`, `is_primary`, `title`, `subtitle`, `line1`, `line2`, `layout`, `logo_color`, `menu_color`, `background_image`, `link`, `background_color`) VALUES
(10, 1, 'Sahar Khoury', 'Holder', '17 May - 6 July 2019', 'Gallery hours: Thursday - Saturday 12noon to 6pm and by appointment', 'full', 'black', 'black', 'KHO003_Khoury_teal_head_holder.jpg', 'https://rebeccacamacho.com/exhibitions/profile/sahar-khoury-holder', '');

-- --------------------------------------------------------

--
-- Table structure for table `news`
--

CREATE TABLE IF NOT EXISTS `news` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `artist_id` int(11) DEFAULT NULL,
  `title` varchar(255) NOT NULL,
  `subtitle` varchar(255) NOT NULL,
  `link_name` varchar(255) NOT NULL,
  `link_url` text NOT NULL,
  `is_published` int(11) DEFAULT '0',
  `seq` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `artist_id` (`artist_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=17 ;

--
-- Dumping data for table `news`
--

INSERT INTO `news` (`id`, `artist_id`, `title`, `subtitle`, `link_name`, `link_url`, `is_published`, `seq`) VALUES
(6, 32, 'With a Capital P: Selections by Six Painters', '11 May - 25 August 2019', 'Elmhurst Art Museum', 'https://www.elmhurstartmuseum.org/exhibitions/capital-p-selections-six-painters', 1, 12),
(7, 29, 'Stonewall 50', '27 April - 28 July 2019', 'Contemporary Arts Museum Housto', 'https://camh.org/event/stonewall50', 1, 11),
(8, 29, 'Flight: A Collective History', '7 April - 26 May 2019', 'Hessel Museum of Art, CCS Bard', 'https://ccs.bard.edu/museum/exhibitions/519-flight-a-collective-history', 1, 10),
(9, 36, '2018 Betty Bowen Award Winner', 'On view 10 August 2019', 'Seattle Art Museum', 'Seattle Art Museum', 1, 9),
(10, 31, 'Suffering from Realness', 'On view 13 April 2019', 'MassMOCA', 'https://massmoca.org/event/suffering-from-realness/', 1, 8),
(11, 0, 'Rebecca Camacho Presents highlighted in the San Francisco Chronicle', '', 'San Francisco Chronicle', 'https://datebook.sfchronicle.com/art-exhibits/veteran-san-francisco-gallerist-launches-new-contemporary-space', 1, 7),
(12, 0, 'Rebecca Camacho Presents highlighted in Artnet News', '', 'Art News', 'https://news.artnet.com/market/rebecca-camacho-san-francisco-gallery-1509376', 1, 6),
(13, 30, '2019 SFMOMA SECA Art Award winner', '', 'San Francisco Chronicle', 'https://datebook.sfchronicle.com/art-exhibits/trio-of-bay-area-artists-named-sfmomas-2019-seca-award-winners', 1, 5),
(14, 30, '2019 SECA Art Award Exhibition', 'November 2019 - April 2020', 'San Francisco Museum of Modern Art', 'https://www.sfmoma.org/membership/seca/seca-art-award/', 1, 4),
(15, 0, 'Rebecca Camacho Presents highlighted in BLOUIN ARTINFO', '', 'Blouin ArtInfo', 'https://www.blouinartinfo.com/news/story/3654850/rebecca-camacho-launches-gallery-rebecca-camacho-presents-in', 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `overviews`
--

CREATE TABLE IF NOT EXISTS `overviews` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `short_description` text COLLATE utf8_unicode_ci NOT NULL,
  `description` text COLLATE utf8_unicode_ci NOT NULL,
  `photo` text COLLATE utf8_unicode_ci,
  `date_modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `code` (`code`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=46 ;

--
-- Dumping data for table `overviews`
--

INSERT INTO `overviews` (`id`, `code`, `short_description`, `description`, `photo`, `date_modified`) VALUES
(41, 'tagline', '', '<p>Rebecca Camacho Presents is a contemporary art gallery representing emerging and established local, national and international artists.</p>', NULL, '2019-04-21 11:41:37'),
(42, 'hours', '', '<p>Thursday through Saturday, 12 noon to 6pm</p>\r\n<p>Monday through Wednesday, By Appointment</p>', NULL, '2019-05-19 03:21:21'),
(43, 'public_transportation', '', '<p>BART to Powell Street</p>\r\n<p>SF MUNI 27 to Leavenworth &amp; Sutter</p>', NULL, '2019-04-21 11:44:55'),
(44, 'parking', '', '<p>Metered street parking.</p>\r\n<p>California Parking, 660 Sutter Street</p>\r\n<p>Sutter Stockton Garage, 444 Stockton Street</p>\r\n<p>Cable Car Parking, 50 Cosmo Place</p>', NULL, '2019-04-21 11:45:45'),
(45, 'disclaimer', '', 'Rebeccca Camacho Presents does not accept unsolicited submissions.', 'GalleryWall_3C8A1522_touchedup.png', '2019-05-19 04:53:43');

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE IF NOT EXISTS `sections` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(255) CHARACTER SET latin1 NOT NULL,
  `url` varchar(255) CHARACTER SET latin1 NOT NULL,
  `seq` smallint(6) NOT NULL,
  `old_id` int(11) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `url` (`url`),
  KEY `seq` (`seq`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Dumping data for table `sections`
--

INSERT INTO `sections` (`id`, `name`, `url`, `seq`, `old_id`) VALUES
(6, 'Contact', 'contact', 6, 3),
(2, 'About', 'about', 2, 1),
(4, 'Exhibitions', 'exhibitions', 4, 2),
(7, 'Social Links', 'sociables', 7, 4),
(1, 'Homepage', 'homepage', 1, 5),
(3, 'Artists', 'artists', 3, 6),
(5, 'News', 'news', 5, 7);

-- --------------------------------------------------------

--
-- Table structure for table `sociables`
--

CREATE TABLE IF NOT EXISTS `sociables` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `instagram` varchar(512) NOT NULL DEFAULT '',
  `facebook` varchar(512) NOT NULL DEFAULT '',
  `subscribe` varchar(512) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Dumping data for table `sociables`
--

INSERT INTO `sociables` (`id`, `instagram`, `facebook`, `subscribe`) VALUES
(1, 'https://instagram.com/rebeccacamachopresents/', 'https://www.facebook.com/RebeccaCamachoPresentsLLC/', 'https://mailchi.mp/054654466c4b/rcp');

--
-- Constraints for dumped tables
--

--
-- Constraints for table `artist_photos`
--
ALTER TABLE `artist_photos`
  ADD CONSTRAINT `artist_photos_ibfk_1` FOREIGN KEY (`artist_id`) REFERENCES `artists` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exhibition_installation_photos`
--
ALTER TABLE `exhibition_installation_photos`
  ADD CONSTRAINT `exhibition_installation_photos_ibfk_1` FOREIGN KEY (`exhibition_id`) REFERENCES `exhibitions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Constraints for table `exhibition_photos`
--
ALTER TABLE `exhibition_photos`
  ADD CONSTRAINT `exhibition_photos_ibfk_1` FOREIGN KEY (`exhibition_id`) REFERENCES `exhibitions` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
