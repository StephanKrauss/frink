<?php

	namespace models;

	/**
	 * Basisklasse mit Interface ArrayAccess
	 *
	 * @author Stephan Krauss
	 * @date 21.06.2016
	 * @file modelBasis1.php
	 * @package models
	 */
	class modelBasis1 extends \models\ModelData
	{
		/**
		 * Methode für das Observer Pattern
		 *
		 * @return ModelData
		 */
		public function notify()
		{
			return $this;
		}

	} // end class
