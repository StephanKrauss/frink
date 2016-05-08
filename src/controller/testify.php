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
     * Laden des Parent Template und Subtemplate des Baustein
     */
    protected function index()
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
            
            $this->index();
        }
        catch(\Exception $e){
            throw $e;
        }
    }

    public function post()
    {
        try{
            // Verarbeitung

            $this->index();
        }
        catch(\Exception $e){
            throw $e;
        }
    }

    public function put()
    {
        try{
            // Verarbeitung

            $this->index();
        }
        catch(\Exception $e){
            throw $e;
        }
    }

    public function delete()
    {
        try{
            // Verarbeitung

            $this->index();
        }
        catch(\Exception $e){
            throw $e;
        }
    }
    
}