<?php

if(isset($_REQUEST['lang'])){
    if($_REQUEST['lang'] == 'eng'){
        $lang = 'eng';
        include 'Jezici/eng.php';
    }
    else{
        $lang = 'srb';
        include 'Jezici/srb.php';
    }
}
else{
    $lang = 'srb';
    include 'Jezici/srb.php';
}
include_once 'lib.php';
include_once 'klase/listaIzgubljenih.php';
include_once 'klase/listaNadjenih.php';
session_start();
$lista_izg = vrati_n_objava(5, 1);
$lista_nadj = vrati_n_objava(5, 0);

?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style_main.css?version=57">
    <link href="https://fonts.googleapis.com/css?family=Quantico" rel="stylesheet">
  <title>RAmBO L&F</title>
</head>

<body>

    <div id="pozadina">
        
    </div>
    
<?php include("elementi/header_main.php") ?>
    

        <div id="row1">
        <div id="lost_found_buttons_div">
            
            <form style="display: inline-block;" action="dodajIzgubljeno.php?lang=<?php echo $lang?>" method="post">
                <input type="submit" name="dodajIzgubljeno" value='<?php echo $L_IZG ?>' class="button button_lost"/>
            </form>
            <form style="display: inline-block;" action="dodajNadjeno.php?lang=<?php echo $lang?>" method="post">
                <input type="submit" name="dodajNadjeno" value='<?php echo $L_NDJ ?>' class="button button_found"/>
            </form>
        
        </div>
        </div>

        <div id="row2">
            <div class="izgubljeni_home_naslov">
                <?php echo $L_NDI ?>
            </div>
            <div class="stvari_u_listi_home_wrapper"> 
            <?php foreach($lista_izg->lista as $izgubljeno){?>
            <a href="izgubljena_stvar.php?naziv=<?php echo $izgubljeno->naziv ?>&korisnik=<?php echo $izgubljeno->korisnik ?>&lang=<?php echo $lang?>">
            <div class="stvar_u_listi_home orange_border">
                
                <div class="slika_objave_wrapper_home">
                 <div class="slika_objave_home">
                    <?php if($izgubljeno->slika == ""){ ?>
                     <img src="images/placeholder.jpg">
                     <?php } else{ ?>
                     <img src="uploads/<?php echo $izgubljeno->slika ?>">
                     <?php } ?>
                </div>
                </div>
                
                <div class="label_stvar_u_listi_home label_stvar_u_listi_naziv"> <?php print "$izgubljeno->naziv" ?></div><br>
                <div class="label_stvar_u_listi_home"><?php echo $L_MESTO ?> <?php print "$izgubljeno->mesto" ?></div><br>
                <div class="label_stvar_u_listi_home"><?php echo $L_DATUM ?> <?php print "$izgubljeno->datum" ?></div><br>            
            </div>
             </a>
            <?php } ?>
                <div class='clear'></div>
            </div>
            <a  href="spisak_izgubljenih.php?lang=<?php echo $lang?>">
            
            <div class="prikazi_sve_izgubljene_div">
                <?php echo $L_PSI ?>
            </div> 
            </a>
        </div>
        
    
        <div id="row3">
            <div class="izgubljeni_home_naslov">
                <?php echo $L_NDN ?>
            </div>
            <div class="stvari_u_listi_home_wrapper"> 
            <?php foreach($lista_nadj->lista as $nadjeno){?>
            <a href="nadjena_stvar.php?naziv=<?php echo $nadjeno->naziv ?>&korisnik=<?php echo $nadjeno->korisnik ?>&lang=<?php echo $lang?>">
            <div class="stvar_u_listi_home blue_border">
                
                <div class="slika_objave_wrapper_home">
                 <div class="slika_objave_home">
                    <?php if($nadjeno->slika == ""){ ?>
                     <img src="images/placeholder.jpg">
                     <?php } else{ ?>
                     <img src="uploads/<?php echo $nadjeno->slika ?>">
                     <?php } ?>
                </div>
                </div>
                
                <div class="label_stvar_u_listi_home label_stvar_u_listi_naziv"> <?php print "$nadjeno->naziv" ?></div><br>
                <div class="label_stvar_u_listi_home"><?php echo $L_MESTO ?> <?php print "$nadjeno->mesto" ?></div><br>
                <div class="label_stvar_u_listi_home"><?php echo $L_DATUM ?> <?php print"$nadjeno->datum" ?></div><br>            
            </div>
             </a>
            
            <?php } ?>
            <div class='clear'></div>
            </div>
            <a  href="spisak_nadjenih.php?lang=<?php echo $lang?>">
            <div class="prikazi_sve_nadjene_div">
                <?php echo $L_PSN ?>
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
