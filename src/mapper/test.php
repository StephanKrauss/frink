<?php
	
	namespace mapper;
	use Spot\Mapper;
	
	class test extends Mapper
	{
		// komplexe wiederkehrende Fragen

		public function erste($id)
		{
			return 	$this->where(['id' => [$id]]);
		}

		// Scopes
		public function scopes()
		{
			return [
				'zweite' => function ($query) {
					return 	$this->where(['id' => [2]]);
				},
				'dritte' => function ($query) {
					return 	$this->where(['id' => [3]]);
				}
			];
		}
	}
