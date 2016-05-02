<?php
/**
 * Created by PhpStorm.
 * User: PC Stephan
 * Date: 30.04.2016
 * Time: 15:20
 */

namespace models;

/**
* math. Klasse
*
* @author Stephan Krauß , 30.24.2016
* @copyright Stephan Krauss
*
* @package model
*/
class myCalc
{
    /** @var int  */
    public $summe = 0;

    protected $werte = array();

    public function __construct($anfangswert){
        $this->summe = $anfangswert;
    }

    public function add($summand){
        $this->summe += $summand;

        return $this;
    }

    public function getSumme(){
        return $this->summe;
    }

    public function __get($key)
    {
        return $this->werte[$key];
    }

    public function __set($name, $value)
    {
        $this->werte[$name] = $value;
    }

    public function __call($name, $arguments)
    {
        return 'unbekannte Methode';
    }

    public static function __callStatic($name, $arguments){
        return $arguments[0];
    }
}