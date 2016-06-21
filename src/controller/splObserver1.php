<?php

	namespace controller;

	use tools\frinkError;

	/**
	 * Test des Observer Pattern mit der SPL von PHP.
	 * + klassische Schreibweise
	 * + Verwendung von Traits
	 * + SplSubject interface
	 * + SplObserver
	 *
	 * @author Stephan Krauß
	 * @copyright Stephan Krauss
	 * @lisence Stephan Krauß
	 * @date 17.06.2016
	 * @package controller
	 */
	class splObserver1 extends main
	{
		/**
		 * erweitern Pimple um spezielle Model und Tools
		 */
		public function __construct($controllerName, $actionName)
		{
			// Vorbereitung des Pimple Container
			$models=[
				'basis'=>function($pimple) {
					return new \models\modelBasis($pimple);
				}
			];

			parent::__construct($controllerName, $actionName);

			parent::pimple($models);
		}

		/**
		 * Laden des Parent Template und Subtemplate des Baustein
		 */
		protected function template()
		{
			try{
				/** @var $session \models\session */
				$modelSession=\Flight::get('session');

				$outputTemplate=[
					'masterTemplate'=>'main.html',
					'templateSuperuser'=>'bla_superuser.html'
				];

				$config=\Flight::get('config');

				if($config['debugBlock']['debug']){
					$outputTemplate['debugBlock']=$this->setDebug($modelSession);
				}

				\Flight::view()->display($this->templateName, $outputTemplate);
			} catch(\Exception $e){
				throw $e;
			}
		}

		public function subjectObserver()
		{
			try{

				// Observer
				$modelObserver1=new \models\modelObserver1($this->pimple);
				$modelObserver1['wert1']='observer1';
				$modelObserver1['wert2']='observer1';

				$modelObserver2=new \models\modelObserver2($this->pimple);
				$modelObserver2['wert1']='observer2';
				$modelObserver2['wert2']='observer2';
				
				// Subject
				$modelSubject = new \models\modelSubject($this->pimple);
				$modelSubject['wert1'] = 'subject';
				$modelSubject['wert2'] = 'subject';

				// Observer hinzufügen
				$modelSubject->attach($modelObserver1);
				$modelSubject->attach($modelObserver2);

				$pimple = $this->pimple;
				$myCalc = $pimple['basis'];

				$modelSubject->notify();

				// Übergabe an die View
				$this->template();
			} // eigene Exception
			catch(\tools\frinkError $e){
				throw $e;
			} // Exception anderer Klassen
			catch(\Exception $e){
				throw $e;
			}
		}
	}