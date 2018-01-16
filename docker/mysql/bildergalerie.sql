-- phpMyAdmin SQL Dump
-- version 4.4.10
-- http://www.phpmyadmin.net
--
-- Host: localhost:3306
-- Erstellungszeit: 12. Dez 2017 um 11:12
-- Server-Version: 5.5.42
-- PHP-Version: 5.6.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Datenbank: `bildergalerie`
--

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `galery_artistic_style`
--

CREATE TABLE `galery_artistic_style` (
  `mandant_id` int(11) NOT NULL,
  `style_id` int(11) NOT NULL,
  `style_name` varchar(128) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `galery_categories`
--

CREATE TABLE `galery_categories` (
  `mandant_id` int(11) NOT NULL,
  `category_id` int(11) NOT NULL,
  `category_name` varchar(128) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=13 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `galery_mandant`
--

CREATE TABLE `galery_mandant` (
  `mandant_id` int(11) NOT NULL,
  `page_title` varchar(512) COLLATE utf8_bin NOT NULL COMMENT 'z.B. Hildes Bildergalerie',
  `domain` varchar(128) COLLATE utf8_bin NOT NULL,
  `galery_brand` varchar(128) COLLATE utf8_bin NOT NULL COMMENT 'The name of the atelier or the artist owning the galery.'
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Daten für Tabelle `galery_mandant`
--

INSERT INTO `galery_mandant` (`mandant_id`, `page_title`, `domain`, `galery_brand`) VALUES
(1, 'SQE Bildergalerie', 'localhost:8888', 'Software Quality Engineering');

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `galery_news_articles`
--

CREATE TABLE `galery_news_articles` (
  `articel_id` int(11) NOT NULL,
  `mandant_id` int(11) NOT NULL,
  `title` varchar(128) CHARACTER SET utf8 NOT NULL,
  `content` text CHARACTER SET utf8 NOT NULL,
  `created_by` int(11) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `galery_pictures`
--

CREATE TABLE `galery_pictures` (
  `mandant_id` int(11) NOT NULL,
  `pic_id` int(11) NOT NULL,
  `path_id` int(11) NOT NULL,
  `style_id` int(11) DEFAULT NULL,
  `uid_created_by` int(11) NOT NULL COMMENT 'Benutzer, der das Bild hochgeladen hat',
  `uid_owner` int(11) NOT NULL COMMENT 'Eigentümer / Künstler',
  `title` varchar(128) COLLATE utf8_bin NOT NULL,
  `description` text COLLATE utf8_bin COMMENT 'Beschreibung/Bemerkung',
  `format` varchar(45) COLLATE utf8_bin DEFAULT NULL COMMENT 'z.B. 40x60',
  `material` varchar(128) COLLATE utf8_bin DEFAULT NULL COMMENT 'z.B. Acryl auf Leinwand',
  `price` double DEFAULT NULL,
  `price_public` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Wird der Preis angezeigt oder "auf Anfrage"',
  `salable` tinyint(1) DEFAULT '0' COMMENT 'verkäuflich?',
  `date_produced` date DEFAULT NULL COMMENT 'Wann wurde das Bild gemalt?',
  `date_created` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT 'Wann wurde das Bild hochgeladen?'
) ENGINE=InnoDB AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `galery_picture_path`
--

CREATE TABLE `galery_picture_path` (
  `mandant_id` int(11) NOT NULL,
  `pic_path_id` int(11) NOT NULL,
  `path` varchar(512) COLLATE utf8_bin NOT NULL,
  `thumb_path` varchar(512) COLLATE utf8_bin DEFAULT NULL,
  `uid_uploaded_by` int(11) NOT NULL,
  `date_uploaded` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=79 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `galery_pic_category_map`
--

CREATE TABLE `galery_pic_category_map` (
  `pic_id` int(11) NOT NULL,
  `cat_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `galery_pic_rating`
--

CREATE TABLE `galery_pic_rating` (
  `rating_id` int(11) NOT NULL,
  `ref_pic_id` int(11) NOT NULL,
  `rating_value` int(11) NOT NULL,
  `visitor_rating_id` varchar(128) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `galery_pic_tag_map`
--

CREATE TABLE `galery_pic_tag_map` (
  `pic_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `galery_tag`
--

CREATE TABLE `galery_tag` (
  `mandant_id` int(11) NOT NULL,
  `tag_id` int(11) NOT NULL,
  `tag_name` varchar(45) COLLATE utf8_bin NOT NULL
) ENGINE=InnoDB AUTO_INCREMENT=26 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

-- --------------------------------------------------------

--
-- Tabellenstruktur für Tabelle `galery_user`
--

CREATE TABLE `galery_user` (
  `mandant_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `username` varchar(45) COLLATE utf8_bin NOT NULL,
  `password` varchar(45) COLLATE utf8_bin NOT NULL COMMENT 'md5-hash mit salt',
  `salt` varchar(16) COLLATE utf8_bin NOT NULL,
  `first_name` varchar(128) COLLATE utf8_bin NOT NULL,
  `last_name` varchar(256) COLLATE utf8_bin NOT NULL,
  `email` varchar(256) COLLATE utf8_bin NOT NULL,
  `lastlogin` timestamp NULL DEFAULT NULL,
  `date_registered` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Daten für Tabelle `galery_user`
--

INSERT INTO `galery_user` (`mandant_id`, `user_id`, `username`, `password`, `salt`, `first_name`, `last_name`, `email`, `lastlogin`, `date_registered`) VALUES
(1, 1, 'demo', '9b5d8180c0e4e6fa793eb53d7952d077', '4711', 'Demo', 'User', 'mail@demo.de', '2017-12-12 10:10:20', '2016-02-19 21:03:27');

--
-- Indizes der exportierten Tabellen
--

--
-- Indizes für die Tabelle `galery_artistic_style`
--
ALTER TABLE `galery_artistic_style`
  ADD PRIMARY KEY (`style_id`),
  ADD KEY `fk_galery_artistic_style_galery_mandant1_idx` (`mandant_id`);

--
-- Indizes für die Tabelle `galery_categories`
--
ALTER TABLE `galery_categories`
  ADD PRIMARY KEY (`category_id`),
  ADD KEY `fk_galery_categories_galery_mandant1_idx` (`mandant_id`);

--
-- Indizes für die Tabelle `galery_mandant`
--
ALTER TABLE `galery_mandant`
  ADD PRIMARY KEY (`mandant_id`),
  ADD UNIQUE KEY `domain_UNIQUE` (`domain`);

--
-- Indizes für die Tabelle `galery_news_articles`
--
ALTER TABLE `galery_news_articles`
  ADD PRIMARY KEY (`articel_id`),
  ADD KEY `fk_galery_news_articles_galery_mandant1_idx` (`mandant_id`),
  ADD KEY `fk_galery_news_articles_galery_user1_idx` (`created_by`);

--
-- Indizes für die Tabelle `galery_pictures`
--
ALTER TABLE `galery_pictures`
  ADD PRIMARY KEY (`pic_id`),
  ADD KEY `fk_galery_pictures_galery_mandant_idx` (`mandant_id`),
  ADD KEY `fk_galery_pictures_galery_artistic_style1_idx` (`style_id`),
  ADD KEY `fk_galery_pictures_galery_user2_idx` (`uid_owner`),
  ADD KEY `fk_galery_pictures_galery_picture_path1_idx` (`path_id`),
  ADD KEY `fk_galery_pictures_galery_user1_idx` (`uid_created_by`);

--
-- Indizes für die Tabelle `galery_picture_path`
--
ALTER TABLE `galery_picture_path`
  ADD PRIMARY KEY (`pic_path_id`),
  ADD KEY `fk_galery_picture_path_galery_mandant1_idx` (`mandant_id`);

--
-- Indizes für die Tabelle `galery_pic_category_map`
--
ALTER TABLE `galery_pic_category_map`
  ADD PRIMARY KEY (`pic_id`,`cat_id`),
  ADD KEY `fk_galery_pic_category_map_galery_categories1_idx` (`cat_id`);

--
-- Indizes für die Tabelle `galery_pic_rating`
--
ALTER TABLE `galery_pic_rating`
  ADD PRIMARY KEY (`rating_id`),
  ADD KEY `fk_galery_pic_rating_galery_pictures1_idx` (`ref_pic_id`);

--
-- Indizes für die Tabelle `galery_pic_tag_map`
--
ALTER TABLE `galery_pic_tag_map`
  ADD PRIMARY KEY (`pic_id`,`tag_id`),
  ADD KEY `fk_galery_pic_tag_map_galery_pictures1_idx` (`pic_id`),
  ADD KEY `fk_galery_pic_tag_map_galery_tag1_idx` (`tag_id`);

--
-- Indizes für die Tabelle `galery_tag`
--
ALTER TABLE `galery_tag`
  ADD PRIMARY KEY (`tag_id`),
  ADD UNIQUE KEY `tag_name_UNIQUE` (`tag_name`),
  ADD KEY `fk_galery_tag_galery_mandant1_idx` (`mandant_id`);

--
-- Indizes für die Tabelle `galery_user`
--
ALTER TABLE `galery_user`
  ADD PRIMARY KEY (`user_id`),
  ADD KEY `fk_galery_user_galery_mandant1_idx` (`mandant_id`);

--
-- AUTO_INCREMENT für exportierte Tabellen
--

--
-- AUTO_INCREMENT für Tabelle `galery_artistic_style`
--
ALTER TABLE `galery_artistic_style`
  MODIFY `style_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `galery_categories`
--
ALTER TABLE `galery_categories`
  MODIFY `category_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=13;
--
-- AUTO_INCREMENT für Tabelle `galery_mandant`
--
ALTER TABLE `galery_mandant`
  MODIFY `mandant_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=3;
--
-- AUTO_INCREMENT für Tabelle `galery_news_articles`
--
ALTER TABLE `galery_news_articles`
  MODIFY `articel_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `galery_pictures`
--
ALTER TABLE `galery_pictures`
  MODIFY `pic_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=23;
--
-- AUTO_INCREMENT für Tabelle `galery_picture_path`
--
ALTER TABLE `galery_picture_path`
  MODIFY `pic_path_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=79;
--
-- AUTO_INCREMENT für Tabelle `galery_pic_rating`
--
ALTER TABLE `galery_pic_rating`
  MODIFY `rating_id` int(11) NOT NULL AUTO_INCREMENT;
--
-- AUTO_INCREMENT für Tabelle `galery_tag`
--
ALTER TABLE `galery_tag`
  MODIFY `tag_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=26;
--
-- AUTO_INCREMENT für Tabelle `galery_user`
--
ALTER TABLE `galery_user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=2;
--
-- Constraints der exportierten Tabellen
--

--
-- Constraints der Tabelle `galery_artistic_style`
--
ALTER TABLE `galery_artistic_style`
  ADD CONSTRAINT `fk_galery_artistic_style_galery_mandant1` FOREIGN KEY (`mandant_id`) REFERENCES `galery_mandant` (`mandant_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `galery_categories`
--
ALTER TABLE `galery_categories`
  ADD CONSTRAINT `fk_galery_categories_galery_mandant1` FOREIGN KEY (`mandant_id`) REFERENCES `galery_mandant` (`mandant_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `galery_news_articles`
--
ALTER TABLE `galery_news_articles`
  ADD CONSTRAINT `fk_galery_news_articles_galery_mandant1` FOREIGN KEY (`mandant_id`) REFERENCES `galery_mandant` (`mandant_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_galery_news_articles_galery_user1` FOREIGN KEY (`created_by`) REFERENCES `galery_user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `galery_pictures`
--
ALTER TABLE `galery_pictures`
  ADD CONSTRAINT `fk_galery_pictures_galery_artistic_style1` FOREIGN KEY (`style_id`) REFERENCES `galery_artistic_style` (`style_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_galery_pictures_galery_mandant` FOREIGN KEY (`mandant_id`) REFERENCES `galery_mandant` (`mandant_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_galery_pictures_galery_picture_path1` FOREIGN KEY (`path_id`) REFERENCES `galery_picture_path` (`pic_path_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_galery_pictures_galery_user1` FOREIGN KEY (`uid_created_by`) REFERENCES `galery_user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_galery_pictures_galery_user2` FOREIGN KEY (`uid_owner`) REFERENCES `galery_user` (`user_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `galery_picture_path`
--
ALTER TABLE `galery_picture_path`
  ADD CONSTRAINT `fk_galery_picture_path_galery_mandant1` FOREIGN KEY (`mandant_id`) REFERENCES `galery_mandant` (`mandant_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `galery_pic_category_map`
--
ALTER TABLE `galery_pic_category_map`
  ADD CONSTRAINT `fk_galery_pic_category_map_galery_categories1` FOREIGN KEY (`cat_id`) REFERENCES `galery_categories` (`category_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_galery_pic_category_map_galery_pictures1` FOREIGN KEY (`pic_id`) REFERENCES `galery_pictures` (`pic_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `galery_pic_rating`
--
ALTER TABLE `galery_pic_rating`
  ADD CONSTRAINT `fk_galery_pic_rating_galery_pictures1` FOREIGN KEY (`ref_pic_id`) REFERENCES `galery_pictures` (`pic_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `galery_pic_tag_map`
--
ALTER TABLE `galery_pic_tag_map`
  ADD CONSTRAINT `fk_galery_pic_tag_map_galery_pictures1` FOREIGN KEY (`pic_id`) REFERENCES `galery_pictures` (`pic_id`) ON DELETE NO ACTION ON UPDATE NO ACTION,
  ADD CONSTRAINT `fk_galery_pic_tag_map_galery_tag1` FOREIGN KEY (`tag_id`) REFERENCES `galery_tag` (`tag_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `galery_tag`
--
ALTER TABLE `galery_tag`
  ADD CONSTRAINT `fk_galery_tag_galery_mandant1` FOREIGN KEY (`mandant_id`) REFERENCES `galery_mandant` (`mandant_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Constraints der Tabelle `galery_user`
--
ALTER TABLE `galery_user`
  ADD CONSTRAINT `fk_galery_user_galery_mandant1` FOREIGN KEY (`mandant_id`) REFERENCES `galery_mandant` (`mandant_id`) ON DELETE NO ACTION ON UPDATE NO ACTION;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
