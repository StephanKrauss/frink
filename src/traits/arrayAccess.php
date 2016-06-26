<?php

	namespace traits;

	/**
	 * Methoden des Array Access Interface
	 *
	 * @author Stephan Krauss
	 * @date 21.06.2016
	 * @package traits
	 */

	trait arrayAccess
	{
		/**
		 * @param $offset
		 * @param $value
		 */
		public function offsetSet($offset, $value)
		{
			if(is_null($offset)){
				$this->data[]=$value;
			} else{
				$this->data[$offset]=$value;
			}
		}

		/**
		 * @param $offset
		 *
		 * @return bool
		 */
		public function offsetExists($offset)
		{
			return isset($this->data[$offset]);
		}

		/**
		 * @param $offset
		 */
		public function offsetUnset($offset)
		{
			unset($this->data[$offset]);
		}

		/**
		 * @param $offset
		 *
		 * @return null
		 */
		public function offsetGet($offset)
		{
			return isset($this->data[$offset]) ? $this->data[$offset] : null;
		}
	}