<?php
namespace models;

/**
* Test der dynamischen Erweiterung einer Basisklasse
*
* @author Stephan Krauß
* @copyright Stephan Krauss
* @lisence Stephan Krauß
* @date 16.06.2016
*
* @package models
*/

class extendsBasis
{
    protected $basis;

    /**
     * übernimmt das zu erweiternde Objekt
     *
     * @param $object
     * @return extendsBasis
     */
    public function setBasisClass($object)
    {
        $this->basis = $object;

        return $this;
    }

    /**
     * ruft die Methode des gespeicherten Objektes auf
     *
     * @param $method
     * @param $args
     * @return mixed
     * @throws Exception
     */
    public function __call($method, $args)
    {
        if (method_exists($this->basis, $method))
            return call_user_func_array(array($this->basis, $method), $args);
        else
            throw new \frinkError(__CLASS__ + " has no method " + $method, 3);
    }

    /**
     * ruft eine Property auf
     *
     * @param $attr
     * @return mixed
     * @throws Exception
     */
    public function __get($attr)
    {
        if (property_exists($this->basis, $attr))
            return $this->basis->$attr;
        else
            throw new \frinkError(__CLASS__ + " has no property " + $attr, 3);
    }

    /**
     * setzt den Inhalt einer Property
     *
     * @param $attr
     * @param $value
     * @return mixed
     * @throws Exception
     */
    public function __set($attr, $value)
    {
        if (property_exists($this->basis, $attr))
            return $this->basis->$attr = $value;
        else
            throw new \frinkError(__CLASS__ + " has no property " + $attr, 3);
    }
}