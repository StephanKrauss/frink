<?php
/**
* Test DIC pimple
*
* @author Stephan Krauß , 21.34.2016
* @copyright Stephan Krauss
*
* @subpackage controller
*/

namespace controller;

use \tools as tools;
use \models\model;
use \models\myCalc;

/**
* Test DIC Pimple
*
* + Zusatzbeschreibung 1
* + Zusatzbeschreibung 2
* + Zusatzbeschreibung 3
*
* @author Stephan Krauß
* @date 15.05.2016
* @copyright Stephan Krauss
*
* @package controller
*/
class pimple extends main
{
    /**
     *
     */
    public function __construct($controllerName, $actionName)
    {
        parent::__construct($controllerName, $actionName);

        $models = array(
            'model' => function() {
                return new model($this->params);
            },
            'myCalc' => function(){
                return new myCalc(10);
            }
        );

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

    /**
     * Anzeigen des Template
     *
     * @throws \Exception
     */
    public function read()
    {
        try{
            $this->template();

        }
        catch(\Exception $e){
            throw $e;
        }
    }
}