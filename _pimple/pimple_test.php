<?php

// Original URL: http://gm.zoomlab.it/2014/structured-applications-with-pimple/

// Installation von Pimple

/**
 * Installation von Pimple
 *
{
    "name": "gmazzap/hello-world",
    "authors": [
        {
            "name": "Giuseppe Mazzapica",
            "email": "giuseppe.mazzapica@gmail.com",
            "homepage": "http://gm.zoomlab.it",
            "role": "Developer"
        }
    ],
    "require": {
        "pimple/pimple": "~3.0"
    },
    "autoload": {
        "psr-4": {
            "GM\\HelloWorld\\": "src/"
        },
        "files": ["helpers.php"]
    },
    "config": {
        "optimize-autoloader": true
    }
}
*
*/

// Interface für das Word Object

// file: /src/Words/WordInterface.php
namespace GM\HelloWorld\Words;

interface WordInterface {
    public function output();
}

// file: /src/Words/Hello.php

namespace GM\HelloWorld\Words;

class Hello implements WordInterface {
    public function output()
    {
        return 'Hello';
    }
}

// file: /src/Words/World.php

namespace GM\HelloWorld\Words;

class World implements WordInterface
{
    public function output()
    {
        return 'World';
    }
}

// Words Service Provider
// file: /src/Providers/WordsServiceProvider.php

namespace GM\HelloWorld\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;
use GM\HelloWorld\Words as W;

class WordsServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $pimple['hello'] = function()
        {
            return new W\Hello();
        };

        $pimple['world'] = function()
        {
            return new W\World();
        };
    }
}

// Helper für den Pimple DIC
// file: /helpers.php

namespace GM\HelloWorld;

/**
 * On first call instantiate Pimple container and register the providers
 * loading them form a file. On subsequent calls returns container itself
 * or a service, if $which param is a service id.
 *
 * @param string|void $which Service id to retrieve
 * @staticvar \Pimple\Container $app Container instance
 * @return mixed
 * @throws \InvalidArgumentException If $which param isn't null but service is not defined
 */

function app($which = null)
{
    static $app = null;

    if (is_null($app))
    {
        $app = new \Pimple\Container;
        $providers = (array) require __DIR__.'/providers.php';

        array_walk($providers, function($class, $i, $app)
        {
            class_exists($class) AND $app->register(new $class);
        }, $app);

    }

    return is_null($which) || ! is_string($which) ? $app : $app[$which];
}

 // file: /providers.php

return array(   '\\GM\\HelloWorld\\Providers\\WordsServiceProvider', );

