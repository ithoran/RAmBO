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
include_once 'klase/izgubljeno.php';
session_start();

$naziv = $_GET['naziv'];
$korisnik = $_GET['korisnik'];
$izgubljeno = vrati_objavu($naziv, $korisnik, 1);

switch ($izgubljeno->tip) {
    case 'zivotinja':
        $tiploc=$L_ZIV;
        break;
    case 'uredjaj':
         $tiploc=$L_ELU;
        break;
    case 'dokument':
        $tiploc=$L_DOK;
        break;
    case 'ostalo':
        $tiploc=$L_OST;
        break;
}
?>




<html>
<head>
    <script type="text/javascript" src="http://maps.google.com/maps/api/js?libraries=drawing&key=AIzaSyB1fcu7wpjL0yYdF2OJqwCs2wFLcasVvMI"></script>
    <script type="text/javascript">
            var gmapsLat;
            var gmapsLng;
            var drawingManager;

            function initialize () {
                var map = new google.maps.Map(document.getElementById('map'), {
                    zoom: 7,
                    center: new google.maps.LatLng(document.getElementById('lat').value, document.getElementById('lng').value), // Treba da se ucitaju kordinate i tu postave
                    mapTypeId: google.maps.MapTypeId.roadmap,
                    disableDefaultUI: true,
                    zoomControl: true,
					maxZoom: 16,
					minZoom: 7
                });

                drawingManager = new google.maps.drawing.DrawingManager({
                    markerOptions: {
                        draggable: false
                    },
                    drawingControlOptions: {
                    drawingModes: []},
                    drawingControl: false,
                    map: map
                });
                
                new google.maps.Marker({
                    position: new google.maps.LatLng(document.getElementById('lat').value, document.getElementById('lng').value), // i ovde isto
                    map: map,
                    title: 'Hello World!'
                });

            }
            google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    <link rel="stylesheet" type="text/css" href="css/style_main.css?version=1?version=55">
    <link rel="stylesheet" href="css/style_forme.css?version=1">
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
        <?php if($izgubljeno->lat != 0 && $izgubljeno->lng != 0) { ?>
    <input type="hidden" id="lat" name="lat" value="<?php echo $izgubljeno->lat?>">
    <input type="hidden" id="lng" name="lng" value="<?php echo $izgubljeno->lng?>">
        <?php } ?>
        <div class="informacije_o_stvari_wrapper">
            <div class="slika_objave_wrapper">
                 <div class="slika_objave">
                    <?php if($izgubljeno->slika == ""){ ?>
                     <img src="images/placeholder.jpg">
                     <?php } else{ ?>
                     <img src="uploads/<?php echo $izgubljeno->slika ?>">
                     <?php } ?>
                </div>
            </div>
            
            <div class="informacije_o_stvari">
                <h2><?php print "$izgubljeno->naziv"?>         <span class="orange">(<?php print $L_IZGUBLJENO?>)</span></h2><hr>
                <div class="label_informacije_o_izgubljenoj_stvari">  <span class="bold_font"><?php echo $L_LOK ?></span>    <?php print "$izgubljeno->mesto" ?></div>
                <div class="label_informacije_o_izgubljenoj_stvari">  <span class="bold_font"><?php echo $L_DATUM ?></span>    <?php print "$izgubljeno->datum" ?></div><br>
                <div class="label_informacije_o_izgubljenoj_stvari">  <span class="bold_font"><?php echo $L_TIP ?>:</span>   <?php print "$tiploc" ?></div><br>
                <div class="label_informacije_o_izgubljenoj_stvari_opis">  <span class="bold_font"><?php echo $L_OPIS ?>:</span>  <br> <?php print "$izgubljeno->opis" ?></div><br>
                
                <?php if ($izgubljeno->nagrada != ""){ ?>
                <div class="label_nagrada"><?php echo $L_NAGRADALONG ?> <span class="label_nagrada_broj"><?php print "$izgubljeno->nagrada" ?></span></div><br> 
                <?php } ?>
           
                <div id="panel">
                <div id="color-palette"></div>
                </div>
                <div id="map"></div>
                
                <?php if (isset($_SESSION['f_admin']) && $_SESSION['f_admin'] == 1 || isset($_SESSION['login_user']) && $_SESSION['login_user'] == $_GET['korisnik']){?>
                
                <form class="obrisi_objavu_btn_form" action="spisak_izgubljenih.php?naziv_del=<?php echo $izgubljeno->naziv ?>&korisnik_del=<?php echo $izgubljeno->korisnik ?>&lang=<?php echo $lang?>" method="post">
                    <input type="submit" name="obrisi_izgubljeno" value='<?php echo $L_DELOBJ ?>' class="button obrisi_objavu_button">
                </form>
                
                <?php } else if(isset($_SESSION['login_user'])){ ?>
                <a href="kreiranje_poruke.php?naziv=<?php echo $izgubljeno->naziv ?>&korisnik=<?php echo $izgubljeno->korisnik ?>&lang=<?php echo $lang?>" title="<?php echo $L_POSAUTORU?>">
                <div class="posalji_poruku_icon">
                </div>
                </a>
                <form class="obrisi_objavu_btn_form" action="report.php?naziv=<?php echo $izgubljeno->naziv ?>&korisnik=<?php echo $izgubljeno->korisnik ?>&lang=<?php echo $lang?>" method="post">
                    <input type="submit" name="prijavi" value='<?php echo $L_PRIJAVI ?>' class="button obrisi_objavu_button">
                </form>
                
                <?php } ?>
                
                <div class="ime_autora"> 
                    <?php echo $izgubljeno->korisnik ?>
                </div>
            </div>
        </div>
    </div>
         
   
    <footer>
        RAmBO © 2017 | All rights reserved.
    </footer>
    
</body>
</html>
