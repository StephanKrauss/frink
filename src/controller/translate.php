<?php

namespace controller;

/**
 * darstellen der leeren Seite des Template
 *
 * @author Stephan.Krauss
 * @date 23.06.2015
 * @package Controller
 */

class translate extends main
{
    /**
     * Übergabe eines Array an Twig
     *
     * @throws \Exception
     */
    public function start()
    {
        try{
            $test = array(
                'bla' => array(
                    'wert1' => 'aaa',
                    'wert2' => 111,
                    3 => 'wert 333'
                )
            );

            $outputTemplate = array(
                'masterTemplate' => 'main.html',
                'templateSuperuser' => 'bla_superuser.html',
                'test' => $test
            );

            \Flight::view()->display($this->templateName, $outputTemplate);
        }
        catch(\Exception $e){
            throw $e;
        }
    }
}