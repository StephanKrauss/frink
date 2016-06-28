<?php

	namespace models;

	/**
	 * Basisklasse des Hundes
	 *
	 * + Die Strategie des Hundes wird festgelegt
	 *
	 * @author Stephan Krauß
	 * @date 28.06.2016
	 * @file hund.php
	 * @package models
	 */

	class hund extends \models\ModelData
	{

		/**
		 * festlegen der Reaktion des Hundes entsprechend des Abstandes der Katze zum Zaun
		 */
		public function reaktion()
		{
			if($this->data['abstandZumGartenzaun'] == 0)
				$this->data['reaktionHund'] = $this->pimple['knurrenderHund']->bellen();
			elseif( ($this->data['abstandZumGartenzaun'] > 0) and ($this->data['abstandZumGartenzaun'] < 10) )
				$this->data['reaktionHund'] = $this->pimple['bellenderHund']->bellen();
			else
				$this->data['reaktionHund'] = $this->pimple['randalierenderHund']->bellen();
		}

	}
