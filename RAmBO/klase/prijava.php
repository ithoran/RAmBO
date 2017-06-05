<?php

class Prijava {
    
    var $idP;
    var $idR;
    var $idO;
    var $tekst;
    var $id;
    
    public function __construct($idp, $idr, $ido, $tekst, $id) {
        $this->idP = $idp;
        $this->idR = $idr;
        $this->idO = $ido;
        $this->tekst = $tekst;
        $this->id = $id;
    }
}


