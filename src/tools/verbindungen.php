<?php

namespace tools;

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
        try {
           $pdo = new \PDO("mysql:host=".$zugangswerte['hostname'].";dbname=".$zugangswerte['database'],$zugangswerte['username'],$zugangswerte['password']);
        }
        catch (\Exception $e) {
           throw $e;
        }

        // Sparrow
        $sparrow = new \models\Sparrow();
        $sparrow->setDb($pdo);

        // NotNoSQL
        $notNoSql = new \models\notNoSql($pdo);

        // Redis
        $clientPredis = new \Predis\Client($zugangRedis);

        // Redbean Wrapper, Aufruf als Instance
        $redbeanWrapper = new \tools\redbeanWrapper();
        $redbeanWrapper->setup("mysql:host=".$zugangswerte['hostname'].";dbname=".$zugangswerte['database'], $zugangswerte['username'], $zugangswerte['password']);
        // $redbeanWrapper->debug($zugangswerte['debug']);
        // R::fancyDebug($zugangswerte['debug']);

        // $redbean = R::getToolBox();

        // Konfiguration ORM Spot2
        $configSpot = new \Spot\Config();
        $configSpot->addConnection('mysql','mysql://'.$zugangswerte['username'].':'.$zugangswerte['password'].'@localhost/'.$zugangswerte['database']);

        /** @var $spot \Spot\Locator */
        $spot = new \Spot\Locator($configSpot);

        return array($sparrow, $notNoSql, $clientPredis, $pdo, $redbeanWrapper, $spot);
    }

}