<?php

include_once 'lib.php';
include_once 'klase/listaIzgubljenih.php';
session_start();
$lista_izg = vrati_n_izgubljenih(5);

?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style_main.css?version=98">
    <link href="https://fonts.googleapis.com/css?family=Quantico" rel="stylesheet">
  <title>RAmBO L&F</title>
</head>

<body>

    <div id="pozadina">
        
    </div>
    
<?php include("elementi/header_main.php") ?>
    

        <div id="row1">
        <div id="lost_found_buttons_div">
            
            <form style="display: inline-block;" action="dodajIzgubljeno.php" method="post">
                <input type="submit" name="dodajIzgubljeno" value="IZGUBILI STE NEŠTO" class="button button_lost"/>
            </form>
            <form style="display: inline-block;" action="dodajNadjeno.php" method="post">
                <input type="submit" name="dodajNadjeno" value="NAŠLI STE NEŠTO" class="button button_found"/>
            </form>
        
        </div>
        </div>

        <div id="row2">
            <div class="izgubljeni_home_naslov">
                Najskorije dodate izgubljene stvari
            </div>
            <div class="stvari_u_listi_home_wrapper"> 
            <?php foreach($lista_izg->lista as $izgubljeno){?>
            <a href="izgubljena_stvar.php?naziv=<?php echo $izgubljeno->naziv ?>&korisnik=<?php echo $izgubljeno->korisnik ?>">
            <div class="stvar_u_listi_home">
                <div class="label_stvar_u_listi label_stvar_u_listi_naziv"> <?php print "$izgubljeno->naziv" ?></div><br>
                <div class="label_stvar_u_listi">Mesto: <?php print "$izgubljeno->mesto" ?></div><br>
                <div class="label_stvar_u_listi">Datum: <?php print "$izgubljeno->datum" ?></div><br>            
            </div>
             </a>
            <?php } ?>
                <div class='clear'></div>
            </div>
            <a  href="spisak_izgubljenih.php">
            
            <div class="prikazi_sve_izgubljene_div">
                Prikazi sve izgubljene stvari
            </div> 
            </a>
        </div>
        <div id="row3">
            <a  href="mapa.php">
            <div class="prikazi_sve_nadjene_div">
                Prikazi sve nadjene stvari
            </div>
            </a>
        </div>
        <div id="row4">

        </div>
    
    
    <footer>
        RAmBO © 2017 | All rights reserved.
    </footer>

</body>
</html>
