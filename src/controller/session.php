<?php

namespace controller;

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
            $session = \Flight::get('session');

            $outputTemplate = array(
                'masterTemplate' => 'main.html',
                'templateSuperuser' => 'bla_superuser.html'
            );
            
            $config = \Flight::get('config');
            
            if($config['debugBlock']['debug'])
                $outputTemplate['debugBlock'] = $this->setDebug($session);

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
            $config = \Flight::get('config');

            /** @var $session \models\session */
            $session = \Flight::get('session');

            $session->write('test','test');

            $session->write('test1','test1');

            $this->get();
        }
        catch(\Exception $e)
        {
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
            $session = \Flight::get('session');

            $test = $session->read("test");

            $test1 = $session->read('test1');

            $this->template();
        }
        catch(\Exception $e)
        {
            throw $e;
        }
    }
    
}