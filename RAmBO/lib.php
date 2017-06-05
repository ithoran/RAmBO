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
        } else {
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
        } else {
            if ($konekcija->errno) {
                print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
            } else {
                print ("Nepoznata greška pri izvrsenju upita");
            }
        }
    }
}

function vrati_sve_objave($f_izgubljeno) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);

    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {

        $rezultat = $konekcija->query("SELECT * FROM objava O, korisnik K WHERE O.KORISNIK_ID = K.ID AND O.FIZGUBLJENO = '$f_izgubljeno' ORDER BY DATUM_OBJAVE DESC");
        if ($rezultat) {
            if ($f_izgubljeno) {
                $niz = new ListaIzgubljenih();
            } else {
                $niz = new ListaNadjenih();
            }
            while ($red = $rezultat->fetch_assoc()) {

                if ($f_izgubljeno) {
                    $niz->dodaj(new Izgubljeno($red['NAZIV'], $red['TIP'], $red['MESTO'], $red['DATUM'], $red['NAGRADA'], $red['OPIS'], $red['USERNAME'], $red['SLIKA'], $red['LAT'], $red['LNG']));
                } else {
                    $niz->dodaj(new Nadjeno($red['NAZIV'], $red['TIP'], $red['MESTO'], $red['DATUM'], $red['USERNAME'], $red['OPIS'], $red['SLIKA'], $red['LAT'], $red['LNG']));
                }
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

function vrati_n_objava($broj, $f_izgubljeno) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);

    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {

        $rezultat = $konekcija->query("SELECT * FROM objava O, korisnik K WHERE O.KORISNIK_ID = K.ID AND O.FIZGUBLJENO = '$f_izgubljeno' ORDER BY DATUM_OBJAVE DESC LIMIT $broj");
        if ($rezultat) {
            if ($f_izgubljeno) {
                $niz = new ListaIzgubljenih();
            } else {
                $niz = new ListaNadjenih();
            }

            while ($red = $rezultat->fetch_assoc()) {

                if ($f_izgubljeno) {
                    $niz->dodaj(new Izgubljeno($red['NAZIV'], $red['TIP'], $red['MESTO'], $red['DATUM'], $red['NAGRADA'], $red['OPIS'], $red['USERNAME'], $red['SLIKA'], $red['LAT'], $red['LNG']));
                } else {
                    $niz->dodaj(new Nadjeno($red['NAZIV'], $red['TIP'], $red['MESTO'], $red['DATUM'], $red['USERNAME'], $red['OPIS'], $red['SLIKA'], $red['LAT'], $red['LNG']));
                }
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

function dodaj_izgubljeno(Izgubljeno $izgubljeno) {

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

        $rezultat = $konekcija->query("INSERT INTO objava (NAZIV, TIP,  MESTO, DATUM, DATUM_OBJAVE, NAGRADA, OPIS, FIZGUBLJENO, KORISNIK_ID, SLIKA, LAT, LNG) VALUES ('$izgubljeno->naziv', '$izgubljeno->tip', '$izgubljeno->mesto', "
                . " '$izgubljeno->datum' , NOW(), '$izgubljeno->nagrada', '$izgubljeno->opis', 1, $korisnik_id, '$izgubljeno->slika', '$izgubljeno->lat', '$izgubljeno->lng')");

        if ($rezultat) {

            $konekcija->close();
        } else {
            if ($konekcija->errno) {
                print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
            } else {
                print ("Nepoznata greška pri izvrsenju upita");
            }
        }
    }
}

function dodaj_nadjeno(Nadjeno $nadjeno) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);

    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {
        $korisnik_id_res = $konekcija->query("SELECT ID AS ID FROM korisnik WHERE USERNAME = '$nadjeno->korisnik' ");
        $red = [];
        if ($red = $korisnik_id_res->fetch_assoc()) {
            $korisnik_id = $red['ID'];
        }

        $rezultat = $konekcija->query("INSERT INTO objava (NAZIV, TIP,  MESTO, DATUM, DATUM_OBJAVE, OPIS, FNADJENO, KORISNIK_ID, SLIKA, LAT, LNG) VALUES ('$nadjeno->naziv', '$nadjeno->tip', '$nadjeno->mesto', "
                . " '$nadjeno->datum' , NOW(), '$nadjeno->opis', 1, $korisnik_id, '$nadjeno->slika', '$nadjeno->lat', '$nadjeno->lng')");

        if ($rezultat) {

            $konekcija->close();
        } else {
            if ($konekcija->errno) {
                print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
            } else {
                print ("Nepoznata greška pri izvrsenju upita");
            }
        }
    }
}

function izmeni_izgubljeno($izgubljeno_za_izmenu, $izgubljeno) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);

    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {

//        $tekst_upita = "UPDATE objava SET NAZIV = '$izgubljeno->naziv', TIP = '$izgubljeno->tip',  MESTO = '$izgubljeno->mesto', DATUM = '$izgubljeno->datum', NAGRADA = '$izgubljeno->nagrada'";
        $tekst_upita = "UPDATE objava O "
                . "JOIN korisnik K ON O.KORISNIK_ID = K.ID "
                . "SET O.NAZIV = '$izgubljeno->naziv', O.TIP = '$izgubljeno->tip',  O.MESTO = '$izgubljeno->mesto', O.DATUM = '$izgubljeno->datum', O.NAGRADA = '$izgubljeno->nagrada'"
                . "WHERE NAZIV = '$izgubljeno_za_izmenu->naziv' AND USERNAME = '$izgubljeno_za_izmenu->korisnik' AND FIZGUBLJENO  = 1";
        $rezultat = $konekcija->query($tekst_upita);

        if ($rezultat) {

            $konekcija->close();
        } else {
            if ($konekcija->errno) {
                print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
            } else {
                print ("Nepoznata greška pri izvrsenju upita");
            }
        }
    }
}

