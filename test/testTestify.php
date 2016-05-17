<?php
require '../vendor/autoload.php';

use Testify\Testify;
use controller\testify as file;


/** @var $testify \Testify\Testify */
$testify = new Testify("Test des Controller Testify");

// Ausgangswerte des Test
$testify->beforeEach(function($testify)
{
	// Klasse Reflektion
	// alle Methoden auf public

	// anzeigen Report , true = grafische Ausgabe
	$testify->flagShowReport = false;

	$fileName = basename(__FILE__);
	$testify->fileName = $fileName;
});

// Initialisieren des Controller
$testify->before(function($testify) {

	$controller = 'testify';
	$action = 'get';

	$test = new file($controller, $action);

	$testify->data->test = $test;
});

// Action 'get'
$testify->test("Controller testify / get", function($testify)
{
	$testify->assertTrue($testify->data->test->pimple, 'Anzahl Klassen im DIC');

	$testify->assert($testify->data->test->pimple['model'],"Klasse 'model' vorhanden");

	$testify->assert(1 == 2,"dummy 1");
});

$testify->test("Dummy 2", function($testify)
{
	$testify->assert(7 == 2,"dummy 2");
});

$testify();

// ermitteln Fehler - Stack
// list($filename, $stack) = $testify->getAuswertung();
// echo "Filename: ".$filename."<br>";
// var_dump($stack);

// Auswertung Fehleranzahl für Runner
$anzahlRunner = $testify->getAuswertungRunner();
echo "Anzahl Fehler: ".$anzahlRunner;