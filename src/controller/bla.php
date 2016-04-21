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

class bla extends main
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

            $test = 123;
            // $template = $this->twig->loadTemplate($this->templateName);
            // echo $template->render($output);
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
                'bausteine' => 'start'
            );

            $test = 123;
            // $template = $this->twig->loadTemplate($this->templateName);
            // echo $template->render($output);
        }
        catch(\Exception $e){
            throw $e;
        }
    }
}