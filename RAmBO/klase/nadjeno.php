<?php

class Nadjeno{
    var $naziv;
    var $tip;
    var $mesto;
    var $datum;
    var $korisnik;
    
    public function __construct($naziv, $tip, $mesto, $datum, $korisnik) {
        $this->naziv = $naziv;
        $this->tip = $tip;
        $this->mesto = $mesto;
        $this->datum = $datum;
        $this->korisnik = $korisnik;
    }
}

