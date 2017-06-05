<?php

class Nadjeno{
    var $naziv;
    var $tip;
    var $mesto;
    var $datum;
    var $korisnik;
    var $opis;
    var $slika;
    var $lat;
    var $lng;
    
    public function __construct($naziv, $tip, $mesto, $datum, $korisnik, $opis, $slika, $lat, $lng) {
        $this->naziv = $naziv;
        $this->tip = $tip;
        $this->mesto = $mesto;
        $this->datum = $datum;
        $this->korisnik = $korisnik;
        $this->opis = $opis;
        $this->slika = $slika;
        $this->lat = $lat;
        $this->lng = $lng;
    }
}

