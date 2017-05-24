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
            $res = new stdClass();
            $res->count = mysqli_num_rows($rezultat);
            if ($red = $rezultat->fetch_assoc()) {
                $res->f_admin = $red['FADMINISTRATOR'];
            }
            $rezultat->close();
            $konekcija->close();
            return $res;
            
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

function register($username, $password, $email, $drzava) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);
    
    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {
        
        $drzava_res = $konekcija->query("SELECT name AS name FROM countries WHERE code = '$drzava' ");

         if ($red = $drzava_res->fetch_assoc()) {
                $drzava_naziv = $red['name'];
            }
            
        $rezultat = $konekcija->query("INSERT INTO korisnik (FCLAN, USERNAME, PASSWORD, EMAIL, DRZAVA) VALUES (1,'$username', '$password', '$email', '$drzava_naziv')");
        
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

function izmeni_korisnika($stari_username, $username, $password, $email) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);
    
    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {
                
        $tekst_upita = "UPDATE korisnik SET USERNAME = '$username', PASSWORD = '$password',"
                        . " EMAIL = '$email' WHERE USERNAME = '$stari_username' ";
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

        $rezultat = $konekcija->query("SELECT * FROM objavaizg OI, korisnik K WHERE OI.KORISNIK_ID = K.ID ORDER BY DATUM_OBJAVE DESC");
        if ($rezultat) {
            $niz = new ListaIzgubljenih();
            
            while ($red = $rezultat->fetch_assoc()) {
                
                $niz->dodaj(new Izgubljeno($red['NAZIV'], $red['TIP'], $red['MESTO'], $red['DATUM'], $red['NAGRADA'], $red['USERNAME']));
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

function vrati_n_izgubljenih($broj) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);

    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {

        $rezultat = $konekcija->query("SELECT * FROM objavaizg OI, korisnik K WHERE OI.KORISNIK_ID = K.ID ORDER BY DATUM_OBJAVE DESC LIMIT $broj");
        if ($rezultat) {
            $niz = new ListaIzgubljenih();

            while ($red = $rezultat->fetch_assoc()) {

                $niz->dodaj(new Izgubljeno($red['NAZIV'], $red['TIP'], $red['MESTO'], $red['DATUM'], $red['NAGRADA'], $red['USERNAME']));

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

        $rezultat = $konekcija->query("SELECT * FROM objavaizg OI, korisnik K WHERE OI.KORISNIK_ID = K.ID AND  OI.NAZIV = '$naziv' AND K.USERNAME = '$korisnik'");
        
        if ($rezultat) {   
            if ($red = $rezultat->fetch_assoc()) {
    
            $izgubljeno = new Izgubljeno($red['NAZIV'], $red['TIP'], $red['MESTO'], $red['DATUM'], $red['NAGRADA'], $korisnik);
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

function vrati_sve_izgubljene_filter($naziv, $tip, $lokacija, $datum_od, $datum_do) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);

    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {
   
        $rezultat = $konekcija->query("SELECT * "
                                    . "FROM objavaizg "
                                    . "WHERE NAZIV LIKE '%$naziv%' AND TIP LIKE '%$tip%' AND MESTO LIKE '%$lokacija%' "
                                    . "ORDER BY DATUM_OBJAVE DESC");
            
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

function vrati_korisnika($username) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);

    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {

        $rezultat = $konekcija->query("SELECT * FROM korisnik WHERE USERNAME = '$username' ");
        if ($rezultat) {   
            if ($red = $rezultat->fetch_assoc()) {
                
            $korisnik = new Korisnik($red['USERNAME'], $red['PASSWORD'], $red['EMAIL'], $red['DRZAVA'], $red['FADMINISTRATOR']);
            }
            // zatvaranje objekta koji čuva rezultat
            $rezultat->close();
            // zatvaranje konekcije
            $konekcija->close();
            return $korisnik;
        } else if ($konekcija->errno) {
            // u slucaju greške pri izvršenju upita odštampati odgovarajucu poruku
            print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
        } else {
            // u slucaju greške pri izvršenju upita odštampati odgovarajucu poruku
            print ("Nepoznata greška pri izvrsenju upita");
        }
    }
}

function vrati_sve_korisnike() {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);

    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {

        $rezultat = $konekcija->query("SELECT * FROM korisnik WHERE FCLAN = 1");
        if ($rezultat) {
            $niz = new ListaKorisnika();
            
            while ($red = $rezultat->fetch_assoc()) {
                
                $niz->dodaj(new Korisnik($red['USERNAME'], $red['PASSWORD'], $red['EMAIL'], $red['DRZAVA'], $red['FADMINISTRATOR']));
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

function obrisi_korisnika($username) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);
    
    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {

        $tekst_upita = "DELETE FROM korisnik WHERE USERNAME = '$username'";
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

function obrisi_izgubljeno($naziv, $korisnik) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);
    
    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {

        $tekst_upita = "DELETE OI FROM objavaizg OI, korisnik K  WHERE USERNAME = '$korisnik' AND NAZIV = '$naziv'";
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

function vrati_sve_izgubljene_korisnik($korisnik) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);

    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {
            $rezultat = $konekcija->query("SELECT * FROM objavaizg OI, korisnik K WHERE OI.KORISNIK_ID = K.ID AND K.USERNAME = '$korisnik'");
        if ($rezultat) {
            $niz = new ListaIzgubljenih();
            
            while ($red = $rezultat->fetch_assoc()) {

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