<?php
/**
 * allgemeiner ErrorController
 *
 * @package Controller
 * @date 21.04.2016
 * @author Stephan Krauß
 */

namespace controller;

class error extends main
{

    /**
     * Laden des Parent Template der Error Anzeige
     */
    public function index()
    {
        try {


            \Flight::redirect('/start/index');
        }
        catch (\Exception $e) {
            throw $e;
        }
    }
}