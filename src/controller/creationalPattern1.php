<?php

namespace controller;

use tools\frinkError;

/**
 * Test der Erzeugungs Pattern unter Nutzung des DI Container Pimple
 *
 * + Prototype
 *
 * @author Stephan Krauß
 * @copyright Stephan Krauss
 * @lisence Stephan Krauß
 * @date 26.06.2016
 * @package controller
 */
class creationalPattern1 extends main
{
    /**
     * erweitern Pimple um spezielle Model und Params
     */
    public function __construct($controllerName, $actionName)
    {
        // Vorbereitung des Pimple Container, Singleton Pattern
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
            'modelSingletonBasis' => function ($pimple) {
                return new \models\modelBasis($pimple);
            },
            'param1' => 'param1',
            'param2' => 'param2'
        ];

        parent::pimple($models);

        // Factory Pattern
        $this->pimple['modelFactoryBasis'] = $this->pimple->factory(function ($pimple) {
            return new \models\modelBasis($pimple);
        });

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
     * Verwenden eines Standard Model aus dem DIC als Singleton.
     *
     * + Pimple verwendet jedes Objekt als Singleton
     *
     * @throws \Exception
     * @throws frinkError
     */
    public function prototypePattern()
    {
        try {


            // anlegen des Model Car als Factory Pattern, kann im __construct() erfolgen
            $pimple = new \Pimple\Container();
            $pimple['car'] = $this->pimple->factory(function ($pimple) {
                return new \models\Car($pimple);
            });

            // abrufen des Model aus dem DI Container Pimple und PhpStorm das Model mitteilen

            /** @var $modelCar \models\Car */
            $modelCar = $pimple['car'];

            // befüllen des Model mit den Eigenschaften des Prototypes
            $modelCar['engine'] = 'VW Diesel 2.0';
            $modelCar['gas'] = 'diesel';
            $modelCar['color'] = 'blau';
            $modelCar['logo'] = 'Fußball-EM 2016';

            // überprüfen des Prototype
            // var_dump($modelCar->getAllData());

            // ergibt folgendes Ergebnis
            // array (size=4)
              // 'engine' => string 'VW Diesel 2.0' (length=13)
              // 'gas' => string 'diesel' (length=6)
              // 'color' => string 'blau' (length=4)
              // 'logo' => string 'Fussball 2016' (length=13)

            // erstellen einer Kleinserie aus dem Prototype und abstellen der produzierten Fahrzeuge
            $parkplatz = [];

            for($i=1; $i < 10; $i++) {
                $parkplatz[$i] = clone $modelCar;
            }

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