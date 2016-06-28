<?php

	namespace models;

	/**
	 * bellen des Hundes
	 *
	 * @author Stephan Krauß
	 * @date 28.06.2016
	 * @file knurrenHund.php
	 * @package models
	 */
	class bellenderHund implements \models\interfaceHundBellen
	{
		public function bellen()
		{
			return 'Hund bellt';
		}
	}
