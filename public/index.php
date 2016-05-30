<?php
// Start Session
// session_start();

error_reporting(E_ALL & ~E_NOTICE);
ini_set('display_errors', '1');
	
require __DIR__ . '/../vendor/autoload.php';

// System Konfiguration	
require __DIR__ . '/../app/config/bootstrap.php';

\Flight::start();