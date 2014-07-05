# SQL Dump for tdmcreate module
# PhpMyAdmin Version: 4.0.4
# http://www.phpmyadmin.net
#
# Host: localhost
# Generated on: Thu Jen 02, 2014 to 19:12
# Server version: 5.5.24-log
# PHP Version: 5.3.13

#
# Table structure for table `tdmcreate_modules` 38
#

CREATE TABLE `tdmcreate_modules` (
  `mod_id`                  INT(5)     UNSIGNED NOT NULL AUTO_INCREMENT,
  `mod_name`                VARCHAR(255)        NOT NULL DEFAULT '',
  `mod_dirname`             VARCHAR(100)        NOT NULL DEFAULT '',
  `mod_version`             VARCHAR(5)          NOT NULL DEFAULT '1.0',
  `mod_since`               VARCHAR(5)          NOT NULL DEFAULT '1.0',
  `mod_min_php`             VARCHAR(5)          NOT NULL DEFAULT '5.3',
  `mod_min_xoops`           VARCHAR(5)          NOT NULL DEFAULT '2.5.7',
  `mod_min_admin`           VARCHAR(5)          NOT NULL DEFAULT '1.1',
  `mod_min_mysql`           VARCHAR(5)          NOT NULL DEFAULT '5.0.7',
  `mod_description`         TEXT,
  `mod_author`              VARCHAR(255)        NOT NULL DEFAULT 'TDM XOOPS',
  `mod_author_mail`         VARCHAR(255)        NOT NULL DEFAULT 'info@email.com',
  `mod_author_website_url`  VARCHAR(255)        NOT NULL DEFAULT 'http://',
  `mod_author_website_name` VARCHAR(255)        NOT NULL DEFAULT '',
  `mod_credits`             VARCHAR(255)        NOT NULL DEFAULT 'TDM XOOPS',
  `mod_license`             VARCHAR(255)        NOT NULL DEFAULT 'GNU',
  `mod_release_info`        VARCHAR(255)        NOT NULL DEFAULT '',
  `mod_release_file`        VARCHAR(255)        NOT NULL DEFAULT '',
  `mod_manual`              VARCHAR(255)        NOT NULL DEFAULT '',
  `mod_manual_file`         VARCHAR(255)        NOT NULL DEFAULT '',
  `mod_image`               VARCHAR(255)        NOT NULL DEFAULT '',
  `mod_demo_site_url`       VARCHAR(255)        NOT NULL DEFAULT 'http://',
  `mod_demo_site_name`      VARCHAR(255)        NOT NULL DEFAULT '',
  `mod_support_url`         VARCHAR(255)        NOT NULL DEFAULT 'http://',
  `mod_support_name`        VARCHAR(255)        NOT NULL DEFAULT '',
  `mod_website_url`         VARCHAR(255)        NOT NULL DEFAULT 'http://',
  `mod_website_name`        VARCHAR(255)        NOT NULL DEFAULT '',
  `mod_release`             VARCHAR(11)         NOT NULL DEFAULT '00-00-0000',
  `mod_status`              VARCHAR(150)        NOT NULL DEFAULT 'Beta 1',
  `mod_admin`               TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',  
  `mod_user`                TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
  `mod_blocks`              TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `mod_search`              TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `mod_comments`            TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `mod_notifications`       TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `mod_permissions`         TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `mod_inroot_copy`         TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `mod_donations`           VARCHAR(50)         NOT NULL DEFAULT '6KJ7RW5DR3VTJ',
  `mod_subversion`          VARCHAR(10)         NOT NULL DEFAULT '12550',
  PRIMARY KEY (`mod_id`),
  UNIQUE KEY `mod_name` (`mod_name`),
  KEY `mod_dirname` (`mod_dirname`)
)ENGINE =MyISAM;


