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
	class modelBasis extends \models\ModelData
	{
		/**
		 * Test Funktion foo()
		 *
		 * @return string
		 */
		public function foo()
		{
			return 'foo';
		}
		

	} // end class
