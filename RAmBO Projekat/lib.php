<?php

const db_host = "localhost";
const db_korisnicko_ime = "root";
const db_lozinka = "";
const db_ime_baze = "rambo";



function login($username, $password) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);

    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {

        $rezultat = $konekcija->query("SELECT * FROM korisnik WHERE USERNAME = '$username' and PASSWORD = '$password'");
        if ($rezultat) {
            $count = mysqli_num_rows($rezultat);
            $rezultat->close();
            $konekcija->close();
            return $count;
            
        } else if ($konekcija->errno) {
            print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
        } else {
            print ("Nepoznata greška pri izvrsenju upita");
        }
    }
}

function check_username($username) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);

    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {

        $rezultat = $konekcija->query("SELECT * FROM korisnik WHERE USERNAME = '$username'");
        if ($rezultat) {
            $count = mysqli_num_rows($rezultat);
            $rezultat->close();
            $konekcija->close();
            return $count;
            
        } else if ($konekcija->errno) {
            print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
        } else {
            print ("Nepoznata greška pri izvrsenju upita");
        }
    }
}

function register($username, $password, $email) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);
    
    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {
        $tekst_upita = "INSERT INTO korisnik (FCLAN, USERNAME, PASSWORD, EMAIL) VALUES (1,'$username', '$password', '$email')";
        $rezultat = $konekcija->query($tekst_upita);
        
        if ($rezultat) {

            $konekcija->close();
        }
        else{
            if ($konekcija->errno) {
                print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
            } else {
                print ("Nepoznata greška pri izvrsenju upita");
            }
        }
    }
}

function vrati_sve_izgubljene() {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);

    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {

        $rezultat = $konekcija->query("SELECT * FROM objavaizg ORDER BY DATUM_OBJAVE DESC");
        if ($rezultat) {
            $niz = new ListaIzgubljenih();
            
            while ($red = $rezultat->fetch_assoc()) {

                $korisnik_id = $red['KORISNIK_ID'];
                $korisnik_res = $konekcija->query("SELECT USERNAME AS USERNAME FROM korisnik WHERE ID = '$korisnik_id' ");
                if ($red2 = $korisnik_res->fetch_assoc()) {
                    $korisnik = $red2['USERNAME'];
                }
                $niz->dodaj(new Izgubljeno($red['NAZIV'], $red['TIP'], $red['MESTO'], $red['DATUM'], $red['NAGRADA'], $korisnik));
            }
            // zatvaranje objekta koji čuva rezultat
            $rezultat->close();
            // zatvaranje konekcije
            $konekcija->close();
            return $niz;
        } else if ($konekcija->errno) {
            // u slucaju greške pri izvršenju upita odštampati odgovarajucu poruku
            print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
        } else {
            // u slucaju greške pri izvršenju upita odštampati odgovarajucu poruku
            print ("Nepoznata greška pri izvrsenju upita");
        }
    }
}

function vrati_5_izgubljenih() {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);

    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {

        $rezultat = $konekcija->query("SELECT * FROM objavaizg ORDER BY DATUM_OBJAVE DESC LIMIT 5");
        if ($rezultat) {
            $niz = new ListaIzgubljenih();

            while ($red = $rezultat->fetch_assoc()) {

                $korisnik_id = $red['KORISNIK_ID'];
                $korisnik_res = $konekcija->query("SELECT USERNAME AS USERNAME FROM korisnik WHERE ID = '$korisnik_id' ");
                if ($red2 = $korisnik_res->fetch_assoc()) {
                    $korisnik = $red2['USERNAME'];
                }
                $niz->dodaj(new Izgubljeno($red['NAZIV'], $red['TIP'], $red['MESTO'], $red['DATUM'], $red['NAGRADA'], $korisnik));

            }
            // zatvaranje objekta koji čuva rezultat
            $rezultat->close();
            // zatvaranje konekcije
            $konekcija->close();
            return $niz;
        } else if ($konekcija->errno) {
            // u slucaju greške pri izvršenju upita odštampati odgovarajucu poruku
            print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
        } else {
            // u slucaju greške pri izvršenju upita odštampati odgovarajucu poruku
            print ("Nepoznata greška pri izvrsenju upita");
        }
    }
}

function dodajIzgubljno(Izgubljeno $izgubljeno) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);
    
    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {
         $korisnik_id_res = $konekcija->query("SELECT ID AS ID FROM korisnik WHERE USERNAME = '$izgubljeno->korisnik' ");
         $red = [];
         if ($red = $korisnik_id_res->fetch_assoc()) {
                $korisnik_id = $red['ID'];
            }
            
         $rezultat = $konekcija->query("INSERT INTO objavaizg (NAZIV, TIP,  MESTO, DATUM, DATUM_OBJAVE, NAGRADA, KORISNIK_ID) VALUES ('$izgubljeno->naziv', '$izgubljeno->tip', '$izgubljeno->mesto', "
                 . " '$izgubljeno->datum' , NOW(), '$izgubljeno->nagrada', $korisnik_id)");

        if ($rezultat) {

            $konekcija->close();
        }
        else{
            if ($konekcija->errno) {
                print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
            } else {
                print ("Nepoznata greška pri izvrsenju upita");
            }
        }
    }
}

function vrati_izgubljeno($naziv, $korisnik) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);

    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {
         $korisnik_id_res = $konekcija->query("SELECT ID AS ID FROM korisnik WHERE USERNAME = '$korisnik' ");
         $red = [];
         if ($red = $korisnik_id_res->fetch_assoc()) {
                $korisnik_id = $red['ID'];
            }
            
        $rezultat = $konekcija->query("SELECT * FROM objavaizg WHERE NAZIV = '$naziv' AND KORISNIK_ID = '$korisnik_id'");
        if ($rezultat) {   
            if ($red2 = $rezultat->fetch_assoc()) {
    
            $izgubljeno = new Izgubljeno($red2['NAZIV'], $red2['TIP'], $red2['MESTO'], $red2['DATUM'], $red2['NAGRADA'], $korisnik);
            }
            // zatvaranje objekta koji čuva rezultat
            $rezultat->close();
            // zatvaranje konekcije
            $konekcija->close();
            return $izgubljeno;
        } else if ($konekcija->errno) {
            // u slucaju greške pri izvršenju upita odštampati odgovarajucu poruku
            print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
        } else {
            // u slucaju greške pri izvršenju upita odštampati odgovarajucu poruku
            print ("Nepoznata greška pri izvrsenju upita");
        }
    }
}