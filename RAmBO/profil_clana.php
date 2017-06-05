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
include_once 'klase/korisnik.php';
session_start();

$username = $_SESSION['login_user'];
$korisnik = vrati_korisnika($username);
?>




<html>
<head>
    <link rel="stylesheet" type="text/css" href="css/style_main.css?version=1?version=44">
    <link rel="stylesheet" href="css/style_forme.css?version=48">
    <link href="https://fonts.googleapis.com/css?family=Quantico" rel="stylesheet">
  <title>RAmBO L&F</title>
</head>

<body>
     
    <div id="pozadina">
        
    </div>
    <div id="pozadina_filter">
        
    </div>
    
    <header>
        <a href="index.php?lang=<?php echo $lang ?>">
        <h1 id="glavniNaslov">RAmBO <span id="lost">Lost</span>&<span id="found" >Found</span></h1>
        </a>
        <?php 
               include("elementi/logout_btn.php");
        ?>
        <div class="header_username">
            <?php print($_SESSION['login_user']) ?>
        </div>

    </header>

    
    
    <div id="main"> 
        <div class="profil_wrapper">
            <div class="informacije_profil">
                
                <div class="label_profil"><h2><?php print "$korisnik->username" ?></h2></div>
                <div class="label_profil"><?php echo $L_DRZAVA ?>:  <?php print "$korisnik->drzava" ?></div>
                <div class="label_profil">E-mail:  <?php print "$korisnik->email" ?></div>
                    <div class="btn_moje_objave_div">            
                    <form action="svoje_objave.php?lang=<?php echo $lang?>" method="post">
                        <input type="submit" class="btn_moje_objave" value="<?php echo $L_MYOBJ ?>">
                    </form>  
                    </div>
                    <div class="btn_izmeni_profil_div bold_font">
                        <a href="register.php?izmeni=1&lang=<?php echo $lang?>" title="<?php echo $L_CHACC ?>">
                            <div class="btn_izmeni_profil">
                                
                            </div>
                        </a>
            </div>
            </div>
        </div>
    </div>
         
   
    <footer>
        RAmBO © 2017 | All rights reserved.
    </footer>

</body>
</html>


