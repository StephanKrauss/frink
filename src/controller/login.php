<?php
/**
 * Created by PhpStorm.
 * User: Stephan.Krauss
 * Date: 21.04.2016
 * Time: 16:40
 */

namespace controller;
use Spot\Exception;
use tools\errorAuswertung;

/**
 * darstellen der leeren Seite des Template
 *
 * @author Stephan.Krauss
 * @date 23.06.2015
 * @package Controller
 */

class login extends main
{
    /**
     * erweitern Pimple um spezielle Model und Tools
     */
    public function __construct($controllerName, $actionName)
    {
        $models = array(
            'model' => function() {
                return new model($this->params);
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
                'masterTemplate' => 'main.html'
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
     * Laden des Parent Template und Subtemplate des Baustein, Formular der Anmeldung
     */
    public function index()
    {
        try{
            $outputTemplate = array(
                'masterTemplate' => 'main.html'
            );

            \Flight::view()->display($this->templateName, $outputTemplate);
        }
        catch(\Exception $e){
            throw $e;
        }
    }

    /**
     * überprüft die Anmeldung
     *
     * @throws Exception
     */
    public function check()
    {
        try{
            // check login params
            $this->checkLoginParams();

            /** @var $datenbank \models\Sparrow */
            $datenbank = \Flight::get('sparrow');

            // schreiben Benutzer-ID und Rolle-ID in die Session







        }
        catch(Exception $e)
        {
            throw $e;
        }
    }

    /**
     * Kontrolle der Login Parameter
     *
     * @throws \tools\frinkError
     */
    protected function checkLoginParams()
    {
        /** @var $modelValidator \models\validator */
        $modelValidator = \models\validator::get_instance();

        unset($this->params['senden']);

        // Validator
        $modelValidator->validation_rules(array(
            'benutzer' => 'required|valid_email',
            'passwort' => 'required|min_len,8'
        ));

        // Filter
        $modelValidator->filter_rules(array(
            'benutzer' => 'trim|sanitize_email',
            'passwort' => 'trim'
        ));

        $params = $modelValidator->run($this->params);

        if ($params === false)
            throw new \tools\frinkError('Parameter Login falsch', 3);
    }
}