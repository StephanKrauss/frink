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
class posts extends \Spot\Entity
{
    protected static $table = 'posts';

    public static function fields()
   {
       return [
           'id'           => ['type' => 'integer', 'autoincrement' => true, 'primary' => true],
           'title'        => ['type' => 'string', 'required' => true],
           'body'         => ['type' => 'text', 'required' => true],
           'status'       => ['type' => 'integer', 'default' => 0, 'index' => true],
           'author_id'    => ['type' => 'integer', 'required' => true],
           'date_created' => ['type' => 'datetime', 'value' => new \DateTime()]
       ];
   }

    // Relations
    public static function relations(Mapper $mapper, Entity $entity)
    {
        return [
            'tags' => $mapper->hasManyThrough($entity, 'Entity\Tag', 'Entity\PostTag', 'tag_id', 'post_id'),
            'comments' => $mapper->hasMany($entity, 'Entity\Post\Comment', 'post_id')->order(['date_created' => 'ASC']),
            'author' => $mapper->belongsTo($entity, 'Entity\Author', 'author_id')
        ];
    }
}