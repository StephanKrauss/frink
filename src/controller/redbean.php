<?php
/**
* Test des ORM Redbean
*
* @package Controller 
* @date 18.05.2016
* @author Stephan Krauß
*/

namespace controller;
use models\model;
use models\myCalc;
use \RedBeanPHP\R as R;

/**
 * darstellen der leeren Seite des Template
 *
 * @author Stephan.Krauss
 * @date 23.06.2015
 * @package Controller
 */

class redbean extends main
{
    /**
     *
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

    /**
     * Test von Redbean
     *
     * @throws \Exception
     */
    public function get()
    {
        try{
            // Zugangsdaten
            $datenbankZugangswerte = \Flight::get('datenbankZugangswerte');

            // Redbean Setup
            R::setup("mysql:host=".$datenbankZugangswerte['hostname'].";dbname=".$datenbankZugangswerte['database'], $datenbankZugangswerte['username'], $datenbankZugangswerte['password']);
            
            $this->template();
        }
        catch(\Exception $e){
            throw $e;
        }
    }
}