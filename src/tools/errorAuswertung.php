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


		$error = array(
			'message' => $exception->getMessage(),
			'code' => $exception->getCode(),
			'file' => $exception->getFile(),
			'line' => $exception->getLine(),
			'trace' => $exception->getTraceAsString()
		);

        // wenn Session vorhanden
        if(\Flight::get('session')){
            $modelSession = \Flight::get('session');
            $completeSession = $modelSession->readCompleteSession();

            $error['session'] = json_encode($completeSession);
        }

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

		$fehlernummer = $pdo->lastInsertId();

		$error['fehlernummer'] = $fehlernummer;

		return $error;
	}

	/**
	 * Meldet Fehlernummer, Datum und Uhrzeit als Mail
	 *
	 * @param array $error
	 */
	public static function mailException(array $error)
	{
		if($error['code'] != 3)
			return;

		$message = "Ein Fehler ist aufgetreten, Fehlernummer ".$error['fehlernummer'].". ".date('Y-m-d H:i:s')." Uhr";

		$mailer = new \models\SimpleMail();
		$mailer
			->setTo('johann@frink.de','Dein Email' )
			->setSubject('Fehlermeldung Typ 3')
			->setFrom('info@system.de','Systemmeldung' )
			->setMessage($message)
			->send();
	}
}
