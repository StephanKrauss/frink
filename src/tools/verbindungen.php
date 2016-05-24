<?php

namespace tools;
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
    public static function connectDatabase($zugangswerte, $zugangRedis)
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

        return array($sparrow, $notNoSql, $clientPredis, $pdo);
    }

}