<?php

namespace models;

/**
* Erweiterung der Model. Organisiert die Datenhaltung und die Verwendung als Subject oder Observer
*
* + Methode **notify()** in das allgemeine Model
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
    public $data = [];
    protected $pimple;

    public function __construct($pimple)
    {
        $this->pimple = $pimple;
    }

    /**
     * existiert die Variable in data[] ?
     *
     * @param mixed $offset
     * @return bool
     */
    public function offsetExists($offset)
    {
        if($this->data[$offset] === NULL)
            return false;
        else
            return true;
    }

    /**
     * @param mixed $offset
     * @return bool|mixed
     */
    public function offsetGet($offset)
    {
        if($this->offsetExists($offset))
            return $this->data[$offset];
        else
            return false;
    }

    /**
     * @param mixed $offset
     * @param mixed $value
     * @return
     */
    public function offsetSet($offset, $value)
    {
        $this->data[$offset] = $value;

        return $this;
    }

    public function offsetUnset($offset)
    {
        unset($this->data[$offset]);
    }

    public function getAllData()
    {
        return $this->data;
    }

    /**
     * @param array $data
     * @return basis
     */
    public function setAllData(array $data)
    {
        $this->data = $data;

        return $this;
    }

    /**
     * Methode für das Observer Pattern
     *
     * @return basis
     */
    public function notify()
    {
        $test = 123;

        return $this;
    }
}