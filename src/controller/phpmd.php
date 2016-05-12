<?php

namespace controller;

/**
 * Class phpMd
 * @package controller
 */
class PhpMd extends main
{
    /**
     *
     */
    public function cleanCodeRules()
    {

    }

    /**
     * @param bool $flag
     * @return bool
     */
    public function boolenArgumenFlag($flag = true){

        return $flag;
    }

    /**
     * @param $flag
     */
    public function elseTest($flag){
        if ($flag) {
            // one branch
        } else {
            // another branch
        }
    }
}