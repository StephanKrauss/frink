
## strukturierte Applikationen mit Pimple I

[ursprünglicher Artikel von Giuseppe Mazzapica](http://gm.zoomlab.it/2014/structured-applications-with-pimple/)
![](http://i.imgur.com/n1XwOPY.jpg)

### Zusammenfassung

Die Verwendung von Pimple ( [Version 3](http://pimple.sensiolabs.org/) )  erlaubt die Schaffung von skalierbaren und testbaren Anwendungen in Php.

Pimpel ist es ein kleiner, aber leistungsstarke DI -Container. Seine Stärke liegt in der Einfachheit. Pimple kann Services registrieren die dann abgerufen werden können. Pimple hat automatische Auflösung via Reflection API , keine fortschrittliche Sache wie Service - Bindung über Annotations ...

Zum registrieren eines Service wird eine closure function geschrieben die eine Instance des Service zurück gibt.
Die function selbst bekommt als Parameter den DI Container. Durch dieses Verfahren ist es möglich auf Grundlage bereits bestehender Service neue Service zu schreiben.

### Verwendung des DI Container Pimple

	$pimple['foo'] = function($pimple) {
	    return new Foo;
	 };

	$pimple['bar'] = function($pimple) {
	   return new Bar($pimple['foo']);
	};

Im obigen Beispiel wird eine Instanz der Klasse *'Foo'* in die Klasse *'Bar'* übergeben.
Hiebei handelt es sich um eine Konstruktor Injektion.
Die Besonderheit besteht darin das die Service erst dann erstellt werden wenn sie benötigt werden.
Daher spielt die Reihenfolge der Erstellung der Service keine Rolle.

Wenn Pimple ertellt wird, dann ist es möglich ein Array von Werten zu übergeben. Im Framework **Frink2**
ist dieses Verfahren die Hauptform der Erstellung von Objekten. Die erstelletn Objekte mit diesem Verfahren sind Objekte nach dem Design Pattern **Singleton**.

	$pimple = new Pimple\Container(array(
	   'foo' => function() {
	     return new Foo();
	   },
	   'bar' => function($pimple) {
	     return new Bar($pimple['foo']);
	   }
	 ));

Dies ist ein guter Ansatz weil dadurch alle Objekte zentral erstellt werden.
Diese Objekte können zentral erstellt werden und bei Bedarf überschrieben werden.
Im Framework **Frink2** gibt es pro Controller eine Methode in der Pimple verwaltet wird.
Durch die konsequente Übergabe des DI Container Pimple an alle Models stehen jederzeit alle Objekte zur Verfügung.
Eine mögliche Unübersichtlichkeit der Objekte kann durch eine spezielle Funktion des Editors gemildert werden.

### ein besserer Ansatz zur Nutzung von Pimple

Statt dem setzen von allen Objekten im Konstruktor des DI Container empfiehlt sich die Verwendung als Service Provider.Ab der Version 3 von Pimple sollte dieser Ansatz verwendet werden. Dazu steht die *'register()'* Methode zur Verfügung. Die Services sind Klassen die nur eine Aufgabe haben. Das registrieren von Services im Container. Pimple verwendet dazu nur die *'register()'* Methode.

	// FooServiceProvider.php

 	class FooServiceProvider implements Pimple\ServiceProviderInterface
	{

			public function register(Pimple\Container $pimple)
			{
				$pimple['foo'] = function(){
				 return new Foo();
				};
	
		       	$pimple['bar'] = function($pimple)
				{
			         return new Bar($pimple['foo']);
		        };

     		}
	}


	 // in another file...

	 $container = new Pimple\Container();
	 $container->register(new FooServiceProvider());

	 // and then 
		echo get_class($container['bar']);
	 // Bar 

### ein Beispiel

	// file: /src/Words/WordInterface.php
    namespace GM\HelloWorld\Words;

	interface WordInterface {
	   public function output();
	 }


	 // file: /src/Words/Hello.php
	 namespace GM\HelloWorld\Words;

	 class Hello implements WordInterface
	 {
		   public function output(){
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

Bis hierher dürfte es keine Probleme geben ?

Um diese Objekte global nutzbar in der Anwendung zu machen schreiben wir einen Service Provider.

	// file: /src/Providers/WordsServiceProvider.php
	namespace GM\HelloWorld\Providers;
	use Pimple\Container;
	use Pimple\ServiceProviderInterface;
	use GM\HelloWorld\Words as W;

	class WordsServiceProvider implements ServiceProviderInterface
	{
	     public function register(Container $pimple)
		 {
		       $pimple['hello'] = function(){
			         return new W\Hello();
	     	   };

			   $pimple['world'] = function()
			   {
			         return new W\World();
			   };
     	  }
	}

Wir sehen an dieser Stelle dass unsere Applikation wächst. Durch die Verwendung der Klasse *'WordsServiceProvider'*
und der Übergabe der Klassen *'Hello'* und *'World'* als Service an die *'Provider Klasse WordsServiceProvider'* sind die Service jederzeit verfügbar.

ZUr Verbesserung dieser Funktionalität schreiben wir eine kleine **Helper** Funktion.

	// file: /helpers.php
	 namespace GM\HelloWorld;

	 /**
	 * On first call instantiate Pimple container and register the providers
	 * loading them form a file. On subsequent calls returns container itself   
	 * or a service, if $which param is a service id.
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

	 return array(
				'\\GM\\HelloWorld\\Providers\\WordsServiceProvider'
			 );

Wenn die Helper - Funktion das erste Mal aufgerufen wird, erstellt die Funktion eine Instanz von Pimple.
In einem zweiten Schritt lädt die Helper Funktion die Datei *'providers.php'*. In der *'providers.php'* befindet sich ein Array der Service - Provider -Klassen. Diese Service - Provider - Klassen werden in Pimple registriert.
Bei jedem nachfolgenden Aufruf gibt die Funktion den DI Container Pimple zurück oder bei dem vorhandensein des Parameter *'$which'* den betreffenden Service zurück.

Mit dieser Funktion kann man überall in der Anwendung einen Service erhalten, einen Service registrieren oder die Service Provider laden.
Wenn unsere Anwendung wächst können wir verschiedene *'providers.php'* verwenden.
Es entsteht ein übersichtliches und verständliches System.
Durch das einfügen oder ändern einer Zeile in einer der *'provider.php'* können weitere Service geladen werden ohne anderen Code zu verändern.






