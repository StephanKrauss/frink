<?php
namespace Entity;

/**
* Entity der Tabelle 'posts'
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
    protected static $mapper = 'tables\mapper\post';

    public static function fields()
    {
        return array(
            'id' => array('type' => 'integer', 'primary' => true, 'serial' => true),
            'title' => array('type' => 'string', 'required' => true),
            'body' => array('type' => 'text', 'required' => true),
            'status' => array('type' => 'integer', 'default' => 0, 'index' => true),
            'date_created' => array('type' => 'datetime')
        );
    }

    public static function relations(\Spot\MapperInterface $mapper, \Spot\EntityInterface $entity)
    {
        return array(
            // Each post entity 'hasMany' comment entites
            'comments' => array(
                'type' => 'HasMany',
                'entity' => 'Entity_Post_Comment',
                'where' => array('post_id' => ':entity.id'),
                'order' => array('date_created' => 'ASC')
            )
        );
    }
}