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
    public $basis;
    protected $observers = [];

    /**
     * fügt einen Observer / Beobachter hinzu
     *
     * @param \SplObserver $observer
     * @return extendsSplSubject
     */
    public function attach(\SplObserver $observer)
    {
        $this->observers[] =  $observer;

        return $this;
    }

    /**
     * entfernt einen Observer / Beobachter
     *
     * @param \SplObserver $observer
     * @return extendsSplSubject
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
     * @return extendsSplSubject
     */
    public function notify()
    {
        foreach ($this->observers as $observer) {
            $basis = $observer->basis;
            $basis->setAllData($this->basis->data)->notify();
        }

        return $this;
    }

    /**
     * übernimmt das Basisobjekt
     *
     * @param $object
     * @return extendsSplSubject
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
     * @throws frinkError
     */
    public function __call($method, $args)
    {
        if (method_exists($this->basis, $method))
            return call_user_func_array(array($this->basis, $method), $args);
        else
            throw new frinkError(__CLASS__." has no method ".$method, 3);
    }

    /**
     * ruft eine Property auf
     *
     * @param $attr
     * @return mixed
     */
    public function __get($offset)
    {
        // gibt Basis Objekt zurück
        if($offset == 'basis')
            return $this->basis;
        elseif(is_array($this->basis->data) and array_key_exists($offset, $this->basis->data))
            return $this->basis->offsetGet($offset);
    }

    /**
     * setzt den Inhalt einer Property
     *
     * @param $attr
     * @param $value
     */
    public function __set($offset, $value)
    {
        $this->basis->offsetSet($offset, $value);
    }
}