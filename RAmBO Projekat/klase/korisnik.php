<?php

class Korisnik{  
    var $username;
    var $password;
    var $email;

    
    public function __construct($username, $password, $email) {
        $this->username = $username;
        $this->password = $password;
        $this->email = $email;
    }
}

