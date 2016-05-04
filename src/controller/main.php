<?php

namespace controller;
use tools\frinkError;

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

    /**
     * main constructor.
     * 
     * @param $controllerName
     * @param $actionName
     */
    public function __construct($controllerName, $actionName)
    {
        $this->controllerName = $controllerName;
        $this->actionName = $actionName;
        $this->templateName = $controllerName.".html";

        // Startparameter
        $this->request = \Flight::request();
        $this->params = \Flight::get('params');

        // Datenbanken
        $this->notNoSql = \Flight::get('notnosql');
        $this->sparrow = \Flight::get('sparrow');
        $this->predis = \Flight::get('predis');
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
}