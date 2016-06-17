<?php

namespace controller;

use tools\frinkError;

/**
* Test des Observer Pattern mit der SPL von PHP
*
* + SplSubject interface
* + SplObserver
*
* @author Stephan Krauß
* @copyright Stephan Krauss
* @lisence Stephan Krauß
* @date 17.06.2016
*
* @package controller
*/

class splObserver extends main
{
    /**
     * erweitern Pimple um spezielle Model und Tools
     */
    public function __construct($controllerName, $actionName)
    {
        // Vorbereitung des Pimple Container
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

    public function subjectObject()
    {
        try{
            // Test - Objekte erstellen
            $modelBasis = clone new \models\ModelData($this->pimple);
            $modelBasis->offsetSet('wert1', 'Wert1');

            $modelBasis1 = clone new \models\ModelData($this->pimple);
            $modelBasis1->offsetSet('wert2', 'Wert2');

            $modelBasis2 = clone new \models\ModelData($this->pimple);
            $modelBasis2->offsetSet('wert3', 'Wert3');

            $modelBasis3 = clone new \models\ModelData($this->pimple);
            $modelBasis3->offsetSet('wert4', 'Wert4');

            // erstellen der Observer
            $modelObserver1 = new \models\extendsSplObserver();
            $modelObserver1->setBasisClass($modelBasis1);

            $modelObserver2 = new \models\extendsSplObserver();
            $modelObserver2->setBasisClass($modelBasis2);

            $modelObserver3 = new \models\extendsSplObserver();
            $modelObserver3->setBasisClass($modelBasis3);

            // erstellen des Subject
            /** @var $modelSubject \models\extendsSplSubject */
            $modelSubject = new \models\extendsSplSubject();

            // Übergabe des Subjekt und der Observer
            $modelSubject
                ->setBasisClass($modelBasis)
                ->attach($modelObserver1)
                ->attach($modelObserver2)
                ->attach($modelObserver3);

            // Veränderung der Daten des Subjekt
            $modelSubject->offsetSet('wert1', 123);
            $modelSubject->offsetSet('wert2', 'abc');

            // Methoden des Subjekt aufrufen
            
            // Methode 'notify' im Subject aufrufen und die Observer informieren
            $modelSubject->notify();

            // Übergabe an die View
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
}