<?php
namespace tables;

use Spot\EntityInterface as Entity;
use Spot\MapperInterface as Mapper;

/**
* Entity der Tabelle 'test'
*
* @author Stephan Krauß
* @copyright Stephan Krauss
* @lisence Stephan Krauß
* @date 09.06.2016
*
* @package entity
*/
class test extends \Spot\Entity
{
    protected static $table = 'test';

    /**
     * Felder der Tabelle 'test'
     *
     * @return array
     */
    public static function fields()
    {
        return [
            'id' => ['type' => 'integer', 'primary' => true, 'autoincrement' => true],
            'name' => ['type' => 'string', 'required' => true],
			'zahl' => ['type' => 'integer']
        ];
    }

	// Relations

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

	// komplexe Abfragen


}