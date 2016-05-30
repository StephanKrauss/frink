<?php
/**
 * allgemeiner ErrorController mit Fire Logger
 *
 * @package Controller
 * @date 21.04.2016
 * @author Stephan Krauß
 * @link http://firelogger.binaryage.com/
 */

namespace controller;

class error extends main
{
    protected $error = null;

    /**
     * Laden des Parent Template der Error Anzeige
     */
    public function index()
    {
        try {
            $config = \Flight::get('config');

            /** @var $session \models\session */
            $modelSession = \Flight::get('session');
            $completeSession = $modelSession->readCompleteSession();

            $error = array(
                'message' => $this->error->getMessage(),
                'code' => $this->error->getCode(),
                'file' => $this->error->getFile(),
                'line' => $this->error->getLine(),
                'trace' => $this->error->getTraceAsString(),
                'session' => json_encode($completeSession)
            );

            // Debug Modus anzeigen
            if($config['debugBlock']['debug'])
            {
                foreach($error as $key => $value){
                    echo $key.': '.nl2br($value).'<br>';
                }
            }
            // speichern in der Tabelle 'exception'
            else{
                /** @var $pdo \PDO */
                $pdo = \Flight::get('pdo');

                // here you have to trust your field names!
                $fields = array_keys($error);
                $values = array_values($error);

                $fieldListString = implode(',',$fields);

                $valueListString = '';
                for($i=0; $i < count($values); $i++){
                    $value = addslashes($values[$i]);
                    $valueListString .= "'".$value."',";
                }

                $valueListString = substr($valueListString, 0,-1);

                $sql = "insert into exception(".$fieldListString.") values(".$valueListString.")";
                $pdo->exec($sql);

                \Flight::redirect('/start/index');
            }



        }
        catch (\Exception $e) {
            throw $e;
        }
    }

    public function setError($e){
        $this->error = $e;

        return $this;
    }
}