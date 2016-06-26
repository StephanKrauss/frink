<?php

namespace traits;

/**
* zentrale Methoden für den Mapper der Tabellen
*
* @author Stephan Krauß
* @copyright Stephan Krauss
* @lisence Stephan Krauß
* @date 15.06.2016
*
* @package traits
*/


trait MapperData
{
    /**
     * findet einen Datensatz in der Tabelle 'users'
     *
     * @param $primary
     * @param \models\ModelData $model
     * @return bool|\models\ModelData
     */
    public function findData($primary,\models\ModelData $model)
    {
        $entity = $this->get($primary);

        if($entity){
            $row = $entity->toArray();

            foreach($row as $key => $value){
                $model->offsetSet($key, $value);
            }

            return $model;
        }
        else
            return false;
    }

    /**
     * Update oder Insert der Daten eines Model in eine Tabelle
     *
     * @param \models\ModelData $model
     */
    public function setData(\models\ModelData $model)
    {
        $data = $model->getAllData();

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

    /**
     * Definierte Felder Doctrine
     *
     * @return array
     */
    public function getFieldTypes()
    {
        return $fieldTypes = \Doctrine\DBAL\Types\Type::getTypesMap();
    }
}