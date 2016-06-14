<?php
namespace tables;

use Spot\EntityInterface as Entity;
use Spot\MapperInterface as Mapper;

class User extends \Spot\Entity
{
    protected static $table = 'users';

    public static function fields()
    {
        return [
            'id'           => ['type' => 'integer', 'autoincrement' => true, 'primary' => true],
            'username'     => ['type' => 'string', 'required' => true],
            'email'        => ['type' => 'string', 'required' => true],
            'status'       => ['type' => 'integer', 'default' => 0, 'index' => true],
            'date_created' => ['type' => 'datetime', 'value' => new \DateTime()]
        ];
    }
    
    public static function relations(Mapper $mapper, Entity $entity)
    {
        return [
            'profile' => $mapper->hasOne($entity, 'Entity\User\Profile', 'user_id')
        ];
    }
}