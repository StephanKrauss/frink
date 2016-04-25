/*Table structure for table `articles` */

CREATE TABLE `articles` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `title` varchar(80) DEFAULT NULL,
  `teaser` varchar(255) DEFAULT NULL,
  `news` longtext,
  `created_at` datetime DEFAULT NULL,
  `publish_at` datetime DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `tagging` */

CREATE TABLE `tagging` (
  `article_id` int(5) DEFAULT NULL,
  `tag_id` int(5) DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `tags` */

CREATE TABLE `tags` (
  `id` int(5) NOT NULL AUTO_INCREMENT,
  `title` varchar(25) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

/*Table structure for table `users` */

CREATE TABLE `users` (
  `id` int(10) NOT NULL AUTO_INCREMENT,
  `email` varchar(255) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;