-- phpMyAdmin SQL Dump
-- version 4.1.14
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: Lug 03, 2014 alle 20:41
-- Versione del server: 5.6.17-log
-- PHP Version: 5.5.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `xoops257testtdmcreate191`
--

-- --------------------------------------------------------

--
-- Struttura della tabella `x7f1_tdmcreate_fieldelements`
--

CREATE TABLE IF NOT EXISTS `x7f1_tdmcreate_fieldelements` (
  `fieldelement_id` int(5) NOT NULL AUTO_INCREMENT,
  `fieldelement_mid` int(11) NOT NULL DEFAULT '0',
  `fieldelement_tid` int(11) NOT NULL DEFAULT '0',
  `fieldelement_name` varchar(100) NOT NULL DEFAULT '',
  `fieldelement_value` varchar(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`fieldelement_id`),
  KEY `fieldelement_mid` (`fieldelement_mid`),
  KEY `fieldelement_tid` (`fieldelement_tid`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=19 ;

--
-- Dump dei dati per la tabella `x7f1_tdmcreate_fieldelements`
--

INSERT INTO `x7f1_tdmcreate_fieldelements` (`fieldelement_id`, `fieldelement_mid`, `fieldelement_tid`, `fieldelement_name`, `fieldelement_value`) VALUES
(1, 0, 0, 'Text', 'XoopsFormText'),
(2, 0, 0, 'TextArea', 'XoopsFormTextArea'),
(3, 0, 0, 'DhtmlTextArea', 'XoopsFormDhtmlTextArea'),
(4, 0, 0, 'CheckBox', 'XoopsFormCheckBox'),
(5, 0, 0, 'RadioYN', 'XoopsFormRadioYN'),
(6, 0, 0, 'SelectBox', 'XoopsFormSelect'),
(7, 0, 0, 'SelectUser', 'XoopsFormSelectUser'),
(8, 0, 0, 'ColorPicker', 'XoopsFormColorPicker'),
(9, 0, 0, 'ImageList', 'XoopsFormImageList'),
(10, 0, 0, 'UploadImage', 'XoopsFormUploadImage'),
(11, 0, 0, 'UploadFile', 'XoopsFormUploadFile'),
(12, 0, 0, 'TextDateSelect', 'XoopsFormTextDateSelect'),
(13, 1, 1, 'Table : Links', 'XoopsFormTables-Links'),
(14, 1, 2, 'Table : Buttons', 'XoopsFormTables-Buttons'),
(15, 1, 3, 'Table : Banners', 'XoopsFormTables-Banners'),
(16, 2, 4, 'Table : Tests1', 'XoopsFormTables-Tests1'),
(17, 3, 5, 'Table : Categories', 'XoopsFormTables-Categories'),
(18, 4, 6, 'Table : Txmmdls', 'XoopsFormTables-Txmmdls');


/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
