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

class mail extends main
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
     * Test von Swift - Mail
     *
     * @throws \Exception
     */
    public function get()
    {
        try{
            // throw new frinkError('ein gefährlicher Fehler', 3);

//            $mailer = new \SimpleMail();
//            $mailer
//                ->setTo('johann@frink.de','Dein Email' )
//                ->setSubject('wichtige Mail')
//                ->setFrom('info@bla.de','meine Mailadresse' )
//                ->setMessage('ein extrem wichtiger Text')
//                ->send();

            // mail('info@suppenterrine.de', 'Mein Betreff', 'meine wichtige Nachricht',"From: johann@frink.de");

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