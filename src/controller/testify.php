<?php
/**
* Test der Unit Test Klasse 'testify'
*
* @author Stephan Krauß , 04.05.2016
* @copyright Stephan Krauss
*
* @subpackage controller
*/

namespace controller;

use models\model;
use models\myCalc;

/**
 * darstellen der leeren Seite des Template
 *
 * @author Stephan.Krauss
 * @date 23.06.2015
 * @package Controller
 */

class testify extends main
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

    public function get()
    {
        try{
            // Verarbeitung
            
            $this->template();
        }
        catch(\Exception $e){
            throw $e;
        }
    }

    public function post()
    {
        try{
            // Verarbeitung

            $this->template();
        }
        catch(\Exception $e){
            throw $e;
        }
    }

    public function put()
    {
        try{
            // Verarbeitung

            $this->template();
        }
        catch(\Exception $e){
            throw $e;
        }
    }

    public function delete()
    {
        try{
            // Verarbeitung

            $this->template();
        }
        catch(\Exception $e){
            throw $e;
        }
    }

    private function myPrivate()
    {
        return 'abc';
    }
    
}