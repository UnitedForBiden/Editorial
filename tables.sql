CREATE TABLE `editorial_article` (
  `id` int NOT NULL AUTO_INCREMENT,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `title` varchar(1000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `summary` varchar(5000) COLLATE utf8_unicode_ci DEFAULT NULL,
  `htmlcode` varchar(15000) COLLATE utf8_unicode_ci NOT NULL,
  `featured` bit(1) DEFAULT NULL,
  `archived` bit(1) DEFAULT NULL,
  `active` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

CREATE TABLE `editorial_comment` (
  `id` int NOT NULL,
  `article_id` int NOT NULL,
  `parent_id` int DEFAULT NULL,
  `created` datetime NOT NULL,
  `modified` datetime NOT NULL,
  `user_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `shown_name` varchar(200) COLLATE utf8_unicode_ci DEFAULT NULL,
  `raw_text` varchar(15000) COLLATE utf8_unicode_ci NOT NULL,
  `active` bit(1) NOT NULL DEFAULT b'1',
  PRIMARY KEY (`id`),
  KEY `article_id_idx` (`article_id`),
  CONSTRAINT `fk_article_id` FOREIGN KEY (`article_id`) REFERENCES `editorial_article` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