CREATE TABLE `tdmcreate_tables` (
  `table_id`            INT(5) UNSIGNED     NOT NULL AUTO_INCREMENT,
  `table_mid`           INT(5) UNSIGNED     NOT NULL DEFAULT '0',
  `table_category`      TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `table_name`          VARCHAR(150)        NOT NULL DEFAULT '',
  `table_fieldname`     VARCHAR(150)        NOT NULL DEFAULT '',
  `table_nbfields`      INT(5) UNSIGNED     NOT NULL DEFAULT '0',
  `table_image`         VARCHAR(150)        NOT NULL DEFAULT '',
  `table_autoincrement` TINYINT(1)          NOT NULL DEFAULT '1',
  `table_blocks`        TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `table_admin`         TINYINT(1) UNSIGNED NOT NULL DEFAULT '1',
  `table_user`          TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `table_submenu`       TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `table_status`        TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `table_waiting`       TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `table_display`       TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `table_search`        TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `table_comments`      TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `table_notifications` TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  `table_permissions`   TINYINT(1) UNSIGNED NOT NULL DEFAULT '0',
  PRIMARY KEY (`table_id`),
  KEY `table_mid` (`table_mid`),
  KEY `table_name` (`table_name`)
)ENGINE =MyISAM;

#
# Table structure for table `tdmcreate_fields` 21
#

CREATE TABLE `tdmcreate_fields` (
  `field_id`        INT(8) UNSIGNED  NOT NULL AUTO_INCREMENT,
  `field_mid`       INT(5) UNSIGNED  NOT NULL DEFAULT '0',
  `field_tid`       INT(5) UNSIGNED  NOT NULL DEFAULT '0',
  `field_numb`      INT(10) UNSIGNED NOT NULL DEFAULT '0',
  `field_name`      VARCHAR(255)     NOT NULL DEFAULT '',
  `field_type`      VARCHAR(100)     NOT NULL DEFAULT '',
  `field_value`     CHAR(4)          NOT NULL DEFAULT '',
  `field_attribute` VARCHAR(50)      NOT NULL DEFAULT '',
  `field_null`      CHAR(10)         NOT NULL DEFAULT '',
  `field_default`   VARCHAR(150)     NOT NULL DEFAULT '',
  `field_key`       CHAR(10)         NOT NULL DEFAULT '',
  `field_element`   VARCHAR(150)     NOT NULL DEFAULT '',
  `field_parent`    TINYINT(1)       NOT NULL DEFAULT '0',
  `field_inlist`    TINYINT(1)       NOT NULL DEFAULT '0',
  `field_inform`    TINYINT(1)       NOT NULL DEFAULT '0',
  `field_admin`     TINYINT(1)       NOT NULL DEFAULT '0',
  `field_user`      TINYINT(1)       NOT NULL DEFAULT '0',
  `field_block`     TINYINT(1)       NOT NULL DEFAULT '0',
  `field_main`      TINYINT(1)       NOT NULL DEFAULT '0',
  `field_search`    TINYINT(1)       NOT NULL DEFAULT '0',
  `field_required`  TINYINT(1)       NOT NULL DEFAULT '0',
  PRIMARY KEY (`field_id`),
  KEY `field_mid` (`field_mid`),
  KEY `field_tid` (`field_tid`)
)ENGINE =MyISAM;

#
# Table structure for table `tdmcreate_languages` 5
#

CREATE TABLE `tdmcreate_languages` (
  `lng_id`   INT(5) UNSIGNED NOT NULL AUTO_INCREMENT,
  `lng_mid`  INT(5) UNSIGNED NOT NULL DEFAULT '0',
  `lng_file` VARCHAR(255) NULL DEFAULT '',
  `lng_define`  VARCHAR(255) NULL DEFAULT '',
  `lng_description` VARCHAR(255) NULL DEFAULT '',
  PRIMARY KEY (`lng_id`),
  KEY `lng_mid` (`lng_mid`)  
)ENGINE =MyISAM;

#
# Table structure for table `tdmcreate_fieldtype` 2
#

CREATE TABLE `tdmcreate_fieldtype` (
  `fieldtype_name`  VARCHAR(255) NOT NULL DEFAULT '',
  `fieldtype_value` VARCHAR(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`fieldtype_name`)
)ENGINE =MyISAM;

