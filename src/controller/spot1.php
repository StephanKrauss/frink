<?php

namespace controller;

use tools\frinkError;

/**
* Verknüpfung des Daten Mapper mit dem OR-Mapper
*
* @author Stephan Krauß
* @copyright Stephan Krauss
* @lisence Stephan Krauß
* @date 15.06.2016
*
* @package controller
*/

class spot1 extends main
{
    /**
     * erweitern Pimple um spezielle Model und Tools
     */
    public function __construct($controllerName, $actionName)
    {
        $models = array(
            'model' => function() {
                return new model($this->params);
            },
            'myCalc' => function(){
                return new myCalc(10);
            }
        );

        parent::__construct($controllerName, $actionName);

        parent::pimple($models);
    }

    /**
     * Laden des Parent Template und Subtemplate des Baustein
     */
    protected function template()
    {
        try{
            /** @var $session \models\session */
            $modelSession = \Flight::get('session');

            $outputTemplate = array(
                'masterTemplate' => 'main.html',
                'templateSuperuser' => 'bla_superuser.html'
            );
            
            $config = \Flight::get('config');
            
            if($config['debugBlock']['debug'])
                $outputTemplate['debugBlock'] = $this->setDebug($modelSession);

            \Flight::view()->display($this->templateName, $outputTemplate);
        }
        catch(\Exception $e){
            throw $e;
        }
    }

    /**
     * anzeigen aller Daten aus der Tabelle 'test'
     *
     * @throws \Exception
     * @throws frinkError
     */
    public function get()
    {
        try{
            /** @var $spot \Spot\Locator */
            // $spot = \Flight::get('spot');
            // $mapperTest = $spot->mapper('tables\test');

            $this->template();
        }
            // eigene Exception
        catch(\tools\frinkError $e)
        {
            throw $e;
        }
            // Exception anderer Klassen
        catch(\Exception $e){
            throw $e;
        }
    }

    /**
     * testen des Mapper für den Import / Export in / aus einem Model
     *
     * @throws \Exception
     */
    public function mapper()
    {
//        date_default_timezone_set('Europe/Berlin');
//
//        $test = date('Y-m-d H:i:s', time());

        // $test = \Doctrine\DBAL\Types\Type::getTypesMap();

        /** @var $spot \Spot\Locator */
        $spot = \Flight::get('spot');

        /** @var $mapperTest \mapper\users */
        $mapperUsers = $spot->mapper('tables\users');

        /** @var $modelBenutzerDaten \models\BenutzerDaten */
        $modelBenutzerDaten = new \models\BenutzerDaten();

        $modelBenutzerDaten = $mapperUsers->findData(9, $modelBenutzerDaten);

        if($modelBenutzerDaten){
            $modelBenutzerDaten->offsetSet('status', 6);
            $modelBenutzerDaten->offsetSet('id', 11);
            $modelBenutzerDaten->offsetSet('date_created', new \DateTime());

            /** @var $mapperTest \mapper\users */
            $modelBenutzerDaten = $mapperUsers->setData($modelBenutzerDaten);
        }

        $this->template();
    }
}