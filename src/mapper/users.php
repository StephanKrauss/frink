<?php
	
	namespace mapper;
	use Spot\Mapper;
	use traits;

	/**
	* Mapper der Tabelle 'test'
	*
	* @author Stephan Krauß
	* @copyright Stephan Krauss
	* @lisence Stephan Krauß
	* @date 15.06.2016
	*
	* @package mapper
	*/
	
	class users extends Mapper
	{
		// komplexe wiederkehrende Fragen
		use traits\MapperData;

		/**
		 * Testfunktion für komplexe Abfragen
		 *
		 * @param $id
		 * @return \Spot\Query
		 */
		public function erste($id)
		{
			return 	$this->where(['id' => [$id]]);
		}

		// Scopes
		public function scopes()
		{
			return [
				'zweite' => function ($query) {
					return 	$this->where(['id' => [2]]);
				},
				'dritte' => function ($query) {
					return 	$this->where(['id' => [3]]);
				}
			];
		}
	}
