<?php

namespace controller;

use tools\frinkError;

/**
 * Test der Erzeugung des Verhaltens / Behavorial Pattern Strategy
 *
 * + Decoration Pattern
 *
 * @author Stephan Krauß
 * @copyright Stephan Krauss
 * @lisence Stephan Krauß
 * @date 28.06.2016
 * @package controller
 */
class behavorialPattern extends main
{
    /**
     * erweitern Pimple um spezielle Model und Params
     */
    public function __construct($controllerName, $actionName)
    {
        // Vorbereitung des Pimple Container, Singleton Pattern !
        $models = [
            'hund' => function ($pimple) {
                return new \models\hund($pimple);
            },
            'knurrenderHund' => function ($pimple){
                return new \models\knurrenderHund();
            },
            'bellenderHund' => function ($pimple){
                return new \models\bellenderHund();
            },
            'randalierenderHund' => function ($pimple){
                return new \models\randalierenderHund();
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
     * Vorbereitung eines Strategie Pattern mit dem Beispiel eines Hundes im Gartengrundstück
     *
     * + Pimple verwendet jedes Objekt als Singleton
     *
     * @throws \Exception
     * @throws frinkError
     */
    public function strategyPattern()
    {
        try {
            
            /** @var $modelHund \models\hund */
            $modelHund = $this->pimple['hund'];

            // Katze ist am Gartenzaun
            $modelHund['abstandZumGartenzaun'] = 0;
            $modelHund->reaktion();
            $reaktion = $modelHund['reaktionHund'];

            // Katze ist im Garten
            $modelHund['abstandZumGartenzaun'] = 5;
            $modelHund->reaktion();
            $reaktion = $modelHund['reaktionHund'];

            // Katze ist am Gartenhaus
            $modelHund['abstandZumGartenzaun'] = 11;
            $modelHund->reaktion();
            $reaktion = $modelHund['reaktionHund'];

            $this->template();
        }
            // eigene Exception
        catch (\tools\frinkError $e) {
            throw $e;
        } // Exception anderer Klassen
        catch (\Exception $e) {
            throw $e;
        }
    }
}