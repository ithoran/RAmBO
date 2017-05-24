<?php
include_once 'korisnik.php';

class ListaKorisnika{
    
    var $lista = array();
    
    public function dodaj(Korisnik $korisnik)
    {
        $this->lista[] = $korisnik;
    }
}
