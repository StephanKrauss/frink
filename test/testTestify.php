<?php
require '../vendor/autoload.php';

// Datei die überprüft werden soll
use controller\testify as file;
// Testklasse Testify
use Testify\Testify;

// Verbindung zu den Datenbanken
use tools\verbindungen;

/** @var $testify \Testify\Testify */
$testify = new Testify("Test des Controller Testify");

// Grundeinstellungen des Test
$testify->beforeEach(function($testify)
{
	// anzeigen Report , true = grafische Ausgabe
	$testify->flagShowReport = true;

	$fileName = basename(__FILE__);
	$testify->fileName = $fileName;
});

// Initialisieren des Controller und Verbindung zu den Datenbanken
$testify->before(function($testify) {

	// Zugangsdaten MySQL
	include_once('../app/config/datenbank.php');
	// Zugangsdaten Redis
	include_once('../app/config/redis.php');

	$controller = 'testify';
	$action = 'get';

	list($sparrow, $notNoSql, $clientPredis, $pdo) = \tools\verbindungen::connectDatabase($zugangswerte, $zugangRedis);

	// Methoden auf 'public'
//	$reflection = new \ReflectionClass(get_ob('testify'));
//	$method = $reflection->getMethod('myPrivate');
//	$method->setAccessible(true);

	$testFile = new file($controller, $action);

	$testFile->pimple['notNoSql'] = $notNoSql;
	$testFile->pimple['sparrow'] = $sparrow;
	$testFile->pimple['predis'] = $clientPredis;

	$testify->data->test = $testFile;
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
//$anzahlRunner = $testify->getAuswertungRunner();
//echo "Anzahl Fehler: ".$anzahlRunner;