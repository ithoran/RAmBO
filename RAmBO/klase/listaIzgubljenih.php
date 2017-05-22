<?php
include_once 'izgubljeno.php';

class ListaIzgubljenih{
    
    var $lista = array();
    
    public function dodaj(Izgubljeno $izgubljeno)
    {
        $this->lista[] = $izgubljeno;
    }
}