INSERT INTO `tdmcreate_fieldtype` (`fieldtype_name`, `fieldtype_value`) VALUES
  ('', ''),
  ('INT', 'INT'),
  ('TINYINT', 'TINYINT'),
  ('MEDIUMINT', 'MEDIUMINT'),
  ('SMALLINT', 'SMALLINT'),
  ('FLOAT', 'FLOAT'),
  ('DOUBLE', 'DOUBLE'),
  ('DECIMAL', 'DECIMAL'),
  ('SET', 'SET'),
  ('ENUM', 'ENUM'),
  ('EMAIL', 'EMAIL'),
  ('URL', 'URL'),
  ('CHAR', 'CHAR'),
  ('VARCHAR', 'VARCHAR'),
  ('TEXT', 'TEXT'),
  ('TINYTEXT', 'TINYTEXT'),
  ('MEDIUMTEXT', 'MEDIUMTEXT'),
  ('LONGTEXT', 'LONGTEXT'),
  ('DATE', 'DATE'),
  ('DATETIME', 'DATETIME'),
  ('TIMESTAMP', 'TIMESTAMP'),
  ('TIME', 'TIME'),
  ('YEAR', 'YEAR');

#
# Table structure for table `tdmcreate_fieldattributes` 3
#

CREATE TABLE `tdmcreate_fieldattributes` (
  `fieldattribute_name`  VARCHAR(255) NOT NULL DEFAULT '',
  `fieldattribute_value` VARCHAR(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`fieldattribute_name`)
)ENGINE =MyISAM;

INSERT INTO `tdmcreate_fieldattributes` (`fieldattribute_name`, `fieldattribute_value`) VALUES
  ('', ''),
  ('BINARY', 'BINARY'),
  ('UNSIGNED', 'UNSIGNED'),
  ('UNSIGNED_ZEROFILL', 'UNSIGNED_ZEROFILL'),
  ('CURRENT_TIMESTAMP', 'CURRENT_TIMESTAMP');

#
# Table structure for table `tdmcreate_fieldnull` 3
#

CREATE TABLE `tdmcreate_fieldnull` (
  `fieldnull_name`  VARCHAR(255) NOT NULL DEFAULT '',
  `fieldnull_value` VARCHAR(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`fieldnull_name`)
)ENGINE =MyISAM;

INSERT INTO `tdmcreate_fieldnull` (`fieldnull_name`, `fieldnull_value`) VALUES
  ('', ''),
  ('NOT NULL', 'NOT NULL'),
  ('NULL', 'NULL');

#
# Table structure for table `tdmcreate_fieldkey` 3
#

CREATE TABLE `tdmcreate_fieldkey` (
  `fieldkey_name`  VARCHAR(255) NOT NULL DEFAULT '',
  `fieldkey_value` VARCHAR(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`fieldkey_name`)
)ENGINE =MyISAM;

INSERT INTO `tdmcreate_fieldkey` (`fieldkey_name`, `fieldkey_value`) VALUES
  ('', ''),
  ('PRIMARY', 'PRIMARY KEY'),
  ('UNIQUE', 'UNIQUE KEY'),
  ('INDEX', 'INDEX'),
  ('FULLTEXT', 'FULLTEXT');

#
# Table structure for table `tdmcreate_fieldelements` 3
#

CREATE TABLE `tdmcreate_fieldelements` (
  `fieldelement_id`    INT(5)       NOT NULL AUTO_INCREMENT,
  `fieldelement_mid`   INT(11)      NOT NULL DEFAULT '0',
  `fieldelement_tid`   INT(11)      NOT NULL DEFAULT '0',
  `fieldelement_name`  VARCHAR(100) NOT NULL DEFAULT '',
  `fieldelement_value` VARCHAR(100) NOT NULL DEFAULT '',
  PRIMARY KEY (`fieldelement_id`),
  KEY `fieldelement_mid` (`fieldelement_mid`),
  KEY `fieldelement_tid` (`fieldelement_tid`)
)ENGINE =MyISAM;

INSERT INTO `tdmcreate_fieldelements` (`fieldelement_id`, `fieldelement_mid`, `fieldelement_tid`, `fieldelement_name`, `fieldelement_value`) VALUES
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
  (12, 0, 0, 'TextDateSelect', 'XoopsFormTextDateSelect');