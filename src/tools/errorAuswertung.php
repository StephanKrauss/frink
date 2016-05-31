<?php

namespace tools;

/**
* Wertet den Inhalt der Exception aus und trägt die Exception in die Tabelle 'exception' ein.
*
* @author Stephan Krauss
* @copyright Stephan Krauss
* @lisence MIT
* @package Tool
* @date 31.05.2016
*/

class errorAuswertung
{

	/**
	 * Übernimmt die Exception und führt die Auswertung durch
	 *
	 * @param \Exception $exception
	 *
	 * @return array
	 */
	public static function readException(\Exception $exception)
	{
		$modelSession = \Flight::get('session');
		$completeSession = $modelSession->readCompleteSession();

		$error = array(
			'message' => $exception->getMessage(),
			'code' => $exception->getCode(),
			'file' => $exception->getFile(),
			'line' => $exception->getLine(),
			'trace' => $exception->getTraceAsString(),
			'session' => json_encode($completeSession)
		);

		return $error;
	}

	/**
	 * Inhalt der Exception in Tabelle 'exception' eintragen
	 * 
	 * @param array $error
	 */
	public static function writeException(array $error)
	{
		/** @var $pdo \PDO */
		$pdo = \Flight::get('pdo');

		// here you have to trust your field names!
		$fields = array_keys($error);
		$values = array_values($error);

		$fieldListString = implode(',',$fields);

		$valueListString = '';
		for($i=0; $i < count($values); $i++){
			$value = addslashes($values[$i]);
			$valueListString .= "'".$value."',";
		}

		$valueListString = substr($valueListString, 0,-1);

		$sql = "insert into exception(".$fieldListString.") values(".$valueListString.")";
		$pdo->exec($sql);

		return;
	}


}
