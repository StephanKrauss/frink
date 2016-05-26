<?php

namespace tools;
use models\model;
use \RedBeanPHP\R as R;


/**
 * Initialisiert die Datenbanken
 * 
 * * Information 1
 * * Information 2
 *
 * @author Stephan.Krauss
 * @date 17.05.2016
 * @package Tool
 */
class verbindungen
{
    public static function connectDataSource($zugangswerte, $zugangRedis)
    {
        // erstellen PDO
        $pdo = new \PDO("mysql:host=".$zugangswerte['hostname'].";dbname=".$zugangswerte['database'],$zugangswerte['username'],$zugangswerte['password']);

        // Sparrow
        $sparrow = new \models\Sparrow();
        $sparrow->setDb($pdo);

        // NotNoSQL
        $notNoSql = new \models\notNoSql($pdo);

        // Redis
        $clientPredis = new \Predis\Client($zugangRedis);

        // Redbean
        R::setup("mysql:host=".$zugangswerte['hostname'].";dbname=".$zugangswerte['database'], $zugangswerte['username'], $zugangswerte['password']);
        // R::debug($zugangswerte['debug']);
        R::fancyDebug($zugangswerte['debug']);

        $redbean = R::getToolBox();

        return array($sparrow, $notNoSql, $clientPredis, $pdo, $redbean);
    }

}