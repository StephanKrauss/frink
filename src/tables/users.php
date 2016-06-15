<?php
namespace tables;

use Spot\EntityInterface as Entity;
use Spot\MapperInterface as Mapper;

class users extends \Spot\Entity
{
    // zentrale Methoden des Mapper
    use \traits\MapperData;

    protected static $table = 'users';
    protected static $mapper = 'mapper\users';

    public static function fields()
    {
        return [
            'id'           => ['type' => 'integer', 'autoincrement' => true, 'primary' => true],
            'username'     => ['type' => 'string', 'required' => true],
            'email'        => ['type' => 'string', 'required' => true],
            'status'       => ['type' => 'integer', 'default' => 0, 'index' => true],
            'date_created' => ['type' => 'datetime']
        ];
    }
    
    public static function relations(Mapper $mapper, Entity $entity)
    {
        return [
            'profile' => $mapper->hasMany($entity, 'tables\profile', 'user_id')
        ];
    }
}