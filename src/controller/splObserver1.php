<?php

namespace controller;

use tools\frinkError;

/**
 * Test des Observer Pattern mit der SPL von PHP.
 * + klassische Schreibweise
 * + Verwendung von Traits
 * + SplSubject interface
 * + SplObserver
 *
 * @author Stephan Krauß
 * @copyright Stephan Krauss
 * @lisence Stephan Krauß
 * @date 17.06.2016
 * @package controller
 */
class splObserver1 extends main
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
            }
        ];

        parent::__construct($controllerName, $actionName);

        parent::pimple($models);
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

    public function subjectObserver()
    {
        try {

            // Observer
            $modelObserver1 = new \models\modelObserver1($this->pimple);
            $modelObserver1['wert1'] = 'observer1';
            $modelObserver1['wert2'] = 'observer1';

            $modelObserver2 = new \models\modelObserver2($this->pimple);
            $modelObserver2['wert1'] = 'observer2';
            $modelObserver2['wert2'] = 'observer2';

            // Subject
            $modelSubject = new \models\modelSubject($this->pimple);
            $modelSubject['wert1'] = 'subject';
            $modelSubject['wert2'] = 'subject';

            // Observer hinzufügen
            $modelSubject->attach($modelObserver1);
            $modelSubject->attach($modelObserver2);

            // Test von Pimple mit zentraler Übergabe des DIC
            $pimple = $this->pimple;
            $myCalc = $pimple['basis'];

            $modelSubject->notify();

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

    /**
     * Test von Pimple
     *
     * + zentrale Nutzung von Pimple in __construct()
     * + Übergabe von DIC an alle Modelle
     *
     * @throws \Exception
     * @throws frinkError
     */
    public function dic()
    {
        try {
            // Test von Pimple mit zentraler Übergabe des DIC
            $pimple = $this->pimple;
            $modelBasis = $pimple['basis'];


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