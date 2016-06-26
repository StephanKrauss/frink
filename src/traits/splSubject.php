<?php

	namespace traits;

	/**
	 * Trait des SPL Subject
	 *
	 * @author Stephan Krauss
	 * @date 21.06.2016
	 * @package traits
	 */

	trait splSubject
	{
		/**
		 * @param \SplObserver $observer
		 */
		public function attach(\SplObserver $observer)
		{
			$this->observers[]=$observer;
		}

		/**
		 * @param \SplObserver $observer
		 */
		public function detach(\SplObserver $observer)
		{

			$key=array_search($observer, $this->observers, true);
			if($key){
				unset($this->observers[$key]);
			}
		}

		/**
		 * informiert die Observer
		 */
		public function notify()
		{
			foreach($this->observers as $value){
				$value->update($this);
			}
		}

	}