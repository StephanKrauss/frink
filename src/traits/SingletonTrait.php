<?php

namespace traits;

/**
* Erstellen eines Singleton Model mit Trait
*
* @author Stephan Krauß
* @copyright Stephan Krauss
* @lisence Stephan Krauß
* @date 22.06.2016
*
* @package traits
*/

trait SingletonTrait
{
    /**
     * @var self The stored singleton instance
     */
    protected static $instance;

    /**
     * Creates the original or retrieves the stored singleton instance
     *
     * @return self
     */
    public static function getInstance(\Pimple\Container $pimple)
    {
        if (!static::$instance) {
            static::$instance = (new \ReflectionClass(get_called_class()))->newInstanceWithoutConstructor();
            static::$instance->pimple = $pimple;
        }

        return static::$instance;
    }

    /**
     * SingletonTrait constructor.
     * @param \Pimple\Container $pimple
     */
    private function __construct(\Pimple\Container $pimple)
    {
        $this->pimple = $pimple;
    }

    /**
     * Cloning is disabled
     *
     * @throws \RuntimeException if called
     */
    public function __clone()
    {
        throw new \RuntimeException('You may not clone this object, because it is a singleton.');
    }

    /**
     * Unserialization is disabled
     *
     * @throws \RuntimeException if called
     */
    public function __wakeup()
    {
        throw new \RuntimeException('You may not unserialize this object, because it is a singleton.');
    }

    /**
     * Unserialization is disabled
     *
     * @throws \RuntimeException if called
     */
    public function unserialize($serialized_data)
    {
        throw new \RuntimeException('You may not unserialize this object, because it is a singleton.');
    }
}