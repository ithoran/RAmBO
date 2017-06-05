<?php

class Izgubljeno{  
    var $naziv;
    var $tip;
    var $mesto;
    var $datum;
    var $nagrada;
    var $opis;
    var $korisnik;
    var $slika;
    var $lat;
    var $lng;
    
    public function __construct($naziv, $tip, $mesto, $datum, $nagrada, $opis, $korisnik, $slika, $lat, $lng) {
        $this->naziv = $naziv;
        $this->tip = $tip;
        $this->mesto = $mesto;
        $this->datum = $datum;
        $this->nagrada = $nagrada;
        $this->opis = $opis;
        $this->korisnik = $korisnik;
        $this->slika = $slika;
        $this->lat = $lat;
        $this->lng = $lng;
    }
}

