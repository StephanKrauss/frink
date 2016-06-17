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

class classExtends extends main
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
     * anzeigen des Template
     *
     * @throws \Exception
     * @throws frinkError
     */
    public function get()
    {
        try{
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
     * Test des dynamischen erweitern einer Klasse
     *
     * @throws \Exception
     * @throws frinkError
     */
    public function extendsClass()
    {
        try{
            $modelBasis = new \models\basis();

            $modelExtends = new \models\extendsBasis();
            
            $modelExtends
                ->setBasisClass($modelBasis)
                ->setWert1(111)
                ->setWert2('abc');

            $wert1 = $modelExtends->getWert1();
            $wert2 = $modelExtends->getWert2();

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