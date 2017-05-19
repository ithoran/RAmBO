<?php

class Nadjeno{
    
    var $naziv;
    var $tip;
    var $mesto;
    var $datum;
    
    public function __construct($naziv, $tip, $mesto, $datum) {
        $this->naziv = $naziv;
        $this->tip = $tip;
        $this->mesto = $mesto;
        $this->datum = $datum;
    }
}

