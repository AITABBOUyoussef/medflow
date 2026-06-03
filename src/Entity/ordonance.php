<?php

use Dom\Text;

class ordonance {
    private Text $odrdonance;

    public function __construct($odrdonance)
    {
       $this->odrdonance = $odrdonance;
    }

    public function getOrdonance():text{
        return $this->odrdonance;
    }
    public function setOrdonance($odrdonance){
        return $this->odrdonance;
    }
}