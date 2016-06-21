<?php

	namespace controller;

	use tools\frinkError;

	/**
	 * Test des Observer Pattern mit der SPL von PHP.
	 *
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
				'model'=>function() {
					return new model($this->params);
				},
				'myCalc'=>function() {
					return new myCalc(10);
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

				$modelBasis1 = new \models\modelBasis1($this->pimple);
				$modelBasis1['wert1'] = 'wert1';
				$modelBasis1['wert2'] = 123;
				$modelBasis1[] = 'blub';

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