-- phpMyAdmin SQL Dump
-- version 4.5.2
-- http://www.phpmyadmin.net
--
-- Anamakine: localhost
-- Üretim Zamanı: 10 Nis 2017, 13:16:46
-- Sunucu sürümü: 10.1.16-MariaDB
-- PHP Sürümü: 5.6.24

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `tilpark`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `til_accounts`
--

CREATE TABLE `til_accounts` (
  `id` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `date` datetime NOT NULL,
  `type` varchar(10) NOT NULL,
  `code` varchar(32) NOT NULL,
  `name` varchar(32) NOT NULL,
  `email` varchar(100) NOT NULL,
  `gsm` varchar(20) NOT NULL,
  `phone` varchar(20) NOT NULL,
  `address` varchar(500) NOT NULL,
  `city` varchar(20) NOT NULL,
  `district` varchar(20) NOT NULL,
  `country` varchar(20) NOT NULL,
  `tax_no` varchar(20) NOT NULL,
  `tax_home` varchar(20) NOT NULL,
  `balance` decimal(15,4) NOT NULL,
  `profit` decimal(15,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `til_extra`
--

CREATE TABLE `til_extra` (
  `id` int(11) NOT NULL,
  `taxonomy` varchar(64) NOT NULL,
  `name` varchar(128) NOT NULL,
  `val` text NOT NULL,
  `val_1` varchar(128) NOT NULL,
  `val_2` varchar(128) NOT NULL,
  `val_3` varchar(128) NOT NULL,
  `val_4` varchar(256) NOT NULL,
  `val_5` varchar(256) NOT NULL,
  `val_6` varchar(256) NOT NULL,
  `val_7` varchar(512) NOT NULL,
  `val_8` varchar(512) NOT NULL,
  `val_9` varchar(512) NOT NULL,
  `val_text` text NOT NULL,
  `val_int` int(11) NOT NULL,
  `val_decimal` decimal(15,4) NOT NULL,
  `val_date` datetime NOT NULL,
  `val_enum` enum('0','1') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `til_forms`
--

CREATE TABLE `til_forms` (
  `id` int(11) NOT NULL,
  `status` enum('0','1') NOT NULL DEFAULT '1',
  `date` datetime NOT NULL,
  `type` varchar(10) NOT NULL DEFAULT 'form',
  `template` varchar(20) NOT NULL,
  `in_out` enum('0','1') NOT NULL DEFAULT '1',
  `account_id` int(11) NOT NULL,
  `account_code` varchar(32) NOT NULL,
  `account_name` varchar(50) NOT NULL,
  `account_gsm` varchar(20) NOT NULL,
  `account_phone` varchar(20) NOT NULL,
  `account_email` varchar(100) NOT NULL,
  `account_city` varchar(20) NOT NULL,
  `account_tax_home` varchar(20) NOT NULL,
  `account_tax_no` varchar(20) NOT NULL,
  `total` decimal(15,4) NOT NULL,
  `profit` decimal(15,4) NOT NULL,
  `payment` decimal(15,4) NOT NULL,
  `item_count` int(11) NOT NULL,
  `item_quantity` int(11) NOT NULL,
  `status_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `date_updated` datetime NOT NULL,
  `val_1` varchar(255) NOT NULL,
  `val_2` varchar(512) NOT NULL,
  `val_3` varchar(1024) NOT NULL,
  `val_int` int(11) NOT NULL,
  `val_date` datetime NOT NULL,
  `val_decimal` decimal(15,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `til_form_items`
--

CREATE TABLE `til_form_items` (
  `id` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `date` datetime NOT NULL,
  `type` varchar(20) NOT NULL DEFAULT 'item',
  `in_out` int(1) NOT NULL DEFAULT '1',
  `form_id` int(11) NOT NULL,
  `account_id` int(11) NOT NULL,
  `item_id` int(11) NOT NULL,
  `item_code` varchar(32) NOT NULL,
  `item_name` varchar(50) NOT NULL,
  `item_p_purc` decimal(15,4) NOT NULL,
  `item_p_sale` decimal(15,4) NOT NULL,
  `price` decimal(15,4) NOT NULL,
  `quantity` int(11) NOT NULL,
  `vat` int(2) NOT NULL,
  `vat_total` decimal(15,4) NOT NULL,
  `total` decimal(15,4) NOT NULL,
  `profit` decimal(15,4) NOT NULL,
  `val_1` varchar(32) NOT NULL,
  `val_2` varchar(512) NOT NULL,
  `val_3` varchar(1024) NOT NULL,
  `val_int` int(11) NOT NULL,
  `val_date` datetime NOT NULL,
  `val_decimal` decimal(15,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `til_form_meta`
--

CREATE TABLE `til_form_meta` (
  `id` int(11) NOT NULL,
  `form_id` int(11) NOT NULL,
  `meta_key` varchar(32) NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `til_items`
--

CREATE TABLE `til_items` (
  `id` int(11) NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `date` datetime NOT NULL,
  `type` varchar(10) NOT NULL,
  `code` varchar(32) NOT NULL,
  `name` varchar(100) NOT NULL,
  `p_purc_out_vat` decimal(15,4) NOT NULL,
  `p_sale_out_vat` decimal(15,4) NOT NULL,
  `vat` int(2) NOT NULL,
  `p_purc` decimal(15,4) NOT NULL,
  `p_sale` decimal(15,4) NOT NULL,
  `quantity` int(11) NOT NULL,
  `total_purc` decimal(15,4) NOT NULL,
  `total_sale` decimal(15,4) NOT NULL,
  `profit` decimal(15,4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `til_logs`
--

CREATE TABLE `til_logs` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `uniquetime` char(15) NOT NULL,
  `table_id` varchar(20) NOT NULL,
  `user_id` int(11) NOT NULL,
  `log_url` varchar(250) NOT NULL,
  `log_key` varchar(64) NOT NULL,
  `log_text` varchar(500) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `til_log_meta`
--

CREATE TABLE `til_log_meta` (
  `id` int(11) NOT NULL,
  `log_id` int(11) NOT NULL,
  `meta_val` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `til_messages`
--

CREATE TABLE `til_messages` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `type` varchar(12) NOT NULL DEFAULT '',
  `top_id` int(11) NOT NULL,
  `sen_u_id` int(11) NOT NULL,
  `rec_u_id` int(11) NOT NULL,
  `title` varchar(255) NOT NULL,
  `message` text NOT NULL,
  `read_it` enum('0','1') NOT NULL DEFAULT '0',
  `inbox_u_id` int(11) NOT NULL,
  `outbox_u_id` int(11) NOT NULL,
  `date_update` datetime NOT NULL,
  `sen_trash_u_id` int(11) NOT NULL,
  `rec_trash_u_id` int(11) NOT NULL,
  `date_start` datetime NOT NULL,
  `date_end` datetime NOT NULL,
  `choice` text NOT NULL,
  `type_status` varchar(10) NOT NULL,
  `writing` varchar(255) NOT NULL DEFAULT '',
  `notification_seen` int(2) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `til_options`
--

CREATE TABLE `til_options` (
  `id` int(11) NOT NULL,
  `option_name` varchar(64) NOT NULL DEFAULT '',
  `option_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `til_users`
--

CREATE TABLE `til_users` (
  `id` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT '1',
  `username` varchar(255) NOT NULL,
  `password` char(32) NOT NULL,
  `name` varchar(20) NOT NULL,
  `surname` varchar(20) NOT NULL,
  `gsm` varchar(10) NOT NULL,
  `role` int(1) NOT NULL,
  `avatar` varchar(255) NOT NULL,
  `gender` enum('0','1') NOT NULL,
  `citizenship_no` varchar(20) NOT NULL,
  `til_login` tinyint(1) NOT NULL DEFAULT '0',
  `account_id` int(11) NOT NULL,
  `email` varchar(255) NOT NULL DEFAULT ''
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `til_user_meta`
--

CREATE TABLE `til_user_meta` (
  `id` bigint(20) NOT NULL,
  `user_id` bigint(20) NOT NULL,
  `meta_key` varchar(32) NOT NULL,
  `meta_value` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dökümü yapılmış tablolar için indeksler
--

--
-- Tablo için indeksler `til_accounts`
--
ALTER TABLE `til_accounts`
  ADD PRIMARY KEY (`id`),
  ADD KEY `code` (`code`),
  ADD KEY `name` (`name`),
  ADD KEY `gsm` (`gsm`),
  ADD KEY `name_2` (`name`),
  ADD KEY `gsm_2` (`gsm`);

--
-- Tablo için indeksler `til_extra`
--
ALTER TABLE `til_extra`
  ADD UNIQUE KEY `id` (`id`);

--
-- Tablo için indeksler `til_forms`
--
ALTER TABLE `til_forms`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `til_form_items`
--
ALTER TABLE `til_form_items`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `til_form_meta`
--
ALTER TABLE `til_form_meta`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `til_items`
--
ALTER TABLE `til_items`
  ADD UNIQUE KEY `id` (`id`);

--
-- Tablo için indeksler `til_logs`
--
ALTER TABLE `til_logs`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `til_log_meta`
--
ALTER TABLE `til_log_meta`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `til_messages`
--
ALTER TABLE `til_messages`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `til_options`
--
ALTER TABLE `til_options`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `til_users`
--
ALTER TABLE `til_users`
  ADD PRIMARY KEY (`id`);

--
-- Tablo için indeksler `til_user_meta`
--
ALTER TABLE `til_user_meta`
  ADD PRIMARY KEY (`id`);

--
-- Dökümü yapılmış tablolar için AUTO_INCREMENT değeri
--

--
-- Tablo için AUTO_INCREMENT değeri `til_accounts`
--
ALTER TABLE `til_accounts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `til_extra`
--
ALTER TABLE `til_extra`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `til_forms`
--
ALTER TABLE `til_forms`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `til_form_items`
--
ALTER TABLE `til_form_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `til_form_meta`
--
ALTER TABLE `til_form_meta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `til_items`
--
ALTER TABLE `til_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `til_logs`
--
ALTER TABLE `til_logs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `til_log_meta`
--
ALTER TABLE `til_log_meta`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `til_messages`
--
ALTER TABLE `til_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `til_options`
--
ALTER TABLE `til_options`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `til_users`
--
ALTER TABLE `til_users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
--
-- Tablo için AUTO_INCREMENT değeri `til_user_meta`
--
ALTER TABLE `til_user_meta`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
