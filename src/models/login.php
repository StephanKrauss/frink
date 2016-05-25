<?php

namespace models;

/**
* Klasse ur Authentifikation des Benutzers. Wird zum Login und vor der Verwendung einer Action in einem Controller verwendet
*
* + Kontrolle Login des Benutzers und speichern der Variablen in der Session
* + Kontrolle des Zugang zur Action eines Controller
*
* @package Model
* @date 25.05.2016
* @author Stephan Krauß
*/

class auth {

    //pass salting constates
    CONST PRE_SALT = 'dEmoS75AUNT?';
    CONST POST_SALT = 'plOD@pAR14';

    private static $dbh;
    private static $instance;

    private function __construct() {
    }

    /**
     *
     * @return the same instance of the class
     */
    public static function i() {
        if (empty(self::$instance)) {
            self::$instance = new TinyAuth();
        }
        
        return self::$instance;
    }

    /**
     * @param str $login
     * @param str $pass
     */
    public function login($login, $pass) {
        $auth = $this -> auth($login, $pass);
        if ($auth != false) {
            $_SESSION['login'] = $login . ',' . md5(md5(uniqid()) . $login . md5(uniqid()));
            $_SESSION['name'] = $auth['name'];
            $_SESSION['role_id'] = $auth['role_id'];
            $_SESSION['role_name'] = $this -> getRole($auth['role_id']);
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param str $login
     * @param str $pass
     */

    private function auth($login, $pass) {
        $sth = self::db() -> prepare('SELECT
                                        usr.name AS name,
                                        usr.login,
                                        usr.role_id
                                    FROM
                                        users AS usr
                                    WHERE
                                        usr.login = :login
                                    AND usr.pass = :pass');
        $saltedPass = $this -> makeHash($pass);
        $sth -> bindValue(':login', $login, PDO::PARAM_STR);
        $sth -> bindValue(':pass', $saltedPass, PDO::PARAM_STR);
        $sth -> execute();
        $data = $sth -> fetchAll(PDO::FETCH_ASSOC)[0];
        if (!$data) {
            return false;
        } else {
            return $data;
        }
    }

    /**
     * @param str $pass
     * @return str salted password hash
     */
    private function makeHash($pass) {
        $h1 = md5($pass);
        $h2 = md5(self::PRE_SALT . $pass . self::POST_SALT);
        return $h2;
    }

    /**
     * Destroys all data registered to a session
     */
    public function logout() {
        session_destroy();
    }

    /**
     * @param int $id role id
     * @return id and role name
     */
    public function getRole($id = null) {
        $sth = self::db() -> prepare('SELECT
                                    id,
                                    name
                                FROM
                                    roles
                                WHERE id = :id');
        if (isset($_SESSION['role_id'])) {
            $sth -> bindValue(':id', $_SESSION['role_id'], PDO::PARAM_INT);
        } else {
            $sth -> bindValue(':id', $_SESSION['role_id'], $id);
        }
        $sth -> execute();
        return $sth -> fetchAll(PDO::FETCH_ASSOC)[0];
    }

    /**
     * Getting authorization status
     * @return bool true - logined; false - logouted
     */
    public function getAuthStatus() {
        return isset($_SESSION['login']) ? true : false;
    }

    /**
     * Getting user name
     * @return str logined usr name
     */
    public function getName() {
        return isset($_SESSION['name']) ? $_SESSION['name'] : false;
    }
}
?>