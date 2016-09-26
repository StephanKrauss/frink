<?php

namespace controller;

use tools\frinkError;
use Pimple\Container;
use \RedBeanPHP\R as R;

/**
 * Erweiterung des Controller um Standard Methoden
 *
 * @author Stephan.Krauss
 * @date 21.04.2016
 * @package Controller
 */
class main
{
    protected $controllerName = null;
    protected $actionName = null;
    protected $templateName = null;

    protected $params = array();

    protected $request = null;

    /** @var $sparrow \models\Sparrow  */
    protected $sparrow = null;
    /** @var $notNoSql \models\notNoSql */
    protected $notNoSql = null;
    /** $redis \Predis\Client */
    protected $predis = null;
    /** @var $redbean \RedBeanPHP\R  */
    protected $redbean = null;

    // DIC
    public $pimple = null;

    // Zugangswerte MySQL
    public $zugangswerte = array();


    /**
     * main constructor.
     * 
     * @param $controllerName
     * @param $actionName
     */
    public function __construct($controllerName, $actionName)
    {
        // allgemeine Angaben
        $this->controllerName = $controllerName;
        $this->actionName = $actionName;
        $this->templateName = $controllerName.".html";

        // Startparameter
        $this->request = \Flight::request();
        $this->params = \Flight::get('params')->getData();
    }

    /**
     * ermittelt die Parameter des Debug Block
     *
     * @param $session
     */
    public function setDebug($session)
    {
        $debugBlock = $session->readCompleteSession();

        return $debugBlock;
    }

    /**
     * Übernimmt die benötigten Model / Tool der Klasse sowie der Standardklassen
     *
     * @param array $values
     */
    protected function pimple($values = array())
    {
        // Datenbanken in Pimple übernehmen aus bootstrap.php
        $defaults = array(
            'notNoSql' => \Flight::get('notnosql'),
            'sparrow' => \Flight::get('sparrow'),
            'predis' => \Flight::get('predis'),
            'notNoSql' => \Flight::get('notNoSql'),
            'pdo' => \Flight::get('pdo'),
            'redbean' => \Flight::get('redbean'),
            'spot' => \Flight::get('spot')
        );

        $this->pimple = new Container(array_merge($defaults, $values));

        return $this->pimple;
    }

    /**
     * Übernimmt die Parameter des Aufruf
     *
     * @param array $data
     * @return $this
     * @throws \Exception
     */
    public function setData(array $data)
    {
        try{
            if( (is_array($data)) and (count($data) > 0) )
                $this->data = $data;

            return $this;
        }
        catch(\Exception $e){
            throw $e;
        }
    }

    public function __call($actionName, $params)
    {
        throw new \tools\frinkError('unbekannt Action', 3);

        return;
    }

    /**
     * Dummy Funktion zum senden einer Message
     *
     * @param $message
     */
    public function sendLoggerMessage($message)
    {
        // eintragen / versenden der Message
        $test = 123;

        // Verwendung firelog zur Darstellung der Message im 'develop' - Modus

        // Registrierung der Message in Tabelle / Mail


        return;
    }

    /**
     * Start Redbean ORM
     */
    public function startRedbean()
    {
        $this->redbean = \Flight::get('redbean');

        return;
    }
}