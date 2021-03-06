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
include_once 'klase/nadjeno.php';
session_start();

$naziv = $_GET['naziv'];
$korisnik = $_GET['korisnik'];
$nadjeno = vrati_objavu($naziv, $korisnik, 0);

switch ($nadjeno->tip) {
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
    <link rel="stylesheet" type="text/css" href="css/style_main.css?version=1?version=5">
    <link rel="stylesheet" href="css/style_forme.css?version=35">
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
        <?php if($nadjeno->lat != 0 && $nadjeno->lng != 0) { ?>
    <input type="hidden" id="lat" name="lat" value="<?php echo $nadjeno->lat?>">
    <input type="hidden" id="lng" name="lng" value="<?php echo $nadjeno->lng?>">
        <?php } ?>
        <div class="informacije_o_stvari_wrapper">
            
            <div class="slika_objave_wrapper">
                 <div class="slika_objave">
                    <?php if($nadjeno->slika == ""){ ?>
                     <img src="images/placeholder.jpg">
                     <?php } else{ ?>
                     <img src="uploads/<?php echo $nadjeno->slika ?>">
                     <?php } ?>
                </div>
            </div>
            
            <div class="informacije_o_stvari">
                <h2><?php print "$nadjeno->naziv"?>         <span class="blue">(<?php print $L_NADJENO?>)</span></h2><hr>
                <div class="label_informacije_o_izgubljenoj_stvari">  <span class="bold_font"> <?php echo $L_LOK ?></span>   <?php print "$nadjeno->mesto" ?></div>
                <div class="label_informacije_o_izgubljenoj_stvari">  <span class="bold_font"><?php echo $L_DATUM ?></span>   <?php print "$nadjeno->datum" ?></div><br>
                <div class="label_informacije_o_izgubljenoj_stvari">  <span class="bold_font"><?php echo $L_TIP ?>:</span>   <?php print "$tiploc" ?></div><br>
                <div class="label_informacije_o_izgubljenoj_stvari_opis">  <span class="bold_font"><?php echo $L_OPIS ?>:</span>  <br> <?php print "$nadjeno->opis" ?></div><br>
                
                <div id="panel">
                <div id="color-palette"></div>
                </div>
                <div id="map"></div>
                
                <?php if (isset($_SESSION['f_admin']) && $_SESSION['f_admin'] == 1 || isset($_SESSION['login_user']) && $_SESSION['login_user'] == $_GET['korisnik']){?>
                <form class="obrisi_objavu_btn_form" action="spisak_nadjenih.php?naziv_del=<?php echo $nadjeno->naziv ?>&korisnik_del=<?php echo $nadjeno->korisnik ?>&lang=<?php echo $lang?>" method="post">
                    <input type="submit" name="obrisi_nadjeno" value='<?php echo $L_DELOBJ ?>' class="button obrisi_objavu_button">
                </form>
                <?php } else if(isset($_SESSION['login_user'])){ ?>
                
                <a href="kreiranje_poruke.php?naziv=<?php echo $nadjeno->naziv ?>&korisnik=<?php echo $nadjeno->korisnik ?>&lang=<?php echo $lang?>" title="<?php echo $L_POSAUTORU?>">
                <div class="posalji_poruku_icon">
                </div>
                </a>
                
                <form class="obrisi_objavu_btn_form" action="report.php?naziv=<?php echo $nadjeno->naziv ?>&korisnik=<?php echo $nadjeno->korisnik ?>&lang=<?php echo $lang?>" method="post">
                    <input type="submit" name="prijavi" value='<?php echo $L_PRIJAVI ?>' class="button obrisi_objavu_button">
                </form>
                
                <?php } ?>
                
                <div class="ime_autora"> 
                    <?php echo $nadjeno->korisnik ?>
                </div>
            </div>
        </div>
    </div>
         
   
    <footer>
        RAmBO © 2017 | All rights reserved.
    </footer>

</body>
</html>
