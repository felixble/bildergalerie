--
-- Truncate all tables
--

SET FOREIGN_KEY_CHECKS = 0;
TRUNCATE `galery_pic_tag_map`;
TRUNCATE `galery_tag`;
TRUNCATE `galery_pic_rating`;
TRUNCATE `galery_pic_category_map`;
TRUNCATE `galery_picture_path`;
TRUNCATE `galery_pictures`;
TRUNCATE `galery_news_articles`;
TRUNCATE `galery_mandant`;
TRUNCATE `galery_categories`;
TRUNCATE `galery_artistic_style`;
TRUNCATE `galery_user`;
SET FOREIGN_KEY_CHECKS = 1;

--
-- Daten für Tabelle `galery_mandant`
--

INSERT INTO `galery_mandant` (`mandant_id`, `page_title`, `domain`, `galery_brand`) VALUES
  (1, 'SQE Bildergalerie', 'localhost:8888', 'Software Quality Engineering');

--
-- Daten für Tabelle `galery_user`
--

INSERT INTO `galery_user` (`mandant_id`, `user_id`, `username`, `password`, `salt`, `first_name`, `last_name`, `email`, `lastlogin`, `date_registered`) VALUES
  (1, 1, 'demo', '9b5d8180c0e4e6fa793eb53d7952d077', '4711', 'Demo', 'User', 'mail@demo.de', '2017-12-12 10:10:20', '2016-02-19 21:03:27');