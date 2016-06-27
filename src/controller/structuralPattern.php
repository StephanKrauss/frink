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
        // Vorbereitung des Pimple Container, Singleton Pattern !
        $models = [
            'torteMitDekoration' => function ($pimple) {
                return new \models\TorteMitDekoration($pimple);
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
     * Vorbereitung eines Dekoration Pattern mit dem Beispiel einer Torte
     *
     * + Pimple verwendet jedes Objekt als Singleton
     *
     * @throws \Exception
     * @throws frinkError
     */
    public function decorationPattern()
    {
        try {
            // Dekorieren der Torte
            $this->torteVorbereiten();

            // Geburtstagsfeier
            $this->Geburtstagsfeier();

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

    /**
     * Vorbereiten der Geburtstagstorte
     *
     * @throws frinkError
     */
    protected function torteVorbereiten()
    {
        // PhpStorm mitteilen welches Model verwendet wird
        /** @var $torteMitDekoration \models\TorteMitDekoration */
        $torteMitDekoration = $this->pimple['torteMitDekoration'];

        // dynamisches hinzufügen von Methoden
        $torteMitDekoration->addMethod('kerzen', function(){
            return 'Kerzen verwenden';
        });

        $torteMitDekoration->addMethod('anzuenden', function(){
            return 'Kerzen anzuenden';
        });

        $torteMitDekoration->addMethod('auspusten', function (){
            return 'Kerzen auspusten';
        });

        // die Torte in den Kühlschrank stellen
        $this->pimple['torteMitDekorationUndKerzen'] = $torteMitDekoration;

        return;
    }

    /**
     * Verwendung eines Dekoration Pattern am Beispiel einer Torte während einer Geburtstagsfeier
     *
     */
    protected function Geburtstagsfeier()
    {
        // Torte aus dem Kühlschrank holen

        /** @var $torteMitDekorationUndKerzen \models\TorteMitDekoration */
        $torteMitDekorationUndKerzen = $this->pimple['torteMitDekorationUndKerzen'];

        // Kerzen aufstecken
        $test = $torteMitDekorationUndKerzen->kerzen();

        // Kerzen anzünden
        $test = $torteMitDekorationUndKerzen->anzuenden();

        // Kerzen auspusten
        $test = $torteMitDekorationUndKerzen->auspusten();

        // Den Frauen klar machen das die Torte zu viele Kalorien hat :-)
        $test = $torteMitDekorationUndKerzen->hasKalorien();

        return;
    }
}