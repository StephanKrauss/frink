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
            $insert = ['name' => 'zzz', 'zahl' => 2, 'author_id' => 2];

            /** @var $spot \Spot\Locator */
            $spot = \Flight::get('spot');
            $mapperTest = $spot->mapper('tables\test');
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

            $mapperTest = $spot->mapper('tables\test');
            $result = $mapperTest->all()->active()->toArray();

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
     * Generiert aus einer Entity / Tabelle die Tabelle in der MySQL
     *
     * @throws \Exception
     * @throws frinkError
     */
    public function tabelle()
    {
        try{
            /** @var $spot \Spot\Locator */
            $spot = \Flight::get('spot');

            $spot->mapper('tables\posts')->migrate();

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
     * Verwendung von vordefinierten Abfragen
     * 
     * + komplexe Abfragen
     * + Teilabfragen / Scope
     *
     * @throws \Exception
     * @throws frinkError
     */
    public function komplex()
    {
        try{
            /** @var $spot \Spot\Locator */
            $spot = \Flight::get('spot');

            $mapperTest = $spot->mapper('tables\test');

            // Verwendung einer komplexen Frage
            $result = $mapperTest->erste(3)->toArray();

            // Verwendung des Scope
            $result = $mapperTest->all()->zweite()->toArray();

            // Verwendung von 'get'
            $result = $mapperTest->get(3)->toArray();

            // Verwendung von 'where'
            // $query = $mapperTest->all()->where(['id >=' => 3])->toSql();
            $result = $mapperTest->all()->where(['id >=' => 3])->toArray();

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

    public function komplex1()
    {
        try{
            /** @var $spot \Spot\Locator */
            $spot = \Flight::get('spot');

            $mapperTest = $spot->mapper('tables\test');
            // $result = $mapperTest->all()->where(['id' => 3])->toArray();

            // gibt Mapper zurück
            // $mapperProfile = $mapperTest->getMapper('tables\profile');

            // gibt Name der Entity zurück
            // $entityName = $mapperTest->entity();

            // Get query class name to use
            // $queryClassName = $mapperTest->queryClass();

            // Get collection class name to use
            // $collectionClassName = $mapperTest->collectionClass();


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
     * Abbilden der Beziehungen zwischen den Tabellen. Die Beziehung wird in der Entity definiert.
     *
     * @throws \Exception
     * @throws frinkError
     */
    public function relations()
    {
        try{
            /** @var $spot \Spot\Locator */
            $spot = \Flight::get('spot');

            $mapperUsers = $spot->mapper('tables\users');

            $result = $mapperUsers->all()->with('profile')->toArray();

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