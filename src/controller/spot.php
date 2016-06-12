<?php

namespace controller;

use tools\frinkError;

/**
* Test des Swiftmailer
* 
* @author Stephan Krauss
* @copyright Stephan Krauss
* @lisence MIT
* @package Controller
* @date 31.05.2016
*/

class spot extends main
{
    /**
     * erweitern Pimple um spezielle Model und Tools
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
            /** @var $session \models\session */
            $modelSession = \Flight::get('session');

            $outputTemplate = array(
                'masterTemplate' => 'main.html',
                'templateSuperuser' => 'bla_superuser.html'
            );
            
            $config = \Flight::get('config');
            
            if($config['debugBlock']['debug'])
                $outputTemplate['debugBlock'] = $this->setDebug($modelSession);

            \Flight::view()->display($this->templateName, $outputTemplate);
        }
        catch(\Exception $e){
            throw $e;
        }
    }

    /**
     * Insert von Daten mit Spot in Tabelle 'test'
     *
     * @throws \Exception
     */
    public function post()
    {
        try{
            // insert
            $insert = ['name' => 'Matthias'];

            /** @var $spot \Spot\Locator */
            $spot = \Flight::get('spot');
            $mapperTest = $spot->mapper('mapper\test');
            $mapperTest->create($insert);


            $this->template();
        }
        // eigene Exception
        catch(\tools\frinkError $e)
        {
            throw $e;
        }
        // Exception anderer Klassen
        catch(\Exception $e){
            throw $e;
        }
    }

    /**
     * anzeigen aller Daten aus der Tabelle 'test'
     *
     * @throws \Exception
     * @throws frinkError
     */
    public function get()
    {
        try{
            /** @var $spot \Spot\Locator */
            $spot = \Flight::get('spot');

            /** @var $mapperTest \mapper\test */
            $mapperTest = $spot->mapper('mapper\test');
            // $result = $mapperTest->all()->active()->toArray();
            $result = $mapperTest->get(2)->toArray();

            $this->template();
        }
            // eigene Exception
        catch(\tools\frinkError $e)
        {
            throw $e;
        }
            // Exception anderer Klassen
        catch(\Exception $e){
            throw $e;
        }
    }

    /**
     * bauen einer Entity ???
     *
     * @throws \Exception
     * @throws \tools\frinkError
     */
    public function build()
    {
        try{
            /** @var $spot \Spot\Locator */
            $spot = \Flight::get('spot');

            $entity = $spot->build([
                'name' => 'Chester Tester',
                'email' => 'chester@example.com'
            ]);

            $this->template();
        }
            // eigene Exception
        catch(\tools\frinkError $e)
        {
            throw $e;
        }
            // Exception anderer Klassen
        catch(\Exception $e){
            throw $e;
        }
    }

    public function trans()
    {
        try{
            /** @var $spot \Spot\Locator */
            $spot = \Flight::get('spot');
            $mapperTest = $spot->mapper('mapper\test');
            
            


            $this->template();
        }
            // eigene Exception
        catch(\tools\frinkError $e)
        {
            throw $e;
        }
            // Exception anderer Klassen
        catch(\Exception $e){
            throw $e;
        }
    }
}