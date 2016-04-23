<?php

namespace controller;

/**
 * Erweiterung des Controller um Standard Methoden
 *
 * * Information 1
 * * Information 2
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

    protected $zugangswerteDatenbankMySQL = array();

    /** @var $sparrow \models\Sparrow  */
    protected $sparrow = null;

    /** @var $twig  */
    protected $twig = null;

    protected $data = array();

    protected $request = null;

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
    }

    /**
     * Datenbank Zugangswerte MySQL
     */
    public function setDatenbank()
    {
        try{
            $this->zugangswerteDatenbankMySQL = \Flight::get('datenbankZugangswerte');
            $this->sparrow = new \models\Sparrow();
            $this->sparrow->setDb($this->zugangswerteDatenbankMySQL);

            return $this;
        }
        catch(\Exception $e){
            throw $e;
        }
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
}