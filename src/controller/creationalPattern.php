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
class creationalPattern extends main
{
    /**
     * erweitern Pimple um spezielle Model und Tools
     */
    public function __construct($controllerName, $actionName)
    {
        // Vorbereitung des Pimple Container
        $models = [
            'basis' => function ($pimple) {
                unset($pimple['basis']);
                return new \models\modelBasis($pimple);
            },
            'bla' => function ($pimple) {
                unset($pimple['bla']);
                return new \models\modelBla($pimple);
            },
            'blub' => function ($pimple) {
                unset($pimple['blub']);
                return new \models\modelBlub($pimple);
            },
            'basisSingleton' => function($pimple){
                unset($pimple['basisSingleton']);
                return \models\modelBasisSingleton::getInstance($pimple);
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
     * Verwenden eines Standard Model als Singleton
     *
     * @throws \Exception
     * @throws frinkError
     */
    public function singletonPattern()
    {
        try {
            $modelBasisSingleton = $this->pimple['basisSingleton'];

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