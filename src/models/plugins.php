<?php

namespace models;

/**
* Plugins des Framework zur Bearbeitung des Request
*
* @author Stephan Krauß
* @date 15.05.2016
* @copyright Stephan Krauss
* @package model
*/

class plugins
{
    protected $request = null;

    public function __construct($request)
    {
        $this->request = $request;

        $methods = get_class_methods($this);

        forEach($methods as $method)
        {
            if(strstr($method,'plugin'))
            {
                $this->$method();
            }
        }
    }

    protected function pluginABC()
    {
        $request = $this->request;

        $this->request = $request;

        return;
    }

    protected function pluginDEF()
    {
        $request = $this->request;

        $this->request = $request;

        return;
    }

    public function getRequest()
    {
        return $this->request;
    }
}