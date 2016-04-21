<?php

// Start Session
session_start();

// Aufruf Baustein 'login' , Erststart
\Flight::route('/', function()
{
    // $request = Flight::request();

    // ermitteln Konfiguration
    standardStart();

    // Controller
    include_once('../src/Controller/start.php');
    $controller = new \controller\start('start', 'index');

    // Startroutinen des Controller
    startController($controller, 'index');
});

// Mapping
\Flight::map('notFound', function() {
    // \Flight::render('404', array());
    Flight::redirect('/login/index');
});

// Error Controller
\Flight::map('error', function(\Exception $e)
{
    // Controller
    include_once('../src/Controller/error.php');

    $controller = new \Controller\error('error', 'index');
    $controller->setError($e);
    $controller->index();
});

/*** eigene Funktionen ***/

/**
* Datenbank Zugangswerte und allgemeine Konfiguration
*
* @return array
*/
function standardStart()
{
    $request = \Flight::request();

    // spezielle Konfiguration , Bsp.: 'salt'
    include_once('../app/config/config.php');
    \Flight::set('config', $config);

    // Datenbank Zugangswerte
    include_once('../app/config/datenbank.php');
    \Flight::set('datenbankZugangswerte', $zugangswerte);

    return;
}

/**
* Start des Controller und der Action
*
* @param $controller
* @param $action
*/
function startController($controller, $action = 'index')
{
    $controller->setDatenbank();
    // $controller->setRequest();
    // $controller->setConfig();
    $controller->$action();
}

function ermittelnDaten()
{
    $request = \Flight::request();

    if($request->method == 'POST'){
        \Flight::set('data',$_POST);
    }

    return;
}