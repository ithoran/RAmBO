<?php

include_once 'Poruka.php';

class listaPoruka {
   var $lista = array();
    
    public function dodaj(Poruka $poruka){
        $this->lista[] = $poruka;
    }
}
