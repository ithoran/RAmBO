<?php

include_once 'lib.php';
include_once 'klase/izgubljeno.php';
session_start();

$naziv = $_GET['naziv'];
$korisnik = $_GET['korisnik'];
$izgubljeno = vrati_izgubljeno($naziv, $korisnik);

?>




<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style_main.css?version=1?version=11">
    <link href="https://fonts.googleapis.com/css?family=Quantico" rel="stylesheet">
  <title>RAmBO L&F</title>
</head>

<body>
     
    <div id="pozadina">
        
    </div>
    <div id="pozadina_filter">
        
    </div>
    
    <header>
        <a href="index.php">
        <h1 id="glavniNaslov">RAmBO <span id="lost">Lost</span>&<span id="found" >Found</span></h1>
        </a>
        <?php 
            if (isset($_SESSION['login_user'])){
               include("elementi/logout_btn.php");
        ?>
        <div class="header_username">
            <?php print($_SESSION['login_user']) ?>
        </div>
        
        <?php
            }else{
            include("elementi/login_btn.php"); 
            include("elementi/register_btn.php"); 
        }
        ?>
    </header>

    
    
    <div id="main"> 
        <div class="informacije_o_izgubljenoj_stvari_wrapper">
            <div class="informacije_o_izgubljenoj_stvari">
                <h2><?php print "$izgubljeno->naziv" ?></h2><hr>
                <div class="label_informacije_o_izgubljenoj_stvari">Mesto: <?php print "$izgubljeno->mesto" ?></div>
                <div class="label_informacije_o_izgubljenoj_stvari">Datum: <?php print "$izgubljeno->datum" ?></div>
                <div class="label_informacije_o_izgubljenoj_stvari">Tip: <?php print "$izgubljeno->tip" ?></div><br>
                <?php if ($izgubljeno->nagrada != ""){ ?>
                <div class="label_nagrada">Nagrada za pronalazaca: <span class="label_nagrada_broj"><?php print "$izgubljeno->nagrada" ?></span></div><br> 
                <?php } ?>
            </div>
        </div>
    </div>
         
   
    <footer>
        RAmBO © 2017 | All rights reserved.
    </footer>

</body>
</html>
