<?php

namespace traits;
use tools\frinkError;

/**
* Trait für das dynamische erweitern einer Klasse um eine oder mehrere Methoden
*
* @author Stephan Krauß
* @copyright Stephan Krauss
* @lisence Stephan Krauß
* @date 27.06.2016
*
* @package traits
*/

trait addMethods
{
    private $methods = array();

    /**
     * hinzufügen einer Methode zu einer bereits vorhandenen Klasse
     *
     * @param $methodName
     * @param $methodCallable
     * @throws frinkError
     */
    public function addMethod($methodName, $methodCallable)
    {
        if (!is_callable($methodCallable)) {
            throw new frinkError('zweite Parameter muss eine aufrufbare Funktion beinhalten', 3);
        }

        // $this->methods[$methodName] = Closure::bind($methodCallable, $this, get_class());
        $this->methods[$methodName] = $methodCallable;
    }

    /**
     * Aufruf einer Methode die in der Basisklasse nicht vorhanden ist
     *
     * @param $methodName
     * @param array $args
     * @return mixed
     * @throws RunTimeException
     */
    public function __call($methodName, array $args)
    {
        if (isset($this->methods[$methodName])) {
            return call_user_func_array($this->methods[$methodName], $args);
        }

        throw new frinkError('Diese Methode ist nicht vorhanden');
    }
}