<?php

namespace models;

/**
* Basisklasse Torte zum Test des Decoration Pattern
*
* + verschiedene Methoden des Objektes
*
* @author Stephan Krauß
* @copyright Stephan Krauss
* @lisence Stephan Krauß
* @date 27.06.2016
*
* @package models
*/

class Torte extends \models\modelBasis
{
    /**
     *
     * @return string
     */
    public function zuckerGuss()
    {
        return 'Zuckerguss';
    }

    /**
     * @return string
     */
    public function hasFruechte()
    {
        return 'Fruechte';
    }

    /**
     * @return string
     */
    public function hasKalorien()
    {
        return 'gewaltig Kalorien';
    }
}