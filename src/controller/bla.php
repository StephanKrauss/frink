<?php
/**
* Bal Blub
*
* @author Stephan Krauß , 21.34.2016
* @copyright Stephan Krauss
*
* @subpackage controller | model | tool | trait
*/

namespace controller;

/**
 * darstellen der leeren Seite des Template
 *
 * @author Stephan.Krauss
 * @date 23.06.2015
 * @package Controller
 */

class bla extends main
{
    /**
     * Laden des Parent Template und Subtemplate des Baustein
     */
    public function index()
    {
        try{
            $output = array(
                'bausteine' => 'bla / index'
            );

            \Flight::view()->display($this->templateName, $output);
        }
        catch(\Exception $e){
            throw $e;
        }
    }

    /**
     * Laden des Parent Template und Subtemplate des Baustein
     */
    public function blub()
    {
        try{
            $output = array(
                'masterTemplate' => 'main.html',
                'templateSuperuser' => 'bla_superuser.html'
            );

            \Flight::view()->display($this->templateName, $output);
        }
        catch(\Exception $e){
            throw $e;
        }
    }
}