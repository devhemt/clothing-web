-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Nov 05, 2020 at 01:37 AM
-- Server version: 10.4.14-MariaDB
-- PHP Version: 7.2.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `clothing_db`
--

-- --------------------------------------------------------

--
-- Table structure for table `product`
--

CREATE TABLE product (
  prdid int(30) NOT NULL AUTO_INCREMENT,
  image varchar(100) NOT NULL,
  name varchar(200) NOT NULL,
  description text NOT NULL,
  price float NOT NULL,
  date_created datetime NOT NULL DEFAULT CURDATE(),
  PRIMARY KEY(prdid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Table structure for table `nature1`
--
CREATE TABLE nature1 (
	id int(30) NOT NULL AUTO_INCREMENT,
	itemsid int(30) NOT NULL,
	size varchar(20) ,
	color varchar(100) ,
	FOREIGN KEY (itemsid) REFERENCES product(prdid),
	PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Table structure for table `nature`
--
CREATE TABLE nature (
	id int(30) NOT NULL AUTO_INCREMENT,
	itemsid int(30) NOT NULL,
	size varchar(20) NOT NULL,
	color varchar(100) NOT NULL,
	amount int(30) not null,
	FOREIGN KEY (itemsid) REFERENCES product(prdid),
	PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `category`
--
CREATE TABLE category (
	id int(30) NOT NULL AUTO_INCREMENT,
	itemsid int(30) NOT NULL,
	category varchar(100) NOT NULL,
	FOREIGN KEY (itemsid) REFERENCES product(prdid),
	PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


--
-- Table structure for table `customers`
--
CREATE TABLE customers (
	cusid int(30) NOT NULL AUTO_INCREMENT,
	cusname varchar(100) NOT NULL,
	phone varchar(30) NOT NULL,
	email varchar(100) NOT NULL,
	address varchar(200) NOT NULL,
	PRIMARY KEY(cusid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `invoice`
--
CREATE TABLE invoice (
	invoiceid int(30) NOT NULL AUTO_INCREMENT,
	cusid int(30) NOT NULL,
	pay float NOT NULL,
	FOREIGN KEY (cusid) REFERENCES customers(cusid),
	date_created datetime NOT NULL DEFAULT CURDATE(),
	PRIMARY KEY(invoiceid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `detailed_invoice`
--
CREATE TABLE detailed_invoice (
	dtlivid int(30) NOT NULL AUTO_INCREMENT,
	itemsid int(30) NOT NULL,
	invoiceid int(30) Not NULL,
	amount int(30) NOT NULL,
	size varchar(20) NOT NULL,
	color varchar(100) NOT NULL,
	dprice float NOT NULL,
	FOREIGN KEY (itemsid) REFERENCES product(prdid),
	FOREIGN KEY (invoiceid) REFERENCES invoice(invoiceid),
	PRIMARY KEY(dtlivid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `status`
--
CREATE TABLE status (
	statusid int(30) NOT NULL AUTO_INCREMENT,
	invoiceid int(30) NOT NULL,
	status tinyint NOT NULL COMMENT '0=bihuy,1=chuaxuly,2=daxuly,3=danggiao,4=thanhcong',
	FOREIGN KEY (invoiceid) REFERENCES invoice(invoiceid),
	PRIMARY KEY(statusid)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `comments`
--
CREATE TABLE comments (
	id int(30) NOT NULL AUTO_INCREMENT,
	itemsid int(30) NOT NULL,
	name varchar(100) NOT NULL,
	email varchar(100) NOT NULL,
	content text NOT NULL,
	FOREIGN KEY (itemsid) REFERENCES product(prdid),
	PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `check_comments`
--
CREATE TABLE check_comments (
	id int(30) NOT NULL AUTO_INCREMENT,
	cmtid int(30) NOT NULL,
	status int(3) NOT NULL,
	FOREIGN KEY (cmtid) REFERENCES comments(id),
	PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Table structure for table `admin`
--

CREATE TABLE account (
  id int(30) NOT NULL AUTO_INCREMENT,
  name text NOT NULL,
  username varchar(200) NOT NULL,
  password text NOT NULL,
  type tinyint NOT NULL COMMENT '1=Admin,2=Staff,3=customer',
  PRIMARY KEY(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
--
-- Dumping data for table `product`
--

INSERT INTO product (image, name, description,price) VALUES
('1.jpg', 'bo 1', 'mot doan mo ta ve san pham', 500000),
('2.jpg', 'bo 2', 'mot doan mo ta ve san pham', 250000),
('3.jpg', 'bo 3', 'mot doan mo ta ve san pham', 500000),
('4.jpg', 'bo 4', 'mot doan mo ta ve san pham', 250000),
('5.jpg', 'bo 5', 'mot doan mo ta ve san pham', 500000),
('6.jpg', 'bo 6', 'mot doan mo ta ve san pham', 250000),
('7.jpg', 'bo 7', 'mot doan mo ta ve san pham', 500000),
('8.jpg', 'bo 8', 'mot doan mo ta ve san pham', 250000),
('9.jpg', 'bo 9', 'mot doan mo ta ve san pham', 500000),
('10.jpg', 'bo 10', 'mot doan mo ta ve san pham', 250000),
('11.jpg', 'bo 11', 'mot doan mo ta ve san pham', 500000),
('12.jpg', 'bo 12', 'mot doan mo ta ve san pham', 250000),
('13.jpg', 'bo 13', 'mot doan mo ta ve san pham', 500000),
('14.jpg', 'bo 14', 'mot doan mo ta ve san pham', 250000),
('15.jpg', 'bo 15', 'mot doan mo ta ve san pham', 500000),
('16.jpg', 'bo 16', 'mot doan mo ta ve san pham', 250000),
('17.jpg', 'bo 17', 'mot doan mo ta ve san pham', 500000),
('18.jpg', 'bo 18', 'mot doan mo ta ve san pham', 250000),
('19.jpg', 'bo 19', 'mot doan mo ta ve san pham', 500000),
('20.jpg', 'bo 20', 'mot doan mo ta ve san pham', 250000),
('21.jpg', 'bo 21', 'mot doan mo ta ve san pham', 500000),
('22.jpg', 'bo 22', 'mot doan mo ta ve san pham', 250000),
('23.jpg', 'bo 23', 'mot doan mo ta ve san pham', 500000),
('24.jpg', 'bo 24', 'mot doan mo ta ve san pham', 250000),
('25.jpg', 'bo 25', 'mot doan mo ta ve san pham', 500000),
('26.jpg', 'bo 26', 'mot doan mo ta ve san pham', 250000),
('27.jpg', 'bo 27', 'mot doan mo ta ve san pham', 500000),
('28.jpg', 'bo 28', 'mot doan mo ta ve san pham', 250000),
('29.jpg', 'bo 29', 'mot doan mo ta ve san pham', 500000),
('30.jpg', 'bo 30', 'mot doan mo ta ve san pham', 250000);

INSERT INTO account (name, username, password, type) VALUES
('nga','nga@gmail.com','12345',1),
('lich','lich@gmail.com','12345',1);