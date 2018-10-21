-- phpMyAdmin SQL Dump
-- version 2.11.9.4
-- http://www.phpmyadmin.net
--
-- Host: 192.168.1.118
-- Czas wygenerowania: 04 Mar 2009, 14:47
-- Wersja serwera: 5.0.67
-- Wersja PHP: 5.2.3

/*
SET AUTOCOMMIT=0;
START TRANSACTION;
*/
--
-- Baza danych: `marina_joomla`
--

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `categorys`
--

DROP TABLE IF EXISTS `categorys`;
CREATE TABLE "categorys" (
  "id" smallint(6) NOT NULL auto_increment,
  "name" varchar(100) NOT NULL default '',
  "siblingOrder" mediumint(9) default NULL,
  "category" varchar(50) default '0',
  PRIMARY KEY  ("id")
) AUTO_INCREMENT=176 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `items`
--

DROP TABLE IF EXISTS `items`;
CREATE TABLE "items" (
  "id" smallint(6) NOT NULL auto_increment,
  "idEntry" smallint(6) NOT NULL default '0',
  "idCatalogue" varchar(20) NOT NULL default '',
  "name" text,
  "name_en" text NOT NULL,
  "siblingOrder" mediumint(9) NOT NULL default '0',
  "description" text NOT NULL,
  "description_en" text NOT NULL,
  "variant" varchar(200) NOT NULL default '',
  "photo" text NOT NULL,
  "category" varchar(100) default '0',
  "categoryOld1" varchar(10) NOT NULL default '',
  "categoryOld2" varchar(10) NOT NULL default '',
  "price" float NOT NULL default '0',
  "priceHidden" float NOT NULL default '0',
  PRIMARY KEY  ("id")
) AUTO_INCREMENT=305 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `newss`
--

DROP TABLE IF EXISTS `newss`;
CREATE TABLE "newss" (
  "id" smallint(6) NOT NULL auto_increment,
  "name" varchar(200) NOT NULL default '',
  "name_en" varchar(200) NOT NULL default '',
  "content" text NOT NULL,
  "content_en" text NOT NULL,
  "date" date NOT NULL default '0000-00-00',
  "image" varchar(200) NOT NULL default '',
  "link" varchar(200) NOT NULL default '',
  "information" varchar(5) default NULL,
  "recommendation" varchar(5) default NULL,
  PRIMARY KEY  ("id")
) AUTO_INCREMENT=48 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `users`
--

DROP TABLE IF EXISTS `users`;
CREATE TABLE "users" (
  "id" smallint(6) NOT NULL auto_increment,
  "login" varchar(20) NOT NULL default '',
  "pass" varchar(50) NOT NULL default '',
  "mail" varchar(100) NOT NULL default '',
  "name" varchar(100) NOT NULL default '',
  "surname" varchar(100) NOT NULL default '',
  "company" varchar(100) NOT NULL default '',
  "nip" varchar(20) NOT NULL default '',
  "city" varchar(50) NOT NULL default '',
  "address" text NOT NULL,
  "postCode" varchar(10) NOT NULL default '',
  "telHome" varchar(50) NOT NULL default '',
  "telCompany" varchar(50) NOT NULL default '',
  "telCellular" varchar(50) NOT NULL default '',
  "comment" text NOT NULL,
  "rank" tinyint(4) NOT NULL default '1',
  PRIMARY KEY  ("id")
) AUTO_INCREMENT=473 ;

-- --------------------------------------------------------

--
-- Struktura tabeli dla  `visits`
--

DROP TABLE IF EXISTS `visits`;
CREATE TABLE "visits" (
  "id" mediumint(9) NOT NULL auto_increment,
  "type" enum('simple','unique') NOT NULL default 'simple',
  "path" text NOT NULL,
  "visits_guest" mediumint(9) NOT NULL default '0',
  "visits_user" mediumint(9) NOT NULL default '0',
  "visits_admin" mediumint(9) NOT NULL default '0',
  PRIMARY KEY  ("id")
) AUTO_INCREMENT=8402 ;

/*
COMMIT;

*/