<?php

namespace models;

class basis
{
    protected $wert1;
    protected $wert2;

    /**
     * @return mixed
     */
    public function getWert1()
    {
        return $this->wert1;
    }

    /**
     * @param mixed $wert1
     * @return test1
     */
    public function setWert1($wert1)
    {
        $this->wert1 = $wert1;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWert2()
    {
        return $this->wert2;
    }

    /**
     * @param mixed $wert2
     * @return test1
     */
    public function setWert2($wert2)
    {
        $this->wert2 = $wert2;
        return $this;
    }
}