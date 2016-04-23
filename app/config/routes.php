<?php

// Start Session
session_start();

// Aufruf Baustein 'login' , Erststart
\Flight::route('/', function()
{
    // Konfiguration
    standardStart();

    // Twig
    startTwig();

    // Controller
    include_once('../src/Controller/start.php');
    $controller = new \controller\start('start', 'index');

    // Startroutinen des Controller
    startController($controller, 'index');
});

// Aufruf Baustein, mit Anzeigesprache
\Flight::route('/@controller/@action(/*)',function($controller, $action)
{
    if($action == null)
        $action = 'index';

    // Konfiguration
    standardStart();

    // Twig
    startTwig();

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
    Flight::redirect('/start/index');
});

// Error Controller
\Flight::map('error', function(\Exception $e)
{
    // Controller
    include_once('../src/controller/error.php');

    $controller = new \controller\error('error', 'index');
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
    // include_once('../app/config/config.php');
    // \Flight::set('config', $config);

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

    if( (is_array($data)) and (count($data) > 0) )
        $controller->setData($data);

    $controller->$action();
}

/**
 * Twig Template Engine
 */
function startTwig()
{
    $viewPath = __DIR__.'\..\..\public\tpl\\';
    $viewPath = realpath($viewPath);

    $loader = new Twig_Loader_Filesystem($viewPath);

    $twigConfig = array(
        // 'cache' => './cache/twig/',
        // 'cache' => false,
        'debug' => true,
    );

    Flight::register('view', 'Twig_Environment', array($loader, $twigConfig), function ($twig) {
        $twig->addExtension(new Twig_Extension_Debug()); // Add the debug extension
    });

    return;
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

        $j=1;
        if(count($splitUrl) >= 2){

            $key = null;
            for($i = 0; $i < count($splitUrl); $i++){
                if($j % 2 == 0){
                    $data[$key] = $splitUrl[$i];
                    $key = null;
                }
                else{
                    $key = $splitUrl[$i];
                }

                $j++;
            }
        }
    }

    return $data;
}