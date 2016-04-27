<?php
	/**
	 * Verbindung zur Redis Datenbank
	 *
	 * @author Stephan Krauß
	 * @date 27.04.2016
	 * @file redis.php
	 * @package config
	 */

define('REDIS_DSN','redis://redistogo:237f03a3baac571fc6600b78485673a7@hoki.redistogo.com:9311/');
//    define('REDIS_SOCKET', 'unix:///tmp/redis.sock');
//    define('REDIS_PWD', md5('Realy long').md5(' and ').md5(' hard ').md5(' password '));

define('CRLF', sprintf('%s%s', chr(13), chr(10)));