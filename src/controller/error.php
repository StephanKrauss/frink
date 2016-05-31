<?php
/**
 * allgemeiner ErrorController mit Fire Logger
 *
 * @package Controller
 * @date 21.04.2016
 * @author Stephan Krauß
 * @link http://firelogger.binaryage.com/
 */

namespace controller;

use tools\errorAuswertung;

class error extends main
{
    protected $error = null;

    /**
     * Laden des Parent Template der Error Anzeige
     */
    public function index()
    {
        try {
            $config = \Flight::get('config');

            $error = \tools\errorAuswertung::readException($this->error);

            // Debug Modus anzeigen
            if($config['debugBlock']['debug'])
            {
                foreach($error as $key => $value){
                    echo $key.': '.nl2br($value).'<br>';
                }
            }
            // speichern in der Tabelle 'exception'
            else{
                \tools\errorAuswertung::writeException($error);

                \Flight::redirect('/start/index');
            }



        }
        catch (\Exception $e) {
            throw $e;
        }
    }

    public function setError($e){
        $this->error = $e;

        return $this;
    }
}