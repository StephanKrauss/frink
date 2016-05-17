<?php

namespace controller;
use tools\frinkError;
use Pimple\Container;

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

    public $pimple = null;

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
        $this->params = \Flight::get('params');
    }

    /**
     * Übernimmt die benötigten Model / Tool der Klasse sowie der Standardklassen
     *
     * @param array $values
     */
    protected function pimple($values = array())
    {
        // Datenbanken aus Bootstrap
        $defaults = array(
            'notNoSql' => \Flight::get('notnosql'),
            'sparrow' => \Flight::get('sparrow'),
            'predis' => \Flight::get('predis')
        );

        $this->pimple = new Container(array_merge($defaults, $values));

        return $this->pimple;
    }

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
    }

    public function sendLoggerMessage($message)
    {
        // eintragen / versenden der Message
        $test = 123;

        // Verwendung firelog zur Darstellung der Message im 'develop' - Modus

        // Registrierung der Message in Tabelle / Mail


        return;
    }
}