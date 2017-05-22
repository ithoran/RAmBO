<?php

class Izgubljeno{  
    var $naziv;
    var $tip;
    var $mesto;
    var $datum;
    var $nagrada;
    var $korisnik;
    
    public function __construct($naziv, $tip, $mesto, $datum, $nagrada, $korisnik) {
        $this->naziv = $naziv;
        $this->tip = $tip;
        $this->mesto = $mesto;
        $this->datum = $datum;
        $this->nagrada = $nagrada;
        $this->korisnik = $korisnik;
    }
}

