<?php

namespace models;

/**
* Test Model zur Verwendung mit 'testify'
*
* @package Model
* @date 04.05.2016
* @author Stephan Krauß
*/

class model
{
    protected $store = null;
    protected $start = 0;
    
    public function __construct($param)
    {
        $this->start = $param;
    }

    public function add($wert1, $wert2)
    {
        return $wert1 + $wert2;
    }

    public function sub($wert1, $wert2)
    {
        return $wert1 - $wert2;
    }

    protected function mult($wert1, $wert2)
    {
        return $wert1 * $wert2;
    }
}