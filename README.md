# minimalistisches componentenbasiertes Framework *'Frink2'*
( für die schnelle Entwicklung von Administrations Systemen )

## Professor John Nerdelbaum Frink, Jr.

<img src='http://test.stephankrauss.de/frink_mini.jpg'>

### Credits:

+ Flight: mikecao/flight ( MIT ) , Basis des Framework
+ Twig: twigphp/Twig ( BSD ) , Template Engine
+ Sparrow: mikecao/sparrow ( MIT ) , simples ORM , Active Record
+ Spot2: vlucas/Spot ( Doctrine Project ) , ORM auf Basis Doctrine DBAL
+ <s>Redbean: gabordemooij/redbean ( NEW BSD ) </s> , geht gar nicht 
+ Underscore: Im0rtality/Underscore ( free ) , Php Klone des Javascript Framework
+ Predis: nrk/predis ( free ) , NoSQL Datenbank
+ <s>Testify: marco-fiset/Testify ( GPL )</s> , sehr einfaches Testframework , hat leider keinen *'Runner'*
+ Pimple: pimple/pimple ( free ) , DI Container , zentrale Verwaltung der Klassen im Controller
+ Simple Mail: eoghanobrien/php-simple-mail ( MIT ) , Mailklasse
+ Validator: Wixel/GUMP ( MIT ) , Klasse zur Validierung und Filterung der Parameter
+ Template Bootstrap 3: [Vorlagen , SB Admin 2](http://blackrockdigital.github.io/startbootstrap-sb-admin-2/pages/index.html)

### Dokumentation und Handzettel:

+ /_apache , anlegen des virtual Host im Apache
+ /_datenbank , Struktur ( SQLYog ) und SQL Dump
+ /_docs_frink , selbst erstellte Klassen des Framework **'Frink2'**
+ /_docs_pimple , Test des DI Container Pimple
+ /_docs_spot , Dokumentation des Overlay *'Spot2'* ORM
+ /_md_pimple , Tutorial zur Verwendung des DI Container Pimple
+ /_md_spot , Vorhandene Methoden des ORM Spot2
+ /_md_validator , Nutzung des Validator


### erledigt: 

+ Vers. 0.1:
    + Routing
    + einbau Twig Templat Engine
    + Zentralisierung der Startparameter unter /app/config.ini

+ Vers. 0.2:
    + einbau NoSQL Redis Client , Predis
    	+ Test: Provider: [Redis to Go](http://redistogo.com/)

+ Vers. 0.3:
    + entwickeln Error Controller und Fehlerverhalten festlegen
    	+ registrieren
    	+ korrigieren
    	+ blockieren
    + Error Controller mit Registrierung und Mailversandt 

+ Vers. 0.4:
	+ Logsystem
		+ Registrierung Log Meldungen in einer Datenbank
		+ Injektion der Benutzer - ID in die MySQL und deren Verwendung in den Triggern der Tabellen

+ Vers. 0.5:
	+ Übernahme des ORM Spot2
		+ Mapper je Tabelle / View
		+ Generieren von Tabellen aus der Entity
		+ eigene Methoden im Mapper
		+ Verwendung von Scopes 

+ Vers. 0.6:
    + einbau Plugins und Filter in den Systemstart und in der Parameterkontrolle im Controller    	

+ Vers. 0.7:
	+ Übernahme Mailsystem 

+ Vers. 0.8
	+ Verwendung des DI Container Pimple für die Design Pattern
		+ Singleton
		+ Factory
		+ Prototype
		+ Observer
	+ Entwicklung Standard Model 
		+ Übergabe Werte Spot2
		+ Verwendung SPL Array Access   

+ Vers. 0.9:
    + Gestaltung von Beispielsseiten mit einem Bootstrap 3 Templat
    	+ Vorlage: SB2 Admin , Bootstrap

### zu erledigen:



+ Vers. 1.0:
	+ erstellen Login und Navigation

+ Vers. 1.1:
	+ auskoppeln einzelner Bausteine für die Verwendung auf einem Tablet **'App Programmierung'** 
