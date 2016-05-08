<?php
/**
* Bal Blub
*
* @author Stephan Krauß , 21.34.2016
* @copyright Stephan Krauss
*
* @subpackage controller | model | tool | trait
*/

namespace controller;

/**
 * darstellen der leeren Seite des Template
 *
 * @author Stephan.Krauss
 * @date 23.06.2015
 * @package Controller
 */

class exception extends main
{
    /**
     * Laden des Parent Template und Subtemplate des Baustein
     */
    public function index()
    {
        try{
            $output = array(
                'bla' => 'bla'
            );

            // Logger registriert Message
            $this->sendLoggerMessage('erweiterte Message');

            // Extension Typ 2
            throw new \tools\frinkError('Exception Typ 2:', 2);

            weiter1:
            $test = 123;

            // Exception Typ 3
            throw new \tools\frinkError('Exception Typ 3:', 3);

            exit();
        }
        catch(\Exception $e){

            // eigene Exception bei Fehler - Code 2
            if($e instanceof \tools\frinkError and $e->getCode() == 2){

                // Fehler registrieren
                $this->sendLoggerMessage('eigene Exception, Code 2', $this->sparrow, __FILE__);

                // Fehlerbehandlung mittels einer Methode der Klasse
                $this->fehlerbehandlungMethode($e);

                // Rücksprung auf Zeile nach dem Fehler und Arbeit fortsetzen
                goto weiter1;
            }
            else{
                // Fehlercode 3 und eigene - Exception / oder fremde - Exception
                throw $e;
            }
        }
    }

    /**
     * Fehlerbehandlung Typ 2
     *
     * @param \tools\frinkError $e
     */
    protected function fehlerbehandlungMethode(\tools\frinkError $e)
    {
        // Design Pattern
        $test = 123;



        return;
    }
}