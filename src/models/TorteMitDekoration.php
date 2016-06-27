<?php

namespace models;
use \traits\addMethods;

/**
* Torte / Basisklasse mit nachträglichem dynamischen hinzufügen von Methoden
*
* + Trait *'addMethods'* zur Ergänzung der Klasse
 *
* @author Stephan Krauß
* @copyright Stephan Krauss
* @lisence Stephan Krauß
* @date 27.06.2016
*
* @package traits
*/

class TorteMitDekoration extends \models\Torte
{
    use \traits\addMethods;

}