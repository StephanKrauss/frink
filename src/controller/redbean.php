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

/**
 * darstellen der leeren Seite des Template
 *
 * + abschalten Kontrolle Foreign Key in MySQL: 'SET FOREIGN_KEY_CHECKS = 1;'
 *
 * @author Stephan.Krauss
 * @date 23.05.2016
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
    public function post()
    {
        try{
            $redbean = $this->redbean->getRedBean();

            $tabelleKunden = $redbean->dispense('kunden');
            $tabelleKunden->name = 'Mustermann';
            $tabelleKunden->vorname = 'Max';

            $tabelleMails = $redbean->dispense('mails');
            $tabelleMails->mail = 'info@blub.de';
            $tabelleKunden->ownMails[] = $tabelleMails;

            $tabelleMailsSecond = $redbean->dispense('mails');
            $tabelleMailsSecond->mail = 'info@blub.de';
            $tabelleKunden->ownMails[] = $tabelleMailsSecond;

            $id = $redbean->store($tabelleKunden);

            echo 'ID: '.$id;
            
            $this->template();
        }
        catch(\Exception $e){
            throw $e;
        }
    }

    public function get()
    {
        try{
            $where = array(
                'id' => 2
            );

            $redbean = $this->redbean->getRedBean();

            $max = $redbean->load('kunden', 1);

            echo 'Name: '.$max->name;

            $this->template();
        }
        catch (\Exception $e){
            throw $e;
        }

    }

    /**
     * löschen eines Datensatzes
     * 
     * @throws \Exception
     */
    public function delete()
    {
        try{
            // Zugangsdaten
            $datenbankZugangswerte = \Flight::get('datenbankZugangswerte');

            // Redbean Setup
            R::setup("mysql:host=".$datenbankZugangswerte['hostname'].";dbname=".$datenbankZugangswerte['database'], $datenbankZugangswerte['username'], $datenbankZugangswerte['password']);

            $tabelleKunden = R::load('kunden', 1);
            R::trash($tabelleKunden);

            $this->template();
        }
        catch (\Exception $e){
            throw $e;
        }

    }

    /**
     * finden eines Datensatzes
     * 
     * @throws \Exception
     */
    public function find()
    {
        try{
            // Zugangsdaten
            $datenbankZugangswerte = \Flight::get('datenbankZugangswerte');

            // Redbean Setup
            R::setup("mysql:host=".$datenbankZugangswerte['hostname'].";dbname=".$datenbankZugangswerte['database'], $datenbankZugangswerte['username'], $datenbankZugangswerte['password']);

            $tabelleKunden = R::load('kunden', 1);
            R::trash($tabelleKunden);

            $this->template();
        }
        catch (\Exception $e){
            throw $e;
        }

    }
}