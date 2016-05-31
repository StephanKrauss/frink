-- Tabelle zum speichern der Session

CREATE TABLE `user_sessions` (
  `id` varchar(32) CHARACTER SET latin1 COLLATE latin1_general_ci NOT NULL DEFAULT '',
  `fingerprint` varchar(100) CHARACTER SET latin1 COLLATE latin1_general_ci DEFAULT NULL,
  `data` text CHARACTER SET latin1 COLLATE latin1_general_ci,
  `access` int(32) NOT NULL DEFAULT '0',
  `date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8

-- Tabelle zum speichern der Exception
