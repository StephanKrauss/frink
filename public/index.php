<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');

// System Konfiguration
require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../app/config/routes.php';

\Flight::start();