<?php
include_once 'lib.php';
include_once 'klase/listaIzgubljenih.php';

session_start();
$lista_izg = vrati_sve_izgubljene();
?>

<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style_main.css?version=6">
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
        <div class="left_filter_div">
            <form action="" method="post">
			
                <div class="filter_input">
                    Pretraga: <br> <input type="text" value="" name="filter_naziv">
                </div>
            </form>
        </div>
        
        
        
        <div class="content-list">
            <?php foreach($lista_izg->lista as $izgubljeno){?>
             <a href="izgubljena_stvar.php?naziv=<?php echo $izgubljeno->naziv ?>&korisnik=<?php echo $izgubljeno->korisnik ?>">
            <div class="stvar_u_listi">
                <div class="label_stvar_u_listi label_stvar_u_listi_naziv"> <?php print "$izgubljeno->naziv" ?></div><br>
                <div class="label_stvar_u_listi">Mesto: <?php print "$izgubljeno->mesto" ?></div><br>
                <div class="label_stvar_u_listi">Datum: <?php print "$izgubljeno->datum" ?></div><br>            
            </div>
             </a>
            <?php } ?>
        </div>
        <div class='clear'></div>
    </div>   
    
    
    <footer>
        RAmBO © 2017 | All rights reserved.
    </footer>

</body>
</html>


