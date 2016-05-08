<?php

include_once("../vendor/autoload.php");

use \models\myCalc;
use \Testify\Testify;

$testify = new Testify("MyCalc Test Suite");

$testify->beforeEach(function($testify) {
    $testify->data->calc = new myCalc(10);
});

$testify->test("Testing the add() method", function($testify) {
    $calc = $testify->data->calc;

    $calc->add(4);
    $testify->assert($calc->getSumme() == 13);

    $calc->add(-6);
    $testify->assertEquals($calc->getSumme(), 10);
});

$testify();