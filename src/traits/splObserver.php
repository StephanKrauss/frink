<?php

	namespace traits;

	/**
	 * Trait des SPL Observer
	 *
	 * @author Stephan Krauss
	 * @date 21.06.2016
	 * @package traits
	 */

	trait splObserver
	{
		public function update(\SplSubject $subject)
		{
			$data=$subject->getAllData();
			$this->setAllData($data);
			$this->notify();
		}

	}