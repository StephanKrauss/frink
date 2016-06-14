<?php
namespace tables;

use Spot\EntityInterface as Entity;
use Spot\MapperInterface as Mapper;

class profile extends \Spot\Entity
{
    protected static $table = 'profile';

    public static function fields()
    {
        return [
            'id'           => ['type' => 'integer', 'autoincrement' => true, 'primary' => true],
            'user_id'     => ['type' => 'integer', 'required' => true],
            'name'        => ['type' => 'string', 'required' => true]
        ];
    }
}