<?php

namespace controller;

use tools\frinkError;

/**
 * Test der Creational / Erzeugungs Pattern mit Traits
 *
 * + Singleton Trait
 * + Multiton Trait
 * + Factory Trait
 * + Prototype Trait
 *
 * @author Stephan Krauß
 * @copyright Stephan Krauss
 * @lisence Stephan Krauß
 * @date 17.06.2016
 * @package controller
 */
class splObjectStorage extends main
{
    /**
     * erweitern Pimple um spezielle Model und Tools
     */
    public function __construct($controllerName, $actionName)
    {
        // Vorbereitung des Pimple Container
        $models = [
            'basis' => function ($pimple) {
                return new \models\modelBasis($pimple);
            },
            'bla' => function ($pimple) {
                return new \models\modelBla($pimple);
            },
            'blub' => function ($pimple) {
                return new \models\modelBlub($pimple);
            },
            'modelFactory' => function($pimple)
            {
                return new \models\modelBasis($pimple);
            }
        ];

        parent::pimple($models);

        parent::__construct($controllerName, $actionName);
    }

    /**
     * Laden des Parent Template und Subtemplate des Baustein
     */
    protected function template()
    {
        try {
            /** @var $session \models\session */
            $modelSession = \Flight::get('session');

            $outputTemplate = [
                'masterTemplate' => 'main.html',
                'templateSuperuser' => 'bla_superuser.html'
            ];

            $config = \Flight::get('config');

            if ($config['debugBlock']['debug']) {
                $outputTemplate['debugBlock'] = $this->setDebug($modelSession);
            }

            \Flight::view()->display($this->templateName, $outputTemplate);
        } catch (\Exception $e) {
            throw $e;
        }
    }

    /**
     * Test des SPL Object Storage
     *
     * + Pimple verwendet jedes Objekt als Singleton
     *
     * @throws \Exception
     * @throws frinkError
     */
    public function objectStorage()
    {
        try {
            $objStorage = new \SplObjectStorage();

            /** @var $obj1 \models\modelBasis */
            $obj1 = clone $this->pimple['modelFactory'];
            $obj1['wert1'] = '1-111';
            $obj1['wert2'] = '1-222';
            $obj1['wert3'] = '1-333';
            $test = $obj1->foo();

            $objStorage->attach($obj1);

            $obj2 = clone $this->pimple['modelFactory'];
            $obj2['wert1'] = '2-111';
            $obj2['wert2'] = '2-222';
            $obj2['wert3'] = '2-333';

            $objStorage->attach($obj2);

            $obj3 = clone $this->pimple['modelFactory'];
            $obj3['wert1'] = '3-111';
            $obj3['wert2'] = '3-222';
            $obj3['wert3'] = '3-333';

            $objStorage->attach($obj3);

            $objStorage->detach($obj2);

            var_dump($objStorage->contains($obj1));
            var_dump($objStorage->contains($obj2));
            var_dump($objStorage->contains($obj3));

            var_dump($objStorage);

            // Übergabe an die View
            $this->template();
        } // eigene Exception
        catch (\tools\frinkError $e) {
            throw $e;
        } // Exception anderer Klassen
        catch (\Exception $e) {
            throw $e;
        }
    }
}