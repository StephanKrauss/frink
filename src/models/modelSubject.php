<?php

	namespace models;

	use \traits\splSubject;

	/**
	 * Subject
	 *
	 * @author Stephan Krauss
	 * @date 21.06.2016
	 * @file modelBasis1.php
	 * @package models
	 */
	class modelSubject extends \models\modelBasis implements \SplSubject
	{
		use splSubject;

		protected $observers=[];

	} // end class
