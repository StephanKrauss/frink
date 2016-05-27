<?php

// Aufruf Baustein 'login' , Erststart
\Flight::route('/', function()
{
    // Konfiguration
    readConfig();

    // Session
    sessionStart();

    $zugangswerte = \Flight::get('datenbankZugangswerte');
    $zugangRedis = \Flight::get('datenbankRedis');

    // Datenbanken
    list($sparrow, $notNoSql, $clientPredis, $pdo, $redbean) = \tools\verbindungen::connectDataSource($zugangswerte, $zugangRedis);
    \Flight::set('sparrow', $sparrow);
    \Flight::set('notnosql',$notNoSql);
    \Flight::set('predis',$clientPredis);
    \Flight::set('pdo',$pdo);
    \Flight::set('redbean',$redbean);

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
    try{
        if($action == null)
            $action = 'index';

        // Konfiguration
        readConfig();

        // Session
        sessionStart();

        // Zuganswerte Datenbanken
        $zugangswerte = \Flight::get('datenbankZugangswerte');
        $zugangRedis = \Flight::get('datenbankRedis');

        // Datenbanken
        list($sparrow, $notNoSql, $clientPredis, $pdo, $redbean) = \tools\verbindungen::connectDataSource($zugangswerte, $zugangRedis);
        \Flight::set('sparrow', $sparrow);
        \Flight::set('notNoSql',$notNoSql);
        \Flight::set('predis',$clientPredis);
        \Flight::set('pdo',$pdo);
        \Flight::set('zugangswerte',$zugangswerte);
        \Flight::set('redbean',$redbean);

         // Twig
        startTwig();

        // Request
        $request = \Flight::request();

        // ermitteln der übergebenen Parameter
        $data = ermittelnStartParams($request);

        // Plugins
        $plugins = new \models\plugins($request);
        $request = $plugins->getRequest();
    }
    catch(\Exception $e){
        throw $e;
    }

    // Start Action des Controller
    try{
        // Kontrolle Controller
        $controllerPath = realpath(__DIR__ . '../../../src/controller/'.$controller.'.php');

        if(empty($controllerPath))
            throw new \tools\frinkError('Controller unbekannt', 3);

        // Controller
        $controllerString = "controller\\$controller";

        $controller = new $controllerString($controller, $action);

        // Kontrolle Aktion
        if(!method_exists($controller, $action))
            throw new \tools\frinkError('Action unbekannt', 3);

        startController($controller, $action, $data);
    }
    catch(\Exception $e){
        throw $e;
    }
});

// Mapping 'Error Controller'
\Flight::map('error', function(\Exception $e)
{
    // Controller
    include_once('../src/controller/error.php');

    $controller = new \controller\error('index', 'setError');
    $controller->setError($e);
    $controller->index();
});

/*** eigene Funktionen ***/

/**
* Datenbank Zugangswerte und allgemeine Konfiguration
*
* @return array
*/
function readConfig()
{
    //Array with configs pathes
    $configFiles = array(
        realpath("../app/config/config.ini")
        // realpath("../app/config/config2.ini")
    );

    $iniParser = new \models\iniparser();
    $config = $iniParser->parse($configFiles);
    
    // alle Config Vars
    \Flight::set('config',$config);

    // Datenbank Zugangswerte MySQL
    \Flight::set('datenbankZugangswerte', $config['zugangswerte']);

    // Datenbank NoSQL, Redis
    \Flight::set('datenbankRedis',$config['redis']['zugangRedis']);

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
    // Übernahme Parameter
    if( (is_array($data)) and (count($data) > 0) )
        $controller->setData($data);

    // Übernahme Zugangswerte MySQL
    $controller->zugangswerte = \Flight::get('zugangswerte');

    // Initialisieren Redbean
    $controller->startRedbean();

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

/**
 * ermitteln Startparameter
 *
 * @return array
 */
function ermittelnStartParams($request)
{
    $params = array();

    if($request->method == 'POST'){
        // $params = $_POST;
        $params = $request->data;
    }

    if($request->method == 'GET'){
        $url = $request->url;

        // URL Decode
        $url = urldecode($url);

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
                    $params[$key] = $splitUrl[$i];
                    $key = null;
                }
                else{
                    $key = $splitUrl[$i];
                }

                $j++;
            }
        }
    }

    \Flight::set('params', $params);

    return;
}

/**
 * Initialisiert die Session
 */
function sessionStart()
{
    $session = new \models\session();
    \Flight::set('session', $session);

    return;
}