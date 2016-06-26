<?php

namespace models;

/**
* Grundinterface der Model mit übernahme des DIC Pimple und *'notice'* Methode für Observer
*
* @author Stephan Krauß
* @copyright Stephan Krauss
* @lisence Stephan Krauß
* @date 16.06.2016
*
* @package models
*/


interface ModelInterface
{
    public function __construct($pimple = false);

    public function notice(array $data);

}