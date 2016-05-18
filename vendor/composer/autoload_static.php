<?php

// autoload_static.php @generated by Composer

namespace Composer\Autoload;

class ComposerStaticInit6ddf1c3fb8cd77f10690bd1b9a9e7d16
{
    public static $files = array (
        'fc73bab8d04e21bcdda37ca319c63800' => __DIR__ . '/..' . '/mikecao/flight/flight/autoload.php',
        '5b7d984aab5ae919d3362ad9588977eb' => __DIR__ . '/..' . '/mikecao/flight/flight/Flight.php',
    );

    public static $prefixLengthsPsr4 = array (
        'U' => 
        array (
            'Underscore\\' => 11,
        ),
        'T' => 
        array (
            'Testify\\' => 8,
        ),
        'R' => 
        array (
            'RedBeanPHP\\' => 11,
        ),
        'P' => 
        array (
            'Predis\\' => 7,
        ),
    );

    public static $prefixDirsPsr4 = array (
        'Underscore\\' => 
        array (
            0 => __DIR__ . '/..' . '/im0rtality/underscore/src',
        ),
        'Testify\\' => 
        array (
            0 => __DIR__ . '/..' . '/bafs/testify/lib/Testify',
        ),
        'RedBeanPHP\\' => 
        array (
            0 => __DIR__ . '/..' . '/gabordemooij/redbean/RedBeanPHP',
        ),
        'Predis\\' => 
        array (
            0 => __DIR__ . '/..' . '/predis/predis/src',
        ),
    );

    public static $fallbackDirsPsr4 = array (
        0 => __DIR__ . '/../..' . '/src',
    );

    public static $prefixesPsr0 = array (
        'T' => 
        array (
            'Twig_' => 
            array (
                0 => __DIR__ . '/..' . '/twig/twig/lib',
            ),
        ),
        'P' => 
        array (
            'Psr\\Log\\' => 
            array (
                0 => __DIR__ . '/..' . '/psr/log',
            ),
            'Pimple' => 
            array (
                0 => __DIR__ . '/..' . '/pimple/pimple/src',
            ),
            'Parsedown' => 
            array (
                0 => __DIR__ . '/..' . '/erusev/parsedown',
            ),
        ),
    );

    public static function getInitializer(ClassLoader $loader)
    {
        return \Closure::bind(function () use ($loader) {
            $loader->prefixLengthsPsr4 = ComposerStaticInit6ddf1c3fb8cd77f10690bd1b9a9e7d16::$prefixLengthsPsr4;
            $loader->prefixDirsPsr4 = ComposerStaticInit6ddf1c3fb8cd77f10690bd1b9a9e7d16::$prefixDirsPsr4;
            $loader->fallbackDirsPsr4 = ComposerStaticInit6ddf1c3fb8cd77f10690bd1b9a9e7d16::$fallbackDirsPsr4;
            $loader->prefixesPsr0 = ComposerStaticInit6ddf1c3fb8cd77f10690bd1b9a9e7d16::$prefixesPsr0;

        }, null, ClassLoader::class);
    }
}
