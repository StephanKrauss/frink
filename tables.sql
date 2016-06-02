-- Tabelle zum speichern der Session

CREATE TABLE `user_sessions` (
  `id` varchar(32) NOT NULL DEFAULT '',
  `fingerprint` varchar(100) DEFAULT NULL,
  `data` text,
  `access` int(32) NOT NULL DEFAULT '0',
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- Tabelle zum speichern der Exception

CREATE TABLE `exception` (
  `id` mediumint(5) NOT NULL AUTO_INCREMENT,
  `message` varchar(250) NOT NULL,
  `code` mediumint(5) NOT NULL,
  `file` varchar(250) NOT NULL,
  `line` mediumint(5) NOT NULL,
  `trace` text NOT NULL,
  `session` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

--  Tabelle Benutzer

CREATE TABLE `benutzer` (
  `id` MEDIUMINT(5) NOT NULL AUTO_INCREMENT,
  `name` VARCHAR(100) NOT NULL,
  `vorname` VARCHAR(100) NOT NULL,
  `passwort` VARCHAR(250) NOT NULL,
  `rolle` TINYINT(3) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `rolle` (`rolle`),
  CONSTRAINT `benutzer_ibfk_1` FOREIGN KEY (`rolle`) REFERENCES `rollen` (`id`) ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=INNODB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;

-- Tabelle Rollen

CREATE TABLE `rollen` (
  `id` tinyint(3) NOT NULL AUTO_INCREMENT,
  `bezeichnung` varchar(250) NOT NULL COMMENT 'Name der Rolle',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8;