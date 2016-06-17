<?php
namespace models;
use tools\frinkError;

/**
* Test der dynamischen Erweiterung einer Basisklasse ( Subjekt ) um das Interface SplSubject
*
* @author Stephan Krauß
* @copyright Stephan Krauss
* @lisence Stephan Krauß
* @date 16.06.2016
*
* @package models
*/

class extendsSplSubject implements \SplSubject
{
    protected $basis;
    protected $observers = [];

    /**
     * fügt einen Observer / Beobachter hinzu
     *
     * @param \SplObserver $observer
     * @return extendsSplObserver
     */
    public function attach(\SplObserver $observer)
    {
        $this->observers[] = $observer;

        return $this;
    }

    /**
     * entfernt einen Observer / Beobachter
     *
     * @param \SplObserver $observer
     * @return extendsSplObserver
     */
    public function detach(\SplObserver $observer) {

        $key = array_search($observer,$this->observers, true);
        if($key)
            unset($this->observers[$key]);

        return $this;
    }

    /**
     * Informiert die Beobachter über eine erfolgte Veränderung mit der Methode 'info'
     *
     * @return extendsSplObserver
     */
    public function notify() {
        foreach ($this->observers as $observer) {
            if (method_exists($observer, 'update'))
                $observer->notify($this);
        }

        return $this;
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