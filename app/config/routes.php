<?php

// Start Session
session_start();

// Aufruf Baustein 'login' , Erststart
\Flight::route('/', function()
{
    // Konfiguration
    readConfig();

    // Datenbanken
    connectDatabase();

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
    readConfig();

    // Datenbanken
    connectDatabase();

    // Twig
    startTwig();

    // ermitteln der übergebenen Parameter
    $data = ermittelnStartParams();

    // Controller
    $controllerString = "controller\\$controller";
    $controller = new $controllerString($controller, $action);
    
    // Startroutinen des Controller
    startController($controller, $action, $data);
});

// Mapping 'not found'
\Flight::map('notFound', function() {
    // \Flight::render('404', array());
    Flight::redirect('/start/index');
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
    // spezielle Konfiguration , Bsp.: 'salt'
    // include_once('../app/config/config.php');
    // \Flight::set('config', $config);

    // Datenbank Zugangswerte MySQL
    include_once('../app/config/datenbank.php');
    \Flight::set('datenbankZugangswerte', $zugangswerte);

    // Datenbank NoSQL, Redis
    include_once('../app/config/redis.php');
    \Flight::set('datenbankRedis',$zugangRedis);

    return;
}

function connectDatabase()
{
    $zugangswerte = \Flight::get('datenbankZugangswerte');

    // erstellen PDO
    $pdo = new \PDO("mysql:host=".$zugangswerte['hostname'].";dbname=".$zugangswerte['database'],$zugangswerte['username'],$zugangswerte['password']);
    \Flight::set('pdo',$pdo);

    // Sparrow
    $sparrow = new \models\Sparrow();
    $sparrow->setDb($pdo);
    \Flight::set('sparrow', $sparrow);

    // NotNoSQL
    $notNoSql = new \models\notNoSql($pdo);
    \Flight::set('notnosql',$notNoSql);

    // Redis
    $zugangRedis = \Flight::get('datenbankRedis');
    $clientPredis = new \Predis\Client($zugangRedis);
    \Flight::set('predis',$clientPredis);

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

/**
 * ermitteln Startparameter
 *
 * @return array
 */
function ermittelnStartParams()
{
    $request = \Flight::request();
    $params = array();

    if($request->method == 'POST'){
        $params = $_POST;
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