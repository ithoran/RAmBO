<?php

include_once 'prijava.php';

class listaPrijava {
    
    var $lista = array();
    
    public function dodaj(Prijava $prijava){
        $this->lista[] = $prijava;
    }
}
