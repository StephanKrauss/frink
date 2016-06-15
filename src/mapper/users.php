<?php
	
	namespace mapper;
	use Spot\Mapper;

	/**
	* Mapper der Tabelle 'test'
	*
	* @author Stephan Krauß
	* @copyright Stephan Krauss
	* @lisence Stephan Krauß
	* @date 15.06.2016
	*
	* @package mapper
	*/
	
	class users extends Mapper
	{
		// komplexe wiederkehrende Fragen

		/**
		 * Testfunktion für komplexe Abfragen
		 *
		 * @param $id
		 * @return \Spot\Query
		 */
		public function erste($id)
		{
			return 	$this->where(['id' => [$id]]);
		}

		/**
		 * findet einen Datensatz in der Tabelle 'users'
		 *
		 * @param $primary
		 * @param \models\dataModel $model
		 * @return \models\dataModel
		 */
		public function find($primary,\models\ModelData $model)
		{
			$row = $this->get($primary)->toArray();

			foreach($row as $key => $value){
				$model->offsetSet($key, $value);
			}

			return $model;
		}

		/**
		 * Update oder Insert der Daten eines Model in eine Tabelle
		 *
		 * @param \models\ModelData $model
		 */
		public function set(\models\ModelData $model)
		{
			$data = $model->data;

			$entity = $this->first(['id' => $data['id']]);

			if($entity){
				foreach ($data as $key => $value){
					$entity->$key = $value;
				}
			}
			else{
				$entity = $this->build($data);
			}

			$this->save($entity);

			return;
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
