<?php

include_once 'nadjeno.php';

class ListaNadjenih{
    
    var $lista = array();
    
    public function dodaj(Nadjeno $nadjeno)
    {
        $this->lista[] = $nadjeno;
    }
}

