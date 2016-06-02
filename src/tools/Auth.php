<?php
/**
* Überprüft die Berechtigung des Zugriff auf einen Controller
*
* @author Stephan Krauß
* @lisence MIT
* @date 02.06.2016
* @copyright Stephan Krauss
*
* @package models
*/

namespace tools;


class Auth
{
    /**
     * überprüft die Berechtigung des Zugriff auf einen Controller
     *
     * @param $controller
     */
    public static function checkAccessController(\models\session $session, \PDO $databasePdo, $controller)
    {
        $rolleId = $session->read('rolleId');

        $result = $databasePdo->query("select rolle_id from navigation where name = '".$controller."'", $databasePdo::FETCH_ASSOC);

        foreach($result as $row){
            $controllerRolleId = $row['rolle_id'];

            break;
        }

        if( (empty($rolleId)) or ($rolleId < $controllerRolleId) ){
            $session->write('rolleId', 1);
            $session->write('benutzerId',0);
            $session->destroy(session_id());

            \Flight::redirect('/start/index');
        }

        return;
    }


}