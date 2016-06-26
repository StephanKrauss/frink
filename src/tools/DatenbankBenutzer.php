<?php

namespace tools;

/**
* schreibt den Benutzer in die Datenbank
*
* @author Stephan Krauß
* @copyright Stephan Krauss
* @lisence Stephan Krauß
* @date 03.06.2016
*
* @package tools
*/

class DatenbankBenutzer
{
    public static function benutzer(\models\session $session, \PDO $pdo)
    {
        $benutzerId = $session->read('benutzerId');

        $pdo->query("set @benutzerId = ".$benutzerId);
    }
}