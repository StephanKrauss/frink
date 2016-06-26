<?php

namespace models;

/**
* Parsen der INI Dateien der zentralen Konfiguration
*
* @author Stephan Krauss
* @copyright Stephan Krauss
* @lisence MIT
* @package Model
* @date 27.05.2016
*/

class iniparser {

	protected $declared = false;

	/**
	 * Übernimmt die Pfade der INI Dateien
	 *
	 * @param $pathes
	 *
	 * @return array
	 */
	public function parse($pathes)
	{
		$allConf = array();

		foreach($pathes as $path){
			$conf = $this->getArray($path);
			$allConf= array_merge($allConf, $conf);
		}

		return $allConf;
	}

	/**
	 * Zerlegen der INI Dateien in ein Array
	 *
	 * @param $path
	 *
	 * @return array
	 */
	protected function getArray($path)
	{
		$conf = parse_ini_file($path,true);

		return $conf;

	}
}
