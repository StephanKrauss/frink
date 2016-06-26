<?php
namespace tables;

use Spot\EntityInterface as Entity;
use Spot\MapperInterface as Mapper;

/**
* Entity der Tabelle 'artikle'
*
* @author Stephan Krauß
* @copyright Stephan Krauss
* @lisence Stephan Krauß
* @date 03.06.2016
*
* @package entity
*/
class artikel extends \Spot\Entity
{
    protected static $table = 'artikel';

    /**
     * Felder der Tabelle 'artikel'
     *
     * @return array
     */
    public static function fields()
    {
        return [
            'id' => ['type' => 'integer', 'autoincrement' => true, 'primary' => true],
            'benutzer_id' => ['type' => 'integer'],
            'artikelbeschreibung' => ['type' => 'string', 'required' => true],
            'erstelltAm' => ['type' => 'datetime', 'default' => 'CURRENT_TIMESTAMP'],
            'erstelltDurch' => ['type' => 'integer'],
            'geaendertAm' => ['type' => 'datetime'],
            'erstelltDurch' => ['type' => 'integer']
        ];
    }
}