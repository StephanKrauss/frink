<?php

namespace controller;

use tools\frinkError;

/**
 * Test der Erzeugungs von Struktur Pattern unter Nutzung des DI Container Pimple
 *
 * + Decoration Pattern
 *
 * @author Stephan Krauß
 * @copyright Stephan Krauss
 * @lisence Stephan Krauß
 * @date 26.06.2016
 * @package controller
 */
class structuralPattern extends main
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
    public function decorationPattern()
    {
        try {




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