<?php
namespace models;
use tools\frinkError;

/**
* Test der dynamischen Erweiterung einer Basisklasse ( Observer ) um das Interface SplObserver
*
* @author Stephan Krauß
* @copyright Stephan Krauss
* @lisence Stephan Krauß
* @date 16.06.2016
*
* @package models
*/

class extendsSplObserver implements \SplObserver
{
    protected $basis;
    protected $observers = [];

    /**
     * Übergibt das Subjekt - Objekt an den Observer
     *
     * + Kontrolliert ob ein Objekt übergeben wurde
     * + über die Methode notify wird der Observer informiert / aktualisiert
     *
     * @param \SplSubject $object
     */
    public function update(\SplSubject $object)
    {
        if (method_exists($this->basis, 'update'))
            $this->basis->notify($object);
    }

    /**
     * übernimmt das Basisobjekt
     *
     * @param $object
     * @return extendsBasis
     * @throws frinkError
     */
    public function setBasisClass($object)
    {
        if(is_object($object))
            $this->basis = $object;
        else
            throw new frinkError('Basis ist kein Objekt', 3);

        return $this;
    }

    /**
     * ruft eine Methode des gespeicherten Basisobjektes auf
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
     * ruft den Inhalt einer Property des Basisobjektes auf
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
     * setzt den Inhalt einer Property des Basisobjektes
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