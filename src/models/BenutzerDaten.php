<?php

namespace models;

/**
 * Model Benutzer Daten
 *
 * @author Stephan Krauß
 * @copyright Stephan Krauss
 * @lisence Stephan Krauß
 * @date 15.06.2016
 *
 * @package models
 */

class BenutzerDaten extends \models\ModelData implements \models\ModelInterface
{
    protected $pimple;

    /**
     * Übernahme des Dependency Injection Container
     *
     * BenutzerDaten constructor.
     * @param bool $pimple
     */
    public function __construct($pimple = false)
    {
        if($pimple)
            $this->pimple = $pimple;
    }

    /**
     * Übernahme der Daten
     *
     * @param array $data
     */
    public function notice(array $data)
    {
        if($data)
            $this->data = $data;
    }

}