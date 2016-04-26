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

    /** @var $sparrow \models\Sparrow  */
    protected $sparrow = null;

    /** @var $notNoSql  */
    protected $notNoSql = null;

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
            $zugangswerteDatenbankMySQL = \Flight::get('datenbankZugangswerte');

            // erstellen PDO
            $pdo = new \PDO("mysql:host=".$zugangswerteDatenbankMySQL['hostname'].";dbname=".$zugangswerteDatenbankMySQL['database'],$zugangswerteDatenbankMySQL['username'],$zugangswerteDatenbankMySQL['password']);

            // Sparrow
            $this->sparrow = new \models\Sparrow();
            $this->sparrow->setDb($pdo);

            // NotNoSQL
            $this->notNoSql = new \tools\notNoSql($pdo);

            // Test NotNoSql
            $programme100 = array(
                '100' => array(
                    'name' => array(
                        'deutsch' => 'deutscher Name 100',
                        'englisch' => 'englischer Name 100'
                    ),
                    'beschreibung' => array(
                        'deutsch' => 'Beschreibung deutsch 100',
                        'englisch' => 'Beschreibung englich 100'
                    )
                )
            );

            $programme200 = array(
                '200' => array(
                    'name' => array(
                        'deutsch' => 'deutscher Name 200',
                        'englisch' => 'englischer Name 200'
                    ),
                    'beschreibung' => array(
                        'deutsch' => 'Beschreibung deutsch 200',
                        'englisch' => 'Beschreibung englich 200'
                    )
                )
            );

            $this->notNoSql->put('bla.12345.programme.100', $programme100);
            $this->notNoSql->put('bla.12345.programme.200', $programme200);

            $test = $this->notNoSql->get('bla.12345.programme.100');

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