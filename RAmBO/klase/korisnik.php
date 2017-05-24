<?php

class Korisnik{  
    var $username;
    var $password;
    var $email;
    var $drzava;
    var $f_admin;

    
    public function __construct($username, $password, $email, $drzava, $admin) {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
        $this->drzava = $drzava;
        $this->f_admin = $admin;
    }
}