function izmeni_nadjeno($nadjeno_za_izmenu, $nadjeno) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);

    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {

        $tekst_upita = "UPDATE objava O "
                . "JOIN korisnik K ON O.KORISNIK_ID = K.ID "
                . "SET O.NAZIV = '$nadjeno->naziv', O.TIP = '$nadjeno->tip',  O.MESTO = '$nadjeno->mesto', O.DATUM = '$nadjeno->datum'"
                . "WHERE NAZIV = '$nadjeno_za_izmenu->naziv' AND USERNAME = '$nadjeno_za_izmenu->korisnik' AND FNADJENO = 1";
        $rezultat = $konekcija->query($tekst_upita);

        if ($rezultat) {

            $konekcija->close();
        } else {
            if ($konekcija->errno) {
                print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
            } else {
                print ("Nepoznata greška pri izvrsenju upita");
            }
        }
    }
}

function vrati_objavu($naziv, $korisnik, $f_izgubljeno) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);

    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {

        $rezultat = $konekcija->query("SELECT * FROM objava O, korisnik K WHERE O.KORISNIK_ID = K.ID AND O.FIZGUBLJENO = '$f_izgubljeno' AND O.NAZIV = '$naziv' AND K.USERNAME = '$korisnik'");

        if ($rezultat) {
            if ($red = $rezultat->fetch_assoc()) {
                if ($f_izgubljeno) {
                    $to_return = new Izgubljeno($red['NAZIV'], $red['TIP'], $red['MESTO'], $red['DATUM'], $red['NAGRADA'], $red['OPIS'], $korisnik, $red['SLIKA'], $red['LAT'], $red['LNG']);
                } else {
                    $to_return = new Nadjeno($red['NAZIV'], $red['TIP'], $red['MESTO'], $red['DATUM'], $red['USERNAME'], $red['OPIS'], $red['SLIKA'], $red['LAT'], $red['LNG']);
                }
            }
            // zatvaranje objekta koji čuva rezultat
            $rezultat->close();
            // zatvaranje konekcije
            $konekcija->close();
            return $to_return;
        } else if ($konekcija->errno) {
            // u slucaju greške pri izvršenju upita odštampati odgovarajucu poruku
            print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
        } else {
            // u slucaju greške pri izvršenju upita odštampati odgovarajucu poruku
            print ("Nepoznata greška pri izvrsenju upita");
        }
    }
}

