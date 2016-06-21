<?php

namespace models;
use \tools\frinkError;

/**
* Erweiterung der Model. Organisiert die Datenhaltung und die Verwendung als Subject oder Observer
*
* + Methode **notify()** in das allgemeine Model übernehmen
*
* @author Stephan Krauß
* @copyright Stephan Krauss
* @lisence Stephan Krauß
* @date 17.06.2016
*
* @package models
*/

class ModelData implements \ArrayAccess
{
    use \traits\arrayAccess;
    
    public $data = [];
    protected $pimple;

    /**
     * ModelData constructor.
     *
     * @param $pimple
     */
    public function __construct(\Pimple\Container $pimple)
    {
        $this->pimple = $pimple;
    }

    /**
     * @return array
     */
    public function getAllData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return ModelData
     */
    public function setAllData(array $data)
    {
        $this->data = $data;

        return $this;
    }
}