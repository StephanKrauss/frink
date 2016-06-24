<?php

namespace controller;

/**
 * darstellen der leeren Seite des Template
 *
 * @author Stephan.Krauss
 * @date 23.06.2015
 * @package Controller
 */

class basics extends main
{
    /**
     * Laden des Parent Template und Subtemplate des Baustein
     */
    public function testNamespace()
    {
        try{
            /** @var $testMath \models\myCalc */
            $testMath = new \models\myCalc(10);
            $testMath->add(5);

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
     * Test der Closure in Php
     *
     * @throws \Exception
     */
    public function testClosure()
    {
        try{
            function createClosure($type){
                return function($message) use($type){
                    return "{$message} : [{$type}] ";
                };
            }

            $type = 'Info';
            $infoDebugger = createClosure($type);

            unset($type);

            // $infoDebugger('Information');


            $outputTemplate = array(
                'masterTemplate' => 'main.html',
                'templateSuperuser' => 'bla_superuser.html',
                'testClosure' => $infoDebugger('Information')
            );

            \Flight::view()->display($this->templateName, $outputTemplate);
        }
        catch(\Exception $e){
            throw $e;
        }
    }

    /**
     * Test der anonymen Functionen in Php
     *
     * @throws \Exception
     */
    public function testAnonyme()
    {
        try{
            $anonyme = function($wert1, $wert2){
                return $wert1 + $wert2;
            };


            $outputTemplate = array(
                'masterTemplate' => 'main.html',
                'templateSuperuser' => 'bla_superuser.html',
                'testClosure' => $anonyme(5, 10)
            );

            \Flight::view()->display($this->templateName, $outputTemplate);
        }
        catch(\Exception $e){
            throw $e;
        }
    }

    /**
     * setzen von Parametern
     *
     * @throws \Exception
     */
    public function testGetSet()
    {
        try{
            /** @var $calc \models\myCalc */
            $calc = new \models\myCalc(10);
            $calc->bla = 'blub';


            $outputTemplate = array(
                'masterTemplate' => 'main.html',
                'templateSuperuser' => 'bla_superuser.html',
                // 'testClosure' => $calc->bla,
                'wert2' => $calc->blub(),
                'wert3' => $calc::hallo('abcde')
            );

            \Flight::view()->display($this->templateName, $outputTemplate);
        }
        catch(\Exception $e){
            throw $e;
        }
    }

    /**
     * Übergabe eines Array an Twig
     *
     * @throws \Exception
     */
    public function testArray()
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