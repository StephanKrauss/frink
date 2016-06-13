<?php
	
	namespace mapper;
	use \Spot;

	/**
	 * Mapper der Tabelle 'test'
	 *
	 * @author Stephan Krauss
	 * @date 12.06.2016
	 * @file test.php
	 * @package mapper
	 */
	class test extends \tables\test
	{
		/**
		 * einfache Abfragen
		 *
		 * @return array
		 */
		public static function scopes()
		{
			return [
			   'free' => function ($query) {
				   return $query->where(['type' => 'free']);
			   },
			   'active' => function ($query) {
				   return $query->where(['id' => 1]);
			   }
		   ];
		}
		
		public static function events(\Spot\EventEmitter $eventEmitter)
		{
			$eventEmitter->on('beforeSave', function (Entity $entity, Mapper $mapper) {
				$entity->zahl = 5;
			});
		}
	}
