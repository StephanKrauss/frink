<?php

namespace controller;

/**
 * Class phpMd
 *
 * @package controller
 */
class PhpMd extends main
{
    /**
     *
     */
    public function cleanCodeRules()
    {
        $wert = 'abc';

        if ($wert == 'aaa')
            $wert = 'aaa';
        elseif ($wert == 'bbb')
            $wert = 'aaa';
        elseif ($wert == 'ccc')
            $wert = 'aaa';
        else
            $wert = 'aaa';

        $x = true;
        $y = true;
        $z = true;

        if($x){
            if($y){
                if($z){
                    $wert = 'xyz';
                }
            }

            return $x;
        }

        return $wert;

    }

    /**
     * @param bool $flag
     * @return bool
     */
    public function boolenArgumenFlag($flag = true)
    {

        return $flag;
    }

    /**
     * @param $flag
     */
    public function elseTest($flag)
    {
        if ($flag) {
            // one branch
        } else {
            // another branch
        }
    }
}