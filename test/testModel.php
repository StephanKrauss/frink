<?php

require '../vendor/autoload.php';

use Testify\Testify;
use models\model;

// Verarbeitung protected Methoden
class test extends \models\model{
	public function mult($wert1, $wert2){
		return parent::mult($wert1, $wert2);
	}
}

/** @var $testify \Testify\Testify */
$testify = new Testify("Test einer Klasse");

// Objekt mit Startparameter im Controller
$testify->beforeEach(function($testify) {
	$test = new test(10);

	$testify->data->test = $test;
});

$testify->test("Test der Methode add()", function($testify)
{
	$test = $testify->data->test;

	$testify->assert($test->add(5,4) == 9, __LINE__);
	$testify->assert($test->add(5,4) == 10, __LINE__);
});

$testify->test("Test der Methode sub()", function($testify)
{
	$test = $testify->data->test;

	$testify->assert($test->sub(9,4) == 5, __LINE__);
});

$testify->test("Test der Methode mult()", function($testify)
{
	$test = $testify->data->test;

	$testify->assert($test->mult(3,3) == 9, __LINE__);
});

$testify();
