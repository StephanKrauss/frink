<?php

namespace models;
use \traits\SingletonTrait;

/**
* Verwendung eines Standard Model als Singleton
*
* @author Stephan Krauß
* @copyright Stephan Krauss
* @lisence Stephan Krauß
* @date 22.06.2016
*
* @package models
*/

class modelBasisSingleton extends \models\modelBasis
{
    use \traits\SingletonTrait;
}