function vrati_sve_objave_filter($naziv, $tip, $lokacija, $datum_od, $f_izgubljeno) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);

    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {

        $rezultat = $konekcija->query("SELECT * "
                . "FROM objava "
                . "WHERE NAZIV LIKE '%$naziv%' AND TIP LIKE '%$tip%' AND MESTO LIKE '%$lokacija%' AND FIZGUBLJENO = '$f_izgubljeno'"
                . "AND DATUM > '$datum_od' "
                . "ORDER BY DATUM_OBJAVE DESC");

        if ($rezultat) {
            if ($f_izgubljeno) {
                $niz = new ListaIzgubljenih();
            } else {
                $niz = new ListaNadjenih();
            }

            while ($red = $rezultat->fetch_assoc()) {

                $korisnik_id = $red['KORISNIK_ID'];
                $korisnik_res = $konekcija->query("SELECT USERNAME AS USERNAME FROM korisnik WHERE ID = '$korisnik_id' ");
                if ($red2 = $korisnik_res->fetch_assoc()) {
                    $korisnik = $red2['USERNAME'];
                }
                if ($f_izgubljeno) {
                    $niz->dodaj(new Izgubljeno($red['NAZIV'], $red['TIP'], $red['MESTO'], $red['DATUM'], $red['NAGRADA'], $red['OPIS'], $korisnik), $red['SLIKA'], $red['LAT'], $red['LNG']);
                } else {
                    $niz->dodaj(new Nadjeno($red['NAZIV'], $red['TIP'], $red['MESTO'], $red['DATUM'], $korisnik), $red['OPIS'], $red['SLIKA'], $red['LAT'], $red['LNG']);
                }
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
        } else {
            if ($konekcija->errno) {
                print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
            } else {
                print ("Nepoznata greška pri izvrsenju upita");
            }
        }
    }
}

function obrisi_objavu($naziv, $korisnik) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);

    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {

        $tekst_upita = "DELETE O FROM objava O, korisnik K  WHERE USERNAME = '$korisnik' AND NAZIV = '$naziv'";
        $rezultat = $konekcija->query($tekst_upita);

        if ($rezultat) {

            $konekcija->close();
        } else {
            if ($konekcija->errno) {
                print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
            } else {
                print ("Nepoznata greška pri izvrsenju upita");
            }
        }
    }
}

function vrati_sve_objave_korisnik($korisnik, $f_izgubljeno) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);

    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {
        $rezultat = $konekcija->query("SELECT * FROM objava O, korisnik K WHERE O.KORISNIK_ID = K.ID AND O.FIZGUBLJENO = '$f_izgubljeno' AND K.USERNAME = '$korisnik'");
        if ($rezultat) {
            if ($f_izgubljeno) {
                $niz = new ListaIzgubljenih();
            } else {
                $niz = new ListaNadjenih();
            }

            while ($red = $rezultat->fetch_assoc()) {

                if ($f_izgubljeno) {
                    $niz->dodaj(new Izgubljeno($red['NAZIV'], $red['TIP'], $red['MESTO'], $red['DATUM'], $red['NAGRADA'], $red['OPIS'], $red['USERNAME'], $red['SLIKA'], $red['LAT'], $red['LNG']));
                } else {
                    $niz->dodaj(new Nadjeno($red['NAZIV'], $red['TIP'], $red['MESTO'], $red['DATUM'], $red['USERNAME'], $red['OPIS'], $red['SLIKA'], $red['LAT'], $red['LNG']));
                }
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

function report_korisnika($usernameP, $usernameR, $imeObjave, $tekst) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);

    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {
        $korisnikP = $konekcija->query("SELECT ID AS ID FROM korisnik WHERE USERNAME = '$usernameP' ");
        $red1 = [];
        if ($red1 = $korisnikP->fetch_assoc()) {
            $korisnik_idP = $red1['ID'];
        }

        $red2 = [];
        $korisnikR = $konekcija->query("SELECT ID AS ID FROM korisnik WHERE USERNAME = '$usernameR' ");
        if ($red2 = $korisnikR->fetch_assoc()) {
            $korisnik_idR = $red2['ID'];
        }
        $red3 = [];
        $objava = $konekcija->query("SELECT O.ID AS ID FROM objava O, korisnik K WHERE K.ID = O.KORISNIK_ID AND K.USERNAME = '$usernameR' AND O.NAZIV= '$imeObjave' ");
        if ($red3 = $objava->fetch_assoc()) {
            $objavaID = $red3['ID'];
        }

        $rezultat = $konekcija->query("INSERT INTO prijava (IDP, IDR, IDO, TEKST) VALUES ('$korisnik_idP', '$korisnik_idR', '$objavaID', '$tekst') ");

        if ($rezultat) {

            $konekcija->close();
        } else {
            if ($konekcija->errno) {
                print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
            } else {
                print ("Nepoznata greška pri izvrsenju upita");
            }
        }
    }
}

function proveri_tip_objave($username, $imeObjave) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);

    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {
        $red = [];
        $rezultat = $konekcija->query("SELECT * FROM objava O, korisnik K WHERE O.KORISNIK_ID = K.ID AND K.USERNAME = '$username' AND O.NAZIV= '$imeObjave' ");
        if ($red = $rezultat->fetch_assoc()) {
            $tip = $red['FIZGUBLJENO'];
        }

        if ($rezultat) {

            $konekcija->close();
            return $tip;
        } else {
            if ($konekcija->errno) {
                print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
            } else {
                print ("Nepoznata greška pri izvrsenju upita");
            }
        }
    }
}

