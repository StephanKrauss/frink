<?php

namespace controller;

/**
* Test Validator Klasse
*
* @author Stephan Krauß , 25.05.2016
* @copyright Stephan Krauss
*
* @subpackage controller
*/

class validator extends main
{
    /**
     * erweitern Pimple um spezielle Model und Tools
     */
    public function __construct($controllerName, $actionName)
    {
        $models = array(
            'model' => function() {
                return new model($this->params);
            },
            'myCalc' => function(){
                return new myCalc(10);
            }
        );

        parent::__construct($controllerName, $actionName);

        parent::pimple($models);
    }

    /**
     * Laden des Parent Template und Subtemplate des Baustein
     */
    protected function template()
    {
        try{

            $outputTemplate = array(
                'masterTemplate' => 'main.html',
                'templateSuperuser' => 'bla_superuser.html'
            );

            \Flight::view()->display($this->templateName, $outputTemplate);
        }
        catch(\Exception $e){
            throw $e;
        }
    }

    public function post()
    {
        try{
            $modelValidator = \models\validator::get_instance();

            // Testdaten
            $test = array(
                'comment' => '<strong>this is freaking awesome</strong><script>alert(1);</script>'
            );

            // Validator
            $modelValidator->validation_rules(array(
                'comment' => 'required|max_len,500',
            ));

            // Filter
            $modelValidator->filter_rules(array(
                'comment' => 'basic_tags',
            ));

            $this->params = $modelValidator->run($test);

            $this->template();
        }
        catch(\Exception $e)
        {
            throw $e;
        }
    }
    
}