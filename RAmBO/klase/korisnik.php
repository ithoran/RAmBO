<?php

class Korisnik{  
    var $username;
    var $password;
    var $email;
    var $drzava;
    var $admin;

    
    public function __construct($username, $password, $email, $drzava, $admin) {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->drzava = $drzava;
        $this->admin = $admin;
    }
}

