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

            $outputTemplate = array(
                'masterTemplate' => 'main.html',
                'templateSuperuser' => 'bla_superuser.html'
            );

            \Flight::view()->display($this->templateName, $outputTemplate);
        }
        catch(\Exception $e){
            throw $e;
        }
    }

    public function get()
    {
        try{

            //Array with configs pathes
//            $configFiles = array(
//                realpath("../app/config/config.ini"),
//                realpath("../app/config/config2.ini")
//            );
//
//            $iniParser = new \models\iniparser();
//            $config = $iniParser->parse($configFiles);

            $config = \Flight::get('config');

            $this->template();
        }
        catch(\Exception $e)
        {
            throw $e;
        }
    }
    
}