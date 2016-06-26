<?php

	namespace models;

	/**
	 * Observer Model mit SplObserver
	 *
	 * @author User
	 * @date 21.06.2016
	 * @file modelObserver1.php
	 * @package models
	 */
	class modelObserver1 extends \models\modelBasis1 implements \SplObserver
	{
		/**
		 * @param \SplSubject $subject
		 */
		public function update(\SplSubject $subject)
		{
			$data = $subject->getAllData();
			$this->setAllData($data)->control();
		}
	}
