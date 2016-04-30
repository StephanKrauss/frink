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
}