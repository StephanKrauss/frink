<?php

// Start Session
session_start();

// Aufruf Baustein 'login' , Erststart
\Flight::route('/', function()
{
    // Konfiguration
    standardStart();

    // Controller
    include_once('../src/Controller/start.php');
    $controller = new \controller\start('start', 'index');

    // Startroutinen des Controller
    startController($controller, 'index');
});

// Aufruf Baustein, mit Anzeigesprache
\Flight::route('/@controller(/@action)(/@wert/@inhalt)',function($controller, $action, $wert, $inhalt)
{
    if($action == null)
        $action = 'index';

    // Konfiguration
    standardStart();

    // ermitteln der übergebenen Parameter
    $data = ermittelnDaten();

    // Controller
    $controllerString = "controller\\$controller";
    $controller = new $controllerString($controller, $action);
    
    // Startroutinen des Controller
    startController($controller, $action, $data);
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
function startController($controller, $action = 'index', $data = null)
{
    $controller->setDatenbank();
    $controller->setTwig();

    $request = \Flight::request();
    $controller->setRequest($request);

    if( (is_array($data)) and (count($data) > 0) )
        $controller->setData($data);

    $controller->$action();
}

function ermittelnDaten()
{
    $request = \Flight::request();
    $data = array();

    if($request->method == 'POST'){
        $data = $_POST;
    }

    if($request->method == 'GET'){
        $url = $request->url;
        $url = ltrim($url,'/');
        $url = rtrim($url, '/');

        $splitUrl = explode('/',$url);

        if(isset($splitUrl[0]))
            unset($splitUrl[0]);
        if(isset($splitUrl[1]))
            unset($splitUrl[1]);

        $splitUrl = array_merge($splitUrl);
        if(count($splitUrl) > 0)
            $data[$splitUrl[0]] = $splitUrl[1];
    }

    return $data;
}