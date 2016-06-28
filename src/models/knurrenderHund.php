<?php

	namespace models;

	/**
	 * knurren des Hundes
	 *
	 * @author Stephan Krauß
	 * @date 28.06.2016
	 * @file knurrenHund.php
	 * @package models
	 */
	class knurrenderHund implements \models\interfaceHundBellen
	{
		public function bellen()
		{
			return 'Hund knurrt';
		}
	}
