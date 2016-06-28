<?php

	namespace models;

	/**
	 * Hund bellt und fletcht die Zähne
	 *
	 * @author Stephan Krauß
	 * @date 28.06.2016
	 * @file knurrenHund.php
	 * @package models
	 */
	class randalierenderHund implements \models\interfaceHundBellen
	{
		public function bellen()
		{
			return 'Hund bellt und fletcht die Zähne';
		}
	}