function vrati_sve_prijave() {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);

    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {

        $rezultat = $konekcija->query("SELECT * FROM prijava P");
        if ($rezultat) {
            $niz = new listaPrijava();

            while ($red = $rezultat->fetch_assoc()) {
                $niz->dodaj(new Prijava($red['IDP'], $red['IDR'], $red['IDO'], $red['TEKST'], $red['ID']));
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

function vrati_ime_korisnika($id) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);

    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {

        $rezultat = $konekcija->query("SELECT * FROM korisnik WHERE ID = '$id' ");
        if ($rezultat) {
            if ($red = $rezultat->fetch_assoc()) {

                $korisnik = $red['USERNAME'];
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

function vrati_naziv_objave($id) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);

    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {

        $rezultat = $konekcija->query("SELECT * FROM objava WHERE ID = '$id' ");
        if ($rezultat) {
            if ($red = $rezultat->fetch_assoc()) {

                $korisnik = $red['NAZIV'];
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

function obrisi_prijavu($id) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);

    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {

        $tekst_upita = "DELETE FROM prijava WHERE ID = '$id'";
        $rezultat = $konekcija->query($tekst_upita);

        if ($rezultat) {

            $konekcija->close();
        } else {
            if ($konekcija->errno) {
                print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
            } else {
                print ("Nepoznata greška pri izvrsenju upita");
            }
        }
    }
}

function posalji_poruku($sender, $receiver, $imeObjave, $content) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);

    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {
        $snd = $konekcija->query("SELECT ID AS ID FROM korisnik WHERE USERNAME = '$sender' ");
        $red1 = [];
        if ($red1 = $snd->fetch_assoc()) {
            $sender_id = $red1['ID'];
        }

        $red2 = [];
        $rcv = $konekcija->query("SELECT ID AS ID FROM korisnik WHERE USERNAME = '$receiver' ");
        if ($red2 = $rcv->fetch_assoc()) {
            $receiver_id = $red2['ID'];
        }
        $red3 = [];
        $objava = $konekcija->query("SELECT O.ID AS ID FROM objava O, korisnik K WHERE K.ID = O.KORISNIK_ID AND K.USERNAME = '$receiver' AND O.NAZIV= '$imeObjave' ");
        if ($red3 = $objava->fetch_assoc()) {
            $objava_id = $red3['ID'];
        }

        $rezultat = $konekcija->query("INSERT INTO poruka (CONTENT,OBJAVA_ID,SENDER_ID,RECEIVER_ID,VREME,READ) VALUES ('$content','$objava_id','$sender_id','$receiver_id',NOW(),0) ");

        if ($rezultat) {

            $konekcija->close();
        } else {
            if ($konekcija->errno) {
                print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
            } else {
                print ("Nepoznata greška pri izvrsenju upita");
            }
        }
    }
}

function vrati_sve_primljene_poruke($korisnik_ime) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);

    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {

        $kor_id = $konekcija->query("SELECT ID FROM korisnik K where K.USERNAME='$korisnik_ime'");


        $rezultat = $konekcija->query("SELECT * FROM poruka P where P.RECEIVER_ID='$kor_id'");
        if ($rezultat) {
            $niz = new listaPoruka();

            while ($red = $rezultat->fetch_assoc()) {
                $niz->dodaj(new Poruka($red['ID'], $red['CONTENT'], $red['VREME'], $red['READ'], $red['OBJAVA_ID'], $red['SENDER_ID'], $red['RECEIVER_ID']));
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

function vrati_sve_poslate_poruke($korisnik_ime) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);

    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {

        $kor_id = $konekcija->query("SELECT ID FROM korisnik K where K.USERNAME='$korisnik_ime'");


        $rezultat = $konekcija->query("SELECT * FROM poruka P where P.SENDER_ID='$kor_id'");
        if ($rezultat) {
            $niz = new listaPoruka();

            while ($red = $rezultat->fetch_assoc()) {
                $niz->dodaj(new Poruka($red['ID'], $red['CONTENT'], $red['VREME'], $red['READ'], $red['OBJAVA_ID'], $red['SENDER_ID'], $red['RECEIVER_ID']));
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

function vrati_poruku($id_poruke) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);

    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {

        $rezultat = $konekcija->query("SELECT * FROM poruka WHERE ID = '$id_poruke' ");
        if ($rezultat) {
            if ($red = $rezultat->fetch_assoc()) {

                $poruka = new Poruka($red['ID'], $red['CONTENT'], $red['VREME'], $red['READ'], $red['OBJAVA_ID'], $red['SENDER_ID'], $red['RECEIVER_ID']);
            }
            // zatvaranje objekta koji čuva rezultat
            $rezultat->close();
            // zatvaranje konekcije
            $konekcija->close();
            return $poruka;
        } else if ($konekcija->errno) {
            // u slucaju greške pri izvršenju upita odštampati odgovarajucu poruku
            print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
        } else {
            // u slucaju greške pri izvršenju upita odštampati odgovarajucu poruku
            print ("Nepoznata greška pri izvrsenju upita");
        }
    }
}


function obrisi_poruku($id) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);

    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {

        $tekst_upita = "DELETE FROM poruka WHERE ID = '$id'";
        $rezultat = $konekcija->query($tekst_upita);

        if ($rezultat) {

            $konekcija->close();
        } else {
            if ($konekcija->errno) {
                print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
            } else {
                print ("Nepoznata greška pri izvrsenju upita");
            }
        }
    }
}

function proveri_poruke($korisnik_ime) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);

    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {
        //ovo se zove na index.php dok je korisnik ulogovan da bi proverio koliko ima poruke

        $kor_id = $konekcija->query("SELECT ID FROM korisnik K where K.USERNAME='$korisnik_ime'");

        $broj = $konekcija->query("SELECT COUNT(*) FROM poruka P WHERE P.RECEIVER_ID='$kor_id' AND P.READ=0 ");

        return $broj;

        if ($konekcija->errno) {
            print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
        } else {
            print ("Nepoznata greška pri izvrsenju upita");
        }
    }
}

function oznaci_kao_procitano($korisnik_ime) {

    $konekcija = new mysqli(db_host, db_korisnicko_ime, db_lozinka, db_ime_baze);

    $konekcija->set_charset('utf8');
    if ($konekcija->connect_errno) {

        print ("Greška pri povezivanju sa bazom podataka ($konekcija->connect_errno): $konekcija->connect_error");
    } else {
        //ovo se zove kada korisnik udje u inbox, svim porukama READ udara na keca

        $kor_id = $konekcija->query("SELECT ID FROM korisnik K where K.USERNAME='$korisnik_ime'");


        $rezultat = $konekcija->query("UPDATE poruka P "
                . "SET READ=1"
                . "where P.RECEIVER_ID='$kor_id'");

        if ($rezultat) {

            $konekcija->close();
        } else {
            if ($konekcija->errno) {
                print ("Greška pri izvrsenju upita ($konekcija->errno): $konekcija->error");
            } else {
                print ("Nepoznata greška pri izvrsenju upita");
            }
        }
    }
}
