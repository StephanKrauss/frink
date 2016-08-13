<?php

namespace controller;

use \tools as tools;

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
        $test = 123;

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
     * Auswertung 'phpinfo();'
     */
    public function info()
    {
        try{
            phpinfo();

            exit();
        }
        catch(\Exception $e){
            throw $e;
        }
    }

    /**
     * Laden des Parent Template und Subtemplate des Baustein.
     * Funktionsmodell NoSql Datenbank
     */
    public function testNoSql()
    {
        try{
            $testParams = $this->params;

            // Test NotNoSql
            $programme100 = array(
                '100' => array(
                    'name' => array(
                        'deutsch' => 'deutscher Name 100',
                        'englisch' => 'englischer Name 100'
                    ),
                    'beschreibung' => array(
                        'deutsch' => 'Beschreibung deutsch 100',
                        'englisch' => 'Beschreibung englich 100'
                    )
                )
            );

            $programme200 = array(
                '200' => array(
                    'name' => array(
                        'deutsch' => 'deutscher Name 200',
                        'englisch' => 'englischer Name 200'
                    ),
                    'beschreibung' => array(
                        'deutsch' => 'Beschreibung deutsch 200',
                        'englisch' => 'Beschreibung englich 200'
                    )
                )
            );

            $programme300 = array(
                '300' => array(
                    'name' => array(
                        'deutsch' => 'deutscher Name 300',
                        'englisch' => 'englischer Name 300'
                    ),
                    'beschreibung' => array(
                        'deutsch' => 'Beschreibung deutsch 300',
                        'englisch' => 'Beschreibung englich 300'
                    )
                )
            );

            $this->notNoSql->put('notnosql.12345.programme.100', $programme100);
            $this->notNoSql->put('notnosql.12345.programme.200', $programme200);
            $this->notNoSql->put('notnosql.12345.programme.300', $programme300);

            $testNotNoSql = $this->notNoSql->get('notnosql.12345.programme.100');

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
     * Laden des Parent Template und Subtemplate des Baustein.
     * Funktionsmodell MySQL / Sparrow Datenbank
     */
    public function testMySQL()
    {
        try{
            $testParams = $this->params;

            $insert = array(
                'wert' => 'aaa'
            );

            $query = $this->sparrow->from('sparrow')->insert($insert)->sql();
            $this->sparrow->execute();

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
     * Laden des Parent Template und Subtemplate des Baustein.
     * Funktionsmodell MySQL / Sparrow Datenbank
     */
    public function testRedis()
    {
        try{
            $testParams = $this->params;

            $this->predis->set('zahl2',2);

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

    public function testError()
    {
        try{
            $testParams = $this->params;

            throw new tools\frinkError('Fehlerbeschreibung', 3);
        }
        catch(\Exception $e){
            throw $e;
        }
    }
}