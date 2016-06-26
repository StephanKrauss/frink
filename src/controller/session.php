<?php

namespace controller;

use tools\frinkError;

/**
* Test  der Session Klasse
* 
* @author Stephan Krauss
* @copyright Stephan Krauss
* @lisence MIT
* @package Controller
* @date 27.05.2016
*/

class session extends main
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
     * Setzt die Variablen in der Session
     *
     * @throws \Exception
     */
    public function post()
    {
        try{
            try{
                throw new frinkError('Fehler Typ 2', 2);
            }
            catch(\Exception $e){
                // Error Typ 2
                $error = \tools\errorAuswertung::readException($e);
                \tools\errorAuswertung::writeException($error);
            }

            throw new frinkError('Fehler Typ 3', 3);

            /** @var $session \models\session */
            $modelSession = \Flight::get('session');

            $modelSession->write('test','test');

            $modelSession->write('test1','test1');

            $this->get();
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
     * holt die Session Variablen
     *
     * @throws \Exception
     */
    public function get()
    {
        try{
            /** @var $session \models\session */
            $modelSession = \Flight::get('session');

            $test = $modelSession->read("test");

            $test1 = $modelSession->read('test1');

            $this->template();
        }
        catch(\Exception $e)
        {
            throw $e;
        }
    }
    
}