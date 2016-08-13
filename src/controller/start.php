<?php
/**
 * Created by PhpStorm.
 * User: Stephan.Krauss
 * Date: 21.04.2016
 * Time: 16:40
 */

namespace controller;

/**
 * darstellen der leeren Seite des Template
 *
 * @author Stephan.Krauss
 * @date 23.06.2015
 * @package Controller
 */

class start extends main
{
    /**
     * Laden des Parent Template und Subtemplate des Baustein
     */
    public function index()
    {
        try{
            $output = array(
                'bausteine' => 'start'
            );

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
}