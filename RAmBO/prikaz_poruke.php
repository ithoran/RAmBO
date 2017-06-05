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
include_once 'klase/poruka.php';
session_start();

$id_poruke = $_GET['id_poruke'];
$korisnik = $_GET['korisnik']; // mozda i nece treba
$por = vrati_poruku($id_poruke);

$objava= vrati_naziv_objave($por->objava_id);
$sender= vrati_ime_korisnika($por->sender_id);
$receiver= vrati_ime_korisnika($por->receiver_id);

?>




<html>
<head>
        <script type="text/javascript" src="http://maps.google.com/maps/api/js?libraries=drawing&key=AIzaSyB1fcu7wpjL0yYdF2OJqwCs2wFLcasVvMI"></script>
    <script type="text/javascript" src="js/google_maps_kreiranje.js"></script>
    <link rel="stylesheet" type="text/css" href="css/style_main.css?version=1?version=45">
    <link rel="stylesheet" href="css/style_forme.css?version=3">
    <link rel="stylesheet" href="css/style_googlemaps.css?version=113">
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
                <h2><?php print "$objava" ?></h2><hr>
                <div class="label_informacije_o_izgubljenoj_stvari">  <span class="bold_font"> <?php echo $L_POSL ?></span>   <?php print "$sender" ?></div>
                <div class="label_informacije_o_izgubljenoj_stvari">  <span class="bold_font"><?php echo $L_PRIM ?></span>   <?php print "$receiver" ?></div><br>
                <div class="label_informacije_o_izgubljenoj_stvari">  <span class="bold_font"><?php echo Text ?>:</span>   <?php print "$por->content" ?></div><br>
                <div class="label_informacije_o_izgubljenoj_stvari_opis">  <span class="bold_font"><?php echo $L_VREME ?>:</span>  <br> <?php print "$por->vreme" ?></div><br>
                
                <div id="panel">
                <div id="color-palette"></div>
                </div>
               
                
           
            </div>
        </div>
    </div>
         
   
    <footer>
        RAmBO © 2017 | All rights reserved.
    </footer>

</body>
</html>
