<?php

include_once 'lib.php';
include_once 'klase/izgubljeno.php';
session_start();

$naziv = $_GET['naziv'];
$korisnik = $_GET['korisnik'];
$izgubljeno = vrati_objavu($naziv, $korisnik, 1);

?>




<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style_main.css?version=1?version=45">
    <link rel="stylesheet" href="css/style_forme.css?version=3">
    <link href="https://fonts.googleapis.com/css?family=Quantico" rel="stylesheet">
  <title>RAmBO L&F</title>
</head>

<body>
     
    <div id="pozadina">
        
    </div>
    <div id="pozadina_filter">
        
    </div>
    
<?php include("elementi/header_main.php") ?>

    
    
    <div id="main"> 
        <div class="informacije_o_stvari_wrapper">
            <div class="informacije_o_stvari">
                <h2><?php print "$izgubljeno->naziv" ?></h2><hr>
                <div class="label_informacije_o_izgubljenoj_stvari">Mesto:  <?php print "$izgubljeno->mesto" ?></div>
                <div class="label_informacije_o_izgubljenoj_stvari">Datum:  <?php print "$izgubljeno->datum" ?></div>
                <div class="label_informacije_o_izgubljenoj_stvari">Tip:  <?php print "$izgubljeno->tip" ?></div><br>
                <?php if ($izgubljeno->nagrada != ""){ ?>
                <div class="label_nagrada">Nagrada za pronalazaca: <span class="label_nagrada_broj"><?php print "$izgubljeno->nagrada" ?></span></div><br> 
                <?php } ?>
                <?php if (isset($_SESSION['f_admin']) && $_SESSION['f_admin'] == 1 || isset($_SESSION['login_user']) && $_SESSION['login_user'] == $_GET['korisnik']){?>
                <form class="obrisi_objavu_btn_form" action="spisak_izgubljenih.php?naziv_del=<?php echo $izgubljeno->naziv ?>&korisnik_del=<?php echo $izgubljeno->korisnik ?>" method="post">
                    <input type="submit" name="obrisi_izgubljeno" value="Obrisi objavu" class="button obrisi_objavu_button">
                </form>
                <?php } ?>
            </div>
        </div>
    </div>
         
   
    <footer>
        RAmBO © 2017 | All rights reserved.
    </footer>

</body>
</html>